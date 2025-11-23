<?php
// db_connect.php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // set your password
$DB_NAME = 'mini_fb';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// helper to check logged in
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../signin.php');
        exit;
    }
}
?>
