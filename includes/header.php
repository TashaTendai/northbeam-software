<?php
/* =========================================================================
   header.php
   Shared across every page. This is "PHP includes" lesson in
   practice: instead of copy-pasting the <head> and nav on every page,
   each page does: <?php include 'includes/header.php'; ?>

   We also declare a couple of PHP variables here so every page can use
   them, this is"variables, echo, comments" lesson.
   ========================================================================= */

// Site-wide variables (Day 2: variables + comments)
$siteName = "Northbeam Software";
$siteTagline = "Software and IT systems that don't keep you waiting.";

// Figure out which page we're on, so we can highlight it in the nav.
// basename(__FILE__) would give us "header.php", so instead we look at
// the file that actually included us.
$currentPage = basename($_SERVER['PHP_SELF']);

/**
 * Small helper: prints ' active' as a CSS class if $page matches the
 * current page. Keeps the nav markup below readable.
 */
function navClass($page, $currentPage) {
    return $page === $currentPage ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $siteName; ?> — <?php echo $siteTagline; ?></title>
<meta name="description" content="<?php echo $siteTagline; ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="site-header">
  <nav class="nav container">
    <a href="index.php" class="brand">
      <span class="brand-mark"></span>
      <?php echo $siteName; ?>
    </a>

    <ul class="nav-links">
      <li><a href="index.php" class="<?php echo navClass('index.php', $currentPage); ?>">Home</a></li>
      <li><a href="about.php" class="<?php echo navClass('about.php', $currentPage); ?>">About</a></li>
      <li><a href="services.php" class="<?php echo navClass('services.php', $currentPage); ?>">Services</a></li>
      <li><a href="contact.php" class="<?php echo navClass('contact.php', $currentPage); ?>">Contact</a></li>
    </ul>

    <div class="nav-cta">
      <a href="contact.php" class="btn btn-ghost">Get in touch</a>
      <button class="nav-toggle" aria-label="Menu">☰</button>
    </div>
  </nav>
</header>
