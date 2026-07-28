<?php
//practice: a variable + echo, used to auto-update the copyright year
$currentYear = date("Y");
?>
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <h4><?php echo $siteName; ?></h4>
        <p style="color:#9fb0b8; max-width:36ch;">
          A small software and IT consulting team based out of Istanbul,
          building and maintaining systems for businesses that need
          things to just work.
        </p>
      </div>

      <div>
        <h4>Site</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>

      <div>
        <h4>Contact</h4>
        <ul>
          <li><a href="mailto:hello@northbeam.dev">hello@northbeam.dev</a></li>
          <li><a href="tel:+900000000000">+90 000 000 00 00</a></li>
          <li>Istanbul, Turkey</li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>&copy; <?php echo $currentYear; ?> <?php echo $siteName; ?>. All rights reserved.</span>
      <span>Built with PHP · MySQL · a lot of coffee</span>
    </div>
  </div>
</footer>

</body>
</footer>

<script>
  // Mobile nav toggle
  const navToggle = document.querySelector('.nav-toggle');
  const navLinks = document.querySelector('.nav-links');

  navToggle.addEventListener('click', () => {
    navLinks.classList.toggle('open');
    navToggle.textContent = navLinks.classList.contains('open') ? '✕' : '☰';
  });
</script>

</body>
</html>
