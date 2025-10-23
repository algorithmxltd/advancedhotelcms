<?php
header("Content-Type: application/json");
$dbFile = __DIR__ . '/../../includes/db_connect.php';

// 🔌 DATABASE CONNECTION
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

// 🧰 HELPER FUNCTIONS
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
    if ($image === false) return false;
    $quality = ($fileSizeKB > $maxSizeKB) ? 75 : 90;
    $success = false;
    switch ($mime) {
        case 'image/jpeg': $success = imagejpeg($image, $destinationPath, $quality); break;
        case 'image/png':  $q = 9 - (int)($quality / 10); $success = imagepng($image, $destinationPath, $q); break;
        case 'image/webp': $success = imagewebp($image, $destinationPath, $quality); break;
    }
    imagedestroy($image);
    return $success;
}

// === INPUT DATA
$data  = $_POST;
$files = $_FILES;

$action = $data['action'] ?? '';
$roomId = isset($data['roomId']) && is_numeric($data['roomId']) ? (int)$data['roomId'] : 0;

if ($roomId <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'status'  => 400,
        'message' => 'Missing or invalid room ID.'
    ]);
    exit;
}

// === ACTION SWITCH
switch ($action) {

    // 🏠 UPDATE ROOM DETAILS
    case 'updateDetails':
        $required = ['roomPrice', 'roomNumber', 'roomType'];
        $missing = [];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }
        if (!empty($missing)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'status'  => 400,
                'message' => 'Missing required fields.',
                'fields'  => $missing
            ]);
            exit;
        }

        $roomPrice             = (float)$data['roomPrice'];
        $roomNumber            = trim($data['roomNumber']);
        $roomType              = trim($data['roomType']);
        $roomBriefDescription  = trim($data['roomBriefDescription'] ?? '');
        $roomAmenities         = trim($data['roomAmenities'] ?? '');
        $amenitiesEmojies      = trim($data['amenitiesEmojies'] ?? '');
        $additionalDescription = trim($data['additionalDescription'] ?? '');

        $stmt = $conn->prepare("UPDATE rooms 
                                SET roomPrice=?, roomNumber=?, roomType=?, roomBriefDescription=?, 
                                    roomAmenities=?, amenitiesEmojies=?, additionalDescription=? 
                                WHERE id=?");
        if (!$stmt) {
            log_error("Prepare failed: " . $conn->error);
            echo json_encode(["success" => false, "message" => "Database prepare error."]);
            exit;
        }

        $stmt->bind_param(
            "dssssssi",
            $roomPrice,
            $roomNumber,
            $roomType,
            $roomBriefDescription,
            $roomAmenities,
            $amenitiesEmojies,
            $additionalDescription,
            $roomId
        );
        $success = $stmt->execute();
        $stmt->close();

        echo json_encode([
            'success' => $success,
            'status'  => $success ? 200 : 500,
            'message' => $success ? 'Room details updated successfully.' : 'Failed to update room details.'
        ]);
        break;

    // 🖼️ ADD NEW IMAGES
    case 'addImage':
        if (empty($files['roomPhotos']['name'][0])) {
            echo json_encode(["success" => false, "message" => "No images uploaded."]);
            exit;
        }
        $uploadDir = __DIR__ . '/../../uploads/rooms/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imagePaths = [];

        foreach ($files['roomPhotos']['tmp_name'] as $i => $tmpName) {
            if ($files['roomPhotos']['error'][$i] !== UPLOAD_ERR_OK) continue;
            $ext = strtolower(pathinfo($files['roomPhotos']['name'][$i], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];
            if (!in_array($ext, $allowed)) continue;

            $newName = 'room_' . $roomId . '_' . uniqid() . '.' . $ext;
            $destination = $uploadDir . $newName;

            if (!compressImageIfLargerThan($tmpName, $destination)) continue;

            $relativePath = '/uploads/rooms/' . $newName;
            $imagePaths[] = $relativePath;

            $stmt = $conn->prepare("INSERT INTO roomImages (roomId, imagePath) VALUES (?, ?)");
            $stmt->bind_param("is", $roomId, $relativePath);
            $stmt->execute();
            $stmt->close();
        }

        echo json_encode([
            "success" => true,
            "status"  => 200,
            "message" => "New images added successfully.",
            "images"  => $imagePaths
        ]);
        break;

    // ❌ DELETE SINGLE IMAGE
    case 'deleteImage':
        $imageId = (int)($data['imageId'] ?? 0);
        if ($imageId <= 0) {
            echo json_encode(["success" => false, "message" => "Invalid image ID."]);
            exit;
        }

        $stmt = $conn->prepare("SELECT imagePath FROM roomImages WHERE id = ? AND roomId = ?");
        $stmt->bind_param("ii", $imageId, $roomId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $filePath = __DIR__ . '/../../' . ltrim($row['imagePath'], '/');
            if (file_exists($filePath)) unlink($filePath);

            $stmtDel = $conn->prepare("DELETE FROM roomImages WHERE id = ?");
            $stmtDel->bind_param("i", $imageId);
            $stmtDel->execute();
            $stmtDel->close();

            echo json_encode(["success" => true, "message" => "Image deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Image not found."]);
        }
        $stmt->close();
        break;

    // 🗑️ DELETE ENTIRE ROOM
    case 'deleteRoom':
        $stmt = $conn->prepare("SELECT imagePath FROM roomImages WHERE roomId = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $path = __DIR__ . '/../../' . ltrim($row['imagePath'], '/');
            if (file_exists($path)) unlink($path);
        }
        $stmt->close();

        $conn->query("DELETE FROM roomImages WHERE roomId = $roomId");
        $deleted = $conn->query("DELETE FROM rooms WHERE id = $roomId");

        echo json_encode([
            "success" => $deleted,
            "status"  => $deleted ? 200 : 500,
            "message" => $deleted ? "Room deleted successfully." : "Failed to delete room."
        ]);
        break;

    default:
        echo json_encode(["success" => false, "message" => "Invalid or missing action."]);
        break;
}

$conn->close();
?>
