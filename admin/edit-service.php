<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: manage-services.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage-services.php");
    exit;
}

$service = $result->fetch_assoc();
$stmt->close();
$conn->close();

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
<title>Edit Service — Northbeam Software</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container" style="max-width: 600px; padding-top: 40px;">
  <h1>Edit Service</h1>

  <?php if ($error): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <div class="form-card">
    <form action="edit-service-handler.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo (int) $service['id']; ?>">

      <div class="form-row">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($service['title']); ?>" required>
      </div>
      <div class="form-row">
        <label for="description">Description</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
      </div>
      <div class="form-row">
  <label for="image">Current image</label>
  <img src="../<?php echo htmlspecialchars($service['image']); ?>" alt="Current service image" style="max-width:160px; border-radius:8px; margin-bottom:12px; display:block;">

  <label for="image">Replace image (optional)</label>
  <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
  <p style="font-size:.8rem; color:var(--muted); margin-top:4px;">Leave empty to keep the current image.</p>
</div>
      <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Save Changes</button>
    </form>
  </div>

  <a href="manage-services.php" class="btn btn-ghost" style="margin-top:16px;">← Back to Services</a>
</div>

</body>
</html>