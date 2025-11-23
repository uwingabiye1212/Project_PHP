<?php
// signup.php
require_once 'db_connect.php';

$errors = [];
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Validation
    if ($username === '') $errors[] = 'Username is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Password and confirmation must match.';

    if (empty($errors)) {
        // Check unique username/email
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=? OR email=? LIMIT 1");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = 'Username or email already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
            $ins->bind_param('sss', $username, $email, $hash);
            if ($ins->execute()) {
                // auto-login
                $_SESSION['user_id'] = $ins->insert_id;
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
                exit;
            } else {
                $errors[] = 'Failed to create account. Try again.';
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
  <title>Sign Up - Mini Facebook</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h1>MiniFacebook</h1>
    <div class="nav"><a href="signin.php">Sign In</a></div>
  </div>

  <h2>Create account</h2>

  <?php if (!empty($errors)): ?>
    <div class="error">
      <?php foreach ($errors as $e) echo htmlspecialchars($e)."<br>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="form-group">
      <input type="text" name="username" placeholder="Username" value="<?=htmlspecialchars($username)?>">
    </div>
    <div class="form-group">
      <input type="email" name="email" placeholder="Email" value="<?=htmlspecialchars($email)?>">
    </div>
    <div class="form-group">
      <input type="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
      <input type="password" name="confirm_password" placeholder="Confirm Password">
    </div>

    <button class="btn-primary" type="submit">Sign Up</button>
  </form>
</div>
</body>
</html>
