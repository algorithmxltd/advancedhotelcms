<?php
// processing/login.php
session_start();
header('Content-Type: application/json');
include '../includes/db_connect.php'; // mysqli connection ($conn)

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// === INPUT VALIDATION ===
$nationalId = trim($_POST['nationalId'] ?? '');
$password   = trim($_POST['password'] ?? '');

if (empty($nationalId) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// === FETCH ADMIN ===
$stmt = $conn->prepare("SELECT id, full_name, email, phone, role, national_id, password_hash, status 
                        FROM admins 
                        WHERE national_id = ? 
                        LIMIT 1");
$stmt->bind_param("s", $nationalId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}

$user = $result->fetch_assoc();

// === PASSWORD VERIFICATION ===
if (!password_verify($password, $user['password_hash'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    exit;
}

// === STATUS CHECK ===
if (strtolower($user['status']) !== 'active') {
    echo json_encode(['success' => false, 'message' => 'Account is inactive. Contact the System Admin.']);
    exit;
}

// === CREATE SECURE SESSION ===

// Generate a cryptographically strong session token
$sessionToken = bin2hex(random_bytes(32));

// Capture security info
$ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
$loginTime = date('Y-m-d H:i:s');
$expiresAt = date('Y-m-d H:i:s', strtotime('+2 hours')); // <-- expires in 2 hours

// Insert into admin_sessions table
$stmt = $conn->prepare("
    INSERT INTO admin_sessions (admin_id, session_token, ip_address, user_agent, login_time, expires_at, is_active, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
");
$stmt->bind_param("isssss", $user['id'], $sessionToken, $ip, $userAgent, $loginTime, $expiresAt);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to create session. Try again.']);
    exit;
}

// === SET SESSION IN BROWSER & PHP ===
$_SESSION['session_token'] = $sessionToken;
$_SESSION['admin_id'] = $user['id'];
$_SESSION['role'] = $user['role'];
$_SESSION['name'] = $user['full_name'];
$_SESSION['email'] = $user['email'];
$_SESSION['national_id'] = $user['national_id'];
$_SESSION['login_time'] = $loginTime;
$_SESSION['expires_at'] = $expiresAt;

// Also store session token in browser cookie for redundancy
setcookie(
    "admin_session_token",
    $sessionToken,
    [
        'expires'  => time() + 7200, // 2 hours
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']), // only over HTTPS
        'httponly' => true, // JS can't access it
        'samesite' => 'Strict'
    ]
);

// === SUCCESS RESPONSE ===
echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'redirectUrl' => 'index',
    'user' => [
        'id' => $user['id'],
        'name' => $user['full_name'],
        'role' => $user['role'],
        'email' => $user['email'],
        'national_id' => $user['national_id'],
        'phone' => $user['phone'],
        'session_token' => $sessionToken,
        'login_time' => $loginTime,
        'expires_at' => $expiresAt,
        'session_data' => [
            'session_token' => $sessionToken,
            'admin_id' => $user['id'],
            'role' => $user['role'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'national_id' => $user['national_id'],
            'login_time' => $loginTime,
            'expires_at' => $expiresAt
        ]
    ]
]);
exit;
?>