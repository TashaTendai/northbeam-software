<?php
session_start();

// If already logged in, skip the login form and go straight to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if (isset($_GET['error'])) {
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Northbeam Software</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container" style="max-width: 420px; padding-top: 80px;">
  <div class="form-card">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login-handler.php" method="POST">
      <div class="form-row">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Log In</button>
    </form>
  </div>
</div>

</body>
</html>