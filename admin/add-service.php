<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$error = '';
if (isset($_GET['error'])) {
    $error = urldecode($_GET['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Service — Northbeam Software</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container" style="max-width: 600px; padding-top: 40px;">
  <h1>Add New Service</h1>

  <?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <div class="form-card">
    <form action="add-service-handler.php" method="POST" enctype="multipart/form-data">
      <div class="form-row">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
      </div>
      <div class="form-row">
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
      </div>
      <div class="form-row">
  <label for="image"> Service image (optional) </label>
  <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
</div>
      <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Add Service</button>
    </form>
  </div>

  <a href="manage-services.php" class="btn btn-ghost" style="margin-top:16px;">← Back to Services</a>
</div>

</body>
</html>