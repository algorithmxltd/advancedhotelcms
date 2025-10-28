<?php
header("Content-Type: application/json");

// === DATABASE CONNECTION
$dbFile = __DIR__ . '/../../includes/db_connect.php';
if (!file_exists($dbFile)) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "status"  => 500,
        "message" => "Database connection file not found."
    ]);
    exit;
}

require_once $dbFile;
$conn->set_charset("utf8mb4");

// === SETTINGS
ini_set('display_errors', 0);  // Don't expose errors to user
ini_set('log_errors', 1);
error_reporting(E_ALL);

// === HELPER: LOGGING
function log_error($message) {
    $logFile = __DIR__ . '/error.txt';
    $timestamp = date('Y-m-d H:i:s');
    error_log("[$timestamp] $message\n", 3, $logFile);
}

// === HELPER: IMAGE COMPRESSION
function compressImageIfLargerThan($tmpPath, $destinationPath, $maxSizeKB = 800) {
    if (!extension_loaded('gd')) {
        log_error("GD extension not loaded");
        return false;
    }

    $info = getimagesize($tmpPath);
    if ($info === false) {
        log_error("Invalid image: getimagesize failed on $tmpPath");
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
        log_error("Failed to create image resource from $tmpPath");
        return false;
    }

    $quality = ($fileSizeKB > $maxSizeKB) ? 75 : 90;
    $success = false;

    switch ($mime) {
        case 'image/jpeg':
            $success = imagejpeg($image, $destinationPath, $quality);
            break;
        case 'image/png':
            $q = max(0, min(9, 9 - (int)($quality / 10)));
            $success = imagepng($image, $destinationPath, $q);
            break;
        case 'image/webp':
            $success = imagewebp($image, $destinationPath, $quality);
            break;
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

// === DEBUG LOG START OF REQUEST
log_error("ACTION: $action | roomId: $roomId | Files count: " . count($files['roomPhotos']['name'] ?? []));

// === ACTION SWITCH
switch ($action) {

    // ================================================================
    // UPDATE ROOM DETAILS + ADD IMAGES
    // ================================================================
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

        // === UPDATE ROOM DETAILS
        $roomPrice             = (float)$data['roomPrice'];
        $roomNumber            = trim($data['roomNumber']);
        $roomType              = trim($data['roomType']);
        $roomBriefDescription  = trim($data['roomBriefDescription'] ?? '');
        $roomAmenities         = trim($data['roomAmenities'] ?? '');
        $amenitiesEmojies      = trim($data['amenitiesEmojies'] ?? '');
        $additionalDescription = trim($data['additionalDescription'] ?? '');

        $stmt = $conn->prepare("
            UPDATE rooms 
            SET roomPrice=?, roomNumber=?, roomType=?, roomBriefDescription=?, 
                roomAmenities=?, amenitiesEmojies=?, additionalDescription=? 
            WHERE id=?
        ");

        if (!$stmt) {
            log_error("Prepare failed (update rooms): " . $conn->error);
            echo json_encode(["success" => false, "message" => "Database error."]);
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

        if (!$success) {
            log_error("Failed to update room ID $roomId");
            echo json_encode([
                'success' => false,
                'status'  => 500,
                'message' => 'Failed to update room details.'
            ]);
            exit;
        }

        // === PROCESS NEW IMAGES
        $imagePaths = [];

        if (!empty($files['roomPhotos']['name'][0])) {
            $uploadDir = __DIR__ . '/../../uploads/rooms/';
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                log_error("Failed to create upload directory: $uploadDir");
            }

            foreach ($files['roomPhotos']['tmp_name'] as $i => $tmpName) {
                // Skip upload errors
                if ($files['roomPhotos']['error'][$i] !== UPLOAD_ERR_OK) {
                    log_error("Upload error [{$files['roomPhotos']['error'][$i]}] for file index $i");
                    continue;
                }

                $originalName = $files['roomPhotos']['name'][$i];
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($ext, $allowed)) {
                    log_error("Disallowed file extension: $ext ($originalName)");
                    continue;
                }

                $newName = 'room_' . $roomId . '_' . uniqid() . '.' . $ext;
                $destination = $uploadDir . $newName;
                $relativePath = '/uploads/rooms/' . $newName;

                // === COMPRESS & SAVE
                if (!compressImageIfLargerThan($tmpName, $destination)) {
                    log_error("Failed to compress/save image: $originalName");
                    continue;
                }

                if (!file_exists($destination)) {
                    log_error("File not created after compression: $destination");
                    continue;
                }

                // === PREVENT DUPLICATE INSERT (DB + in-memory)
                if (in_array($relativePath, $imagePaths)) {
                    log_error("Duplicate path skipped (in-memory): $relativePath");
                    continue;
                }

                $checkStmt = $conn->prepare("SELECT 1 FROM roomImages WHERE roomId = ? AND imagePath = ?");
                $checkStmt->bind_param("is", $roomId, $relativePath);
                $checkStmt->execute();
                $exists = $checkStmt->get_result()->num_rows > 0;
                $checkStmt->close();

                if ($exists) {
                    log_error("Image already in DB: $relativePath");
                    continue;
                }

                // === INSERT INTO DB
                $insertStmt = $conn->prepare("INSERT INTO roomImages (roomId, imagePath) VALUES (?, ?)");
                if (!$insertStmt) {
                    log_error("Insert prepare failed: " . $conn->error);
                    continue;
                }

                $insertStmt->bind_param("is", $roomId, $relativePath);
                if ($insertStmt->execute()) {
                    $imagePaths[] = $relativePath;
                    log_error("Image saved: $relativePath");
                } else {
                    log_error("DB insert failed for: $relativePath");
                }
                $insertStmt->close();
            }
        }

        // === FINAL RESPONSE
        echo json_encode([
            'success' => true,
            'status'  => 200,
            'message' => !empty($imagePaths)
                ? 'Room updated with new images.'
                : 'Room details updated successfully.',
            'images'  => $imagePaths
        ]);
        break;


    // ================================================================
    // DELETE SINGLE IMAGE
    // ================================================================
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
            if (file_exists($filePath)) {
                unlink($filePath);
                log_error("Deleted file: $filePath");
            }

            $stmtDel = $conn->prepare("DELETE FROM roomImages WHERE id = ?");
            $stmtDel->bind_param("i", $imageId);
            $deleted = $stmtDel->execute();
            $stmtDel->close();

            echo json_encode([
                "success" => $deleted,
                "status"  => $deleted ? 200 : 500,
                "message" => $deleted ? "Image deleted." : "Failed to delete image."
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Image not found."]);
        }
        $stmt->close();
        break;


    // ================================================================
    // DELETE ENTIRE ROOM
    // ================================================================
    case 'deleteRoom':
        $stmt = $conn->prepare("SELECT imagePath FROM roomImages WHERE roomId = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $path = __DIR__ . '/../../' . ltrim($row['imagePath'], '/');
            if (file_exists($path)) {
                unlink($path);
                log_error("Deleted room image: $path");
            }
        }
        $stmt->close();

        // Use prepared statements for safety
        $conn->query("DELETE FROM roomImages WHERE roomId = " . (int)$roomId);
        $deleteRoom = $conn->prepare("DELETE FROM rooms WHERE id = ?");
        $deleteRoom->bind_param("i", $roomId);
        $deleted = $deleteRoom->execute();
        $deleteRoom->close();

        echo json_encode([
            "success" => $deleted,
            "status"  => $deleted ? 200 : 500,
            "message" => $deleted ? "Room deleted successfully." : "Failed to delete room."
        ]);
        break;


    // ================================================================
    // DEFAULT: INVALID ACTION
    // ================================================================
    default:
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid or missing action."]);
        break;
}

// === CLOSE CONNECTION
$conn->close();
?>