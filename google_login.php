<?php
// google_login.php
require_once 'db_connect.php';

// Mock Google login: in a real app you'd use OAuth flow.
// Here we simulate a Google user. We'll create (or find) a user with a special email.

$googleEmail = 'google_user@example.com';
$googleUsername = 'google_user';

// check user exists
$stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param('s', $googleEmail);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    // create user with a random password (not used)
    $randomPassword = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
    $ins = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
    $ins->bind_param('sss', $googleUsername, $googleEmail, $randomPassword);
    $ins->execute();
    $user_id = $ins->insert_id;
    $ins->close();
} else {
    $user = $res->fetch_assoc();
    $user_id = $user['id'];
    $googleUsername = $user['username'];
}

$_SESSION['user_id'] = $user_id;
$_SESSION['username'] = $googleUsername;

header('Location: dashboard.php');
exit;
