<?php
include 'includes/header.php';
include 'includes/db.php';

$services = [];
$result = $conn->query("SELECT * FROM services ORDER BY created_at ASC");
while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}
$conn->close();
?>
<?php
function getServiceIcon($title) {
    $title = strtolower($title);
    if (strpos($title, 'cloud') !== false || strpos($title, 'devops') !== false) return '☁️';
    if (strpos($title, 'consult') !== false) return '💡';
    if (strpos($title, 'custom') !== false || strpos($title, 'software') !== false) return '🛠️';
    if (strpos($title, 'integration') !== false) return '🔗';
    if (strpos($title, 'website') !== false || strpos($title, 'design') !== false) return '🎨';
    if (strpos($title, 'support') !== false || strpos($title, 'maintenance') !== false) return '🔧';
    return '⚙️'; // fallback for anything unmatched
}
?>
<section class="section">
  <div class="container">
    <div class="section-head">
      <span class="eyebrow">Services</span>
      <h1>What we can take off your plate</h1>
      <p>Pick one, or start with a consulting call if you're not sure what you need yet.</p>
    </div>

    <div class="grid">
      <?php foreach ($services as $i => $service): ?>
    <div class="card">
  <img src="<?php echo htmlspecialchars($service["image"]); ?>" alt="<?php echo htmlspecialchars($service["title"]); ?>" style="width:100%; height:160px; object-fit:cover; border-radius:8px; margin-bottom:16px;">
  <span class="idx" style="font-size:1.6rem; -webkit-font-smoothing:auto;"><?php echo getServiceIcon($service["title"]); ?></span>
  <h3><?php echo htmlspecialchars($service["title"]); ?></h3>
  <p><?php echo htmlspecialchars($service["description"]); ?></p>
</div>
<?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container" style="text-align:center;">
    <h2>Not sure which fits?</h2>
    <p style="max-width:52ch; margin:0 auto 24px;">
      Send us a short note about what's going on and we'll point you in
      the right direction — no obligation.
    </p>
    <a href="contact.php" class="btn btn-primary">Talk to us</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
