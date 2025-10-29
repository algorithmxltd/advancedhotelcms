<?php
// auth.php — Secure session validator with role-based access
session_start();
include 'includes/db_connect.php';

// --- CONFIG ---
$sessionTimeout = 3600; // 1 hour

// --- Step 1: Verify session existence ---
if (!isset($_SESSION['session_token']) || !isset($_SESSION['admin_id'])) {
    header("Location: login");
    exit();
}

$session_token = $_SESSION['session_token'];
$admin_id = $_SESSION['admin_id'];

// --- Step 2: Check session validity in database ---
$stmt = $conn->prepare("
    SELECT s.session_id, s.expires_at, s.session_token, a.id, a.full_name, a.email, a.phone, a.role
    FROM admin_sessions AS s
    INNER JOIN admins AS a ON a.id = s.admin_id
    WHERE s.session_token = ? AND s.admin_id = ? AND s.is_active = 1
    LIMIT 1
");
$stmt->bind_param("si", $session_token, $admin_id);
$stmt->execute();
$result = $stmt->get_result();

// --- Step 3: If session not found ---
if ($result->num_rows === 0) {
    session_unset();
    session_destroy();
    header("Location: login");
    exit();
}

$user = $result->fetch_assoc();

// --- Step 4: Check expiration ---
if (strtotime($user['expires_at']) < time()) {
    // Expired session
    $update = $conn->prepare("UPDATE admin_sessions SET is_active = 0 WHERE session_token = ?");
    $update->bind_param("s", $session_token);
    $update->execute();

    session_unset();
    session_destroy();
    header("Location: login?expired=1");
    exit();
}

// --- Step 5: Optional: refresh expiration time on activity ---
$new_expiry = date('Y-m-d H:i:s', time() + $sessionTimeout);
$update = $conn->prepare("UPDATE admin_sessions SET expires_at = ? WHERE session_token = ?");
$update->bind_param("ss", $new_expiry, $session_token);
$update->execute();

// --- Step 6: Define constants or global variables ---
define("AUTH_USER_ID", $user['id']);
define("AUTH_USER_NAME", $user['full_name']);
define("AUTH_USER_EMAIL", $user['email']);
define("AUTH_USER_PHONE", $user['phone']);
define("AUTH_USER_ROLE", $user['role']);

// --- Step 7: Role-based access control (example) ---
// You can change this depending on page role requirement
$requiredRoles = ['System Admin', 'Manager']; // allowed roles for this page

if (!in_array(AUTH_USER_ROLE, $requiredRoles)) {
    header("Location: /login?unauthorized=1");
    exit();
}

// --- Step 8: Continue execution if everything is valid ---
?>
