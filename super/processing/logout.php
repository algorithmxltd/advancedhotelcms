<?php
// processing/logout.php
session_start();
header('Content-Type: application/json');

include '../includes/db_connect.php'; // mysqli connection ($conn)

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

try {
    // Get session token from POST or PHP session
    $sessionToken = $_POST['session_token'] ?? $_SESSION['session_token'] ?? null;

    if ($sessionToken) {
        // Invalidate session in DB: set is_active = 0, set logout_time, update timestamp
        $logoutTime = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("
            UPDATE admin_sessions 
            SET is_active = 0, 
                logout_time = ?, 
                updated_at = NOW() 
            WHERE session_token = ? AND is_active = 1
        ");
        $stmt->bind_param("ss", $logoutTime, $sessionToken);
        $stmt->execute();
    }

    // Clear PHP session variables
    $_SESSION = [];

    // Destroy PHP session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy PHP session
    session_destroy();

    // Clear admin session cookie in browser
    setcookie(
        "admin_session_token",
        "",
        time() - 3600,
        "/",
        "", // domain
        isset($_SERVER['HTTPS']),
        true // httponly
    );

    echo json_encode([
        'success' => true,
        'message' => 'Logout successful'
    ]);
    
} catch (Exception $e) {
    // Ensure session cleanup even if DB fails
    $_SESSION = [];
    session_destroy();
    setcookie("admin_session_token", "", time() - 3600, "/");

    echo json_encode([
        'success' => false,
        'message' => 'Logout completed with warnings: ' . $e->getMessage()
    ]);
}

exit;
?>
