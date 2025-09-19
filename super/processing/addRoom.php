<?php
header("Content-Type: application/json");
$dbFile = __DIR__ . '/../../includes/db_connect.php';

if (file_exists($dbFile)) {
    require_once $dbFile;
} else {
    // Return JSON error response
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection file not found."
    ]);
    exit;
}


$conn->set_charset("utf8mb4");

ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

function log_error($message) {
    $logFile = __DIR__ . '/error.txt';
    $timestamp = date('Y-m-d H:i:s');
    error_log("[$timestamp] $message\n", 3, $logFile);
}

function compressImageIfLargerThan($tmpPath, $destinationPath, $maxSizeKB = 800) {
    if (!extension_loaded('gd')) {
        log_error("GD extension not loaded");
        return false;
    }

    $info = getimagesize($tmpPath);
    if ($info === false) {
        log_error("Invalid image file");
        return false;
    }

    $mime = $info['mime'];
    $fileSizeKB = filesize($tmpPath) / 1024;

    switch ($mime) {
        case 'image/jpeg': $image = imagecreatefromjpeg($tmpPath); break;
        case 'image/png':  $image = imagecreatefrompng($tmpPath);  break;
        case 'image/webp': $image = imagecreatefromwebp($tmpPath); break;
        default:
            log_error("Unsupported image type: $mime");
            return false;
    }

    if ($image === false) {
        log_error("Failed to create image resource");
        return false;
    }

    $quality = ($fileSizeKB > $maxSizeKB) ? 75 : 90;
    $success = false;

    switch ($mime) {
        case 'image/jpeg': $success = imagejpeg($image, $destinationPath, $quality); break;
        case 'image/png':  $quality = 9 - (int)($quality / 10); $success = imagepng($image, $destinationPath, $quality); break;
        case 'image/webp': $success = imagewebp($image, $destinationPath, $quality); break;
    }

    imagedestroy($image);
    return $success;
}

// === INPUT DATA ===
$data = $_POST;
$files = $_FILES;

// Debugging
file_put_contents('debug_data.log', print_r($data, true));
file_put_contents('debug_files.log', print_r($files, true));

// === REQUIRED FIELDS ===
$required = ['roomPrice', 'roomNumber', 'roomType'];
$missing = [];

foreach ($required as $field) {
    if (empty($data[$field])) {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    log_error("Missing fields: " . implode(', ', $missing));
    echo json_encode([
        'success' => false,
        'status' => '400',
        'message' => 'Missing required fields',
        'fields' => $missing
    ]);
    exit;
}

// === SANITIZE INPUTS ===
$roomPrice             = (float) $data['roomPrice'];
$roomNumber            = trim($data['roomNumber']);
$roomType              = trim($data['roomType']);
$roomBriefDescription  = trim($data['roomBriefDescription'] ?? '');
$roomAmenities         = trim($data['roomAmenities'] ?? '');
$amenitiesEmojies      = trim($data['amenitiesEmojies'] ?? '');
$additionalDescription = trim($data['additionalDescription'] ?? '');

// === INSERT ROOM ===
$stmt = $conn->prepare("INSERT INTO rooms (roomPrice, roomNumber, roomType, roomBriefDescription, roomAmenities, amenitiesEmojies, additionalDescription) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    log_error("DB prepare error: " . $conn->error);
    echo json_encode(['success' => false, 'message' => 'DB error']);
    exit;
}

$stmt->bind_param("dssssss", $roomPrice, $roomNumber, $roomType, $roomBriefDescription, $roomAmenities, $amenitiesEmojies, $additionalDescription);

if (!$stmt->execute()) {
    log_error("DB execution error: " . $stmt->error);
    echo json_encode(['success' => false, 'message' => 'Failed to save room']);
    exit;
}

$roomId = $conn->insert_id;
$stmt->close();

// === HANDLE MULTIPLE IMAGE UPLOADS ===
$imagePaths = [];
if (!empty($files['roomPhotos']['name'][0])) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/rooms/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            log_error("Failed to create upload directory");
            echo json_encode(['success' => false, 'message' => 'Upload directory error']);
            exit;
        }
    }

    foreach ($files['roomPhotos']['tmp_name'] as $index => $tmpName) {
        if ($files['roomPhotos']['error'][$index] !== UPLOAD_ERR_OK) continue;

        $originalName = basename($files['roomPhotos']['name'][$index]);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            log_error("Invalid image extension: $ext");
            continue;
        }

        $newName = 'room_' . $roomId . '_' . time() . '_' . uniqid() . '.' . $ext;
        $destination = $uploadDir . $newName;

        if (!compressImageIfLargerThan($tmpName, $destination)) {
            log_error("Image compression failed: $originalName");
            continue;
        }

        $relativePath = '/uploads/rooms/' . $newName;
        $imagePaths[] = $relativePath;

        // Save to DB
        $stmtImg = $conn->prepare("INSERT INTO roomImages (roomId, imagePath) VALUES (?, ?)");
        $stmtImg->bind_param("is", $roomId, $relativePath);
        $stmtImg->execute();
        $stmtImg->close();
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Room added successfully',
    'room_id' => $roomId,
    'images' => $imagePaths
]);

$conn->close();
?>
