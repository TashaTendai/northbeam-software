<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
include '../includes/db.php';

// Fetch all messages, newest first
$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — Northbeam Software</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container" style="padding-top: 40px;">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 24px;">
  <h1>Messages</h1>
  <div>
    <span style="margin-right:16px; color: var(--muted);">
      Logged in as <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
    </span>
    <a href="manage-services.php" class="btn btn-ghost" style="margin-right:12px;">Manage Services</a>
    <a href="logout.php" class="btn btn-ghost">Log out</a>
  </div>
</div>

  <?php if ($result->num_rows === 0): ?>
    <p>No messages yet.</p>
  <?php else: ?>
    <div style="display:flex; flex-direction:column; gap:16px;">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card" style="<?php echo $row['is_read'] == 0 ? 'border-left: 4px solid var(--accent);' : ''; ?>">
          <div style="display:flex; justify-content:space-between; align-items:start;">
            <div>
              <strong><?php echo htmlspecialchars($row['name']); ?></strong>
              <span style="color: var(--muted); margin-left:8px;"><?php echo htmlspecialchars($row['email']); ?></span>
            </div>
            <span style="font-family: var(--font-mono); font-size:.8rem; color: var(--muted);">
              <?php echo htmlspecialchars($row['submitted_at']); ?>
            </span>
          </div>

          <?php if (!empty($row['subject'])): ?>
            <p style="font-weight:600; margin-top:12px; margin-bottom:4px;">
              <?php echo htmlspecialchars($row['subject']); ?>
            </p>
          <?php endif; ?>

          <p style="margin-top:8px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>

          <?php if ($row['is_read'] == 0): ?>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
        <span class="eyebrow" style="color: var(--status-amber);">UNREAD</span>
        <a href="mark-read.php?id=<?php echo $row['id']; ?>" class="btn btn-ghost" style="padding:6px 14px; font-size:.85rem;">
            Mark as read
        </a>
    </div>
<?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>

</body>
</html>