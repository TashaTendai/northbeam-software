<?php 
include 'includes/header.php'; ?>

<?php
$statusMessage = '';
$statusType = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $statusMessage = "Thanks! Your message has been sent — we'll get back to you within one business day.";
        $statusType = 'success';
    } elseif ($_GET['status'] === 'error') {
        $errors = isset($_GET['errors']) ? explode('|', urldecode($_GET['errors'])) : ['Something went wrong.'];
        $statusMessage = implode('<br>', $errors);
        $statusType = 'error';
    }
}
?>

<section class="section">
  <div class="container two-col">
    <div>
      <span class="eyebrow">Contact</span>
      <h1>Tell us what you're working on</h1>
      <p>
        Fill out the form and we'll get back to you within one business
        day. Prefer email or a call? Details are below.
      </p>

      <ul class="info-list">
        <li><span class="tag">EMAIL</span> hello@northbeam.dev</li>
        <li><span class="tag">PHONE</span> +90 123 456 78 90</li>
        <li><span class="tag">OFFICE</span> Famagusta, TRNC</li>
        <li><span class="tag">HOURS</span> Mon–Fri, 09:00–18:00 (GMT+3)</li>
      </ul>
    </div>

    <div class="form-card">
      <!--
        status: this is markup only, the form doesn't submit
        anywhere yet. later, you wire this to a PHP script that validates
        the input and inserts it into the `messages` table.
      -->
        <?php if ($statusMessage): ?>
  <div class="alert alert-<?php echo $statusType; ?>">
    <?php echo $statusMessage; ?>
  </div>
<?php endif; ?>
      <form action="includes/contact-handler.php" method="POST">
        <div class="form-row">
          <label for="name">Full name</label>
          <input type="text" id="name" name="name" placeholder="Ada Lovelace" required>
        </div>
        <div class="form-row">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="ada@company.com" required>
        </div>
        <div class="form-row">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" placeholder="New project inquiry">
        </div>
        <div class="form-row">
          <label for="message">Message</label>
          <textarea id="message" name="message" placeholder="A little about what you need..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Send message</button>
      </form>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
