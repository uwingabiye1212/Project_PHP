<?php
// signin.php
require_once 'db_connect.php';

$errors = [];
$identifier = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($identifier === '' || $password === '') {
        $errors[] = 'All fields are required.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 0) {
            $errors[] = 'Account not found.';
        } else {
            $user = $res->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php');
                exit;
            } else {
                $errors[] = 'Wrong password.';
            }
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sign In - Mini Facebook</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h1>MiniFacebook</h1>
    <div class="nav"><a href="signup.php">Create account</a></div>
  </div>

  <h2>Sign In</h2>

  <?php if (!empty($errors)): ?>
    <div class="error">
      <?php foreach ($errors as $e) echo htmlspecialchars($e)."<br>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="form-group">
      <input type="text" name="identifier" placeholder="Username or Email" value="<?=htmlspecialchars($identifier)?>">
    </div>
    <div class="form-group">
      <input type="password" name="password" placeholder="Password">
    </div>

    <button class="btn-primary" type="submit">Sign In</button>
  </form>

  <hr>
  <form method="post" action="google_login.php" style="margin-top:10px;">
    <button type="submit" class="btn-google">
      <img src="https://www.gstatic.com/images/branding/product/1x/googlelogo_color_74x24dp.png" alt="G" style="height:18px;">
      Login with Google
    </button>
  </form>
</div>
</body>
</html>
