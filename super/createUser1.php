<?php
include '../includes/db_connect.php';
header('Content-Type: application/json');

// Hardcoded Super Admin details
$full_name   = 'Wanjau Kevin Magu';
$national_id = '39921136';
$email       = 'wanjaukevinmagu@gmail.com';
$phone       = '0797692537';
$role        = 'System Admin';

// Security and system fields
$password_hash = password_hash($national_id, PASSWORD_DEFAULT);
$status        = 'Active';
$last_login    = NULL;
$last_login_ip = NULL;
$session_token = NULL;
$created_by    = NULL; // First super admin has no creator
$created_at    = date('Y-m-d H:i:s');
$updated_at    = NULL;
$deleted_at    = NULL;

// Prepare SQL
$sql = "INSERT INTO admins 
(full_name, national_id, email, phone, role, password_hash, status, 
 last_login, last_login_ip, session_token, created_by, created_at, updated_at, deleted_at)
VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL, NULL, ?, ?, NULL, NULL)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['status' => 'error', 'message' => 'SQL Prepare Error: ' . $conn->error]));
}

// Bind parameters
$stmt->bind_param(
    "sssssssis",
    $full_name,
    $national_id,
    $email,
    $phone,
    $role,
    $password_hash,
    $status,
    $created_by,
    $created_at
);

// Execute query
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Super Admin created successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
