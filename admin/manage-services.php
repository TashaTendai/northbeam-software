<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include '../includes/db.php';

$result = $conn->query("SELECT * FROM services ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Services — Northbeam Software</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container" style="padding-top: 40px;">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
    <h1>Manage Services</h1>
    <div>
      <a href="dashboard.php" class="btn btn-ghost" style="margin-right:12px;">Back to Messages</a>
      <a href="logout.php" class="btn btn-ghost">Log out</a>
    </div>
  </div>

 <a href="add-service.php" class="btn btn-primary" style="margin-bottom:24px;">+ Add New Service</a>

  <?php if ($result->num_rows === 0): ?>
    <p>No services yet.</p>
  <?php else: ?>
    <div style="display:flex; flex-direction:column; gap:16px;">
      <?php while ($row = $result->fetch_assoc()): ?>
  <div class="card" style="display:flex; justify-content:space-between; align-items:center; gap:20px;">
    <img src="../<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width:80px; height:80px; object-fit:cover; border-radius:8px; flex-shrink:0;">
    <div style="flex-grow:1;">
      <strong><?php echo htmlspecialchars($row['title']); ?></strong>
      <p style="margin:6px 0 0; max-width:60ch;">
        <?php echo htmlspecialchars($row['description']); ?>
      </p>
      <span style="font-family: var(--font-mono); font-size:.75rem; color: var(--muted);">
        Added <?php echo htmlspecialchars($row['created_at']); ?>
      </span>
    </div>
    <div style="display:flex; gap:10px; flex-shrink:0;">
      <a href="edit-service.php?id=<?php echo $row['id']; ?>" class="btn btn-ghost">Edit</a>
      <a href="delete-service.php?id=<?php echo $row['id']; ?>" class="btn btn-ghost" onclick="return confirm('Are you sure you want to delete this service? This cannot be undone.');">Delete</a>
    </div>
  </div>
<?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

</body>
</html>