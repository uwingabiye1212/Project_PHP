<?php
// dashboard.php
require_once 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}
$username = htmlspecialchars($_SESSION['username']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - Mini Facebook</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h1>MiniFacebook</h1>
    <div class="nav">
      <span>Hello, <?=$username?></span>
      <a href="posts/posts.php">Posts</a>
      <a href="insert1.php">insert</a>
      <a href="logout.php">Logout</a>
      <a href="display.php">display</a>
      <a href="update.php">update</a>
    </div>
  </div>

  <h2>Welcome, <?=$username?></h2>
  <p>This is a simplified social home page. Click "Posts" to create and manage posts (CRUD).</p>
</div>
</body>
</html>
