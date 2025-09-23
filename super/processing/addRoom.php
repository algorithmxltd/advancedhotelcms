<?php
header("Content-Type: application/json");
$dbFile = __DIR__ . '/../../includes/db_connect.php';

if (file_exists($dbFile)) {
    require_once $dbFile;
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "status"  => 500,
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

// === REQUIRED FIELDS ===
$required = ['roomPrice', 'roomNumber', 'roomType'];
$missing = [];
foreach ($required as $field) {
    if (empty($data[$field])) {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    http_response_code(400);
    log_error("Missing fields: " . implode(', ', $missing));
    echo json_encode([
        'success' => false,
        'status'  => 400,
        'message' => 'Missing required fields',
        'fields'  => $missing
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

// === CHECK UNIQUE ROOM NUMBER ===
$stmtCheck = $conn->prepare("SELECT id FROM rooms WHERE roomNumber = ? LIMIT 1");
$stmtCheck->bind_param("s", $roomNumber);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
if ($result && $result->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'status'  => 409,
        'message' => "Room number '$roomNumber' already exists. Please edit that room or choose another number."
    ]);
    exit;
}
$stmtCheck->close();

// === START TRANSACTION ===
$conn->begin_transaction();

try {
    // Insert room
    $stmt = $conn->prepare("INSERT INTO rooms (roomPrice, roomNumber, roomType, roomBriefDescription, roomAmenities, amenitiesEmojies, additionalDescription) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("DB prepare error: " . $conn->error);
    }

    $stmt->bind_param("dssssss", $roomPrice, $roomNumber, $roomType, $roomBriefDescription, $roomAmenities, $amenitiesEmojies, $additionalDescription);

    if (!$stmt->execute()) {
        throw new Exception("DB execution error: " . $stmt->error);
    }

    $roomId = $conn->insert_id;
    $stmt->close();

    // Handle images
    $imagePaths = [];
    if (!empty($files['roomPhotos']['name'][0])) {
        $uploadDir = __DIR__ . '/../../uploads/rooms/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                throw new Exception("Failed to create upload directory: $uploadDir (user: " . get_current_user() . ")");
            }
        }

        foreach ($files['roomPhotos']['tmp_name'] as $index => $tmpName) {
            if ($files['roomPhotos']['error'][$index] !== UPLOAD_ERR_OK) continue;

            $originalName = basename($files['roomPhotos']['name'][$index]);
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                throw new Exception("Invalid image extension: $ext");
            }

            $newName = 'room_' . $roomId . '_' . time() . '_' . uniqid() . '.' . $ext;
            $destination = $uploadDir . $newName;

            if (!compressImageIfLargerThan($tmpName, $destination)) {
                throw new Exception("Image compression failed: $originalName");
            }

            $relativePath = '/uploads/rooms/' . $newName;
            $imagePaths[] = $relativePath;

            $stmtImg = $conn->prepare("INSERT INTO roomImages (roomId, imagePath) VALUES (?, ?)");
            if (!$stmtImg) {
                throw new Exception("DB prepare error (images): " . $conn->error);
            }
            $stmtImg->bind_param("is", $roomId, $relativePath);
            if (!$stmtImg->execute()) {
                throw new Exception("DB execution error (images): " . $stmtImg->error);
            }
            $stmtImg->close();
        }
    }

    // Commit if everything is fine
    $conn->commit();

    echo json_encode([
        'success' => true,
        'status'  => 200,
        'message' => 'Room added successfully',
        'room_id' => $roomId,
        'images'  => $imagePaths
    ]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    log_error($e->getMessage());
    echo json_encode([
        'success' => false,
        'status'  => 500,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close();
