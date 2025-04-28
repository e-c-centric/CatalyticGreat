<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Downloads - CatalyticGreat+</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <header class="navbar">
    <div class="container">
      <a href="index.php" class="logo">CatalyticGreat+</a>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="features.php">Features</a></li>
          <li><a href="downloads.php" class="active">Downloads</a></li>
          <li><a href="get-started.php">Get Started</a></li>
        </ul>
      </nav>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="auth-buttons">
          <a href="login.php" class="login-btn">Login</a>
          <a href="register.php" class="register-btn">Register</a>
        </div>
      <?php endif; ?>
      <!-- <div class="auth-buttons">
        <a href="login.php" class="login-btn">Login</a>
        <a href="register.php" class="register-btn">Register</a>
      </div> -->
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    <section class="page-hero downloads-hero">
      <div class="container">
        <div class="hero-content animate-fade-in">
          <h1>Download CatalyticGreat+ Mobile App</h1>
          <p>Get our Android app to start monitoring your vehicle today.</p>
        </div>
      </div>
    </section>

    <!-- Mobile Downloads -->
    <section class="downloads-section">
      <div class="container">
        <h2 class="section-title">Mobile Application</h2>
        <div class="downloads-grid">
          <div class="download-card animate-slide-up">
            <div class="download-icon android-icon"></div>
            <h3>Android</h3>
            <p>Compatible with Android 9.0 and newer</p>
            <div class="download-size">4.8 MB</div>
            <a href="settings/android-release-signed.apk" class="download-btn primary-btn animate-scale-hover" download>Download</a>
            <div class="download-version">Version 1.0.0</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Complementary Software -->
    <section class="downloads-section">
      <div class="container">
        <h2 class="section-title">Complementary Tools</h2>
        <div class="downloads-grid">
          <div class="download-card animate-slide-up">
            <div class="download-icon device-icon"></div>
            <h3>Veepeak OBD Device</h3>
            <p>Purchase the Veepeak OBDCheckII device for seamless vehicle monitoring.</p>
            <a href="https://www.amazon.com/dp/B073XKQQQW" target="_blank" class="download-btn primary-btn animate-scale-hover">Buy on Amazon</a>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
      <div class="container">
        <h2>Need Help Installing?</h2>
        <p>Our support team is available to help you get started with CatalyticGreat+.</p>
        <a href="mailto:elikem.gale-zoyiku@ashesi.edu.gh?cc=pascal.mathias@ashesi.edu.gh" class="primary-btn animate-scale-hover">Contact Support</a>
      </div>
    </section>
  </main>

  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-logo">
          <h3>CatalyticGreat+</h3>
          <p>Smart Vehicle Monitoring</p>
        </div>
        <div class="footer-links">
          <div class="footer-column">
            <h4>Product</h4>
            <ul>
              <li><a href="features.php">Features</a></li>
              <li><a href="downloads.php">Downloads</a></li>
              <li><a href="#">Pricing</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h4>Resources</h4>
            <ul>
              <li><a href="#">Documentation</a></li>
              <li><a href="#">Support</a></li>
              <li><a href="#">API</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h4>Company</h4>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 CatalyticGreat+. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="scripts.js"></script>
</body>

</html>