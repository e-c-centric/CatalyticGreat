<?php session_start();

if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'dvla') {
  header("Location: dvla/");
  exit();
}
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'mechanic') {
  header("Location: mechanic/");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CatalyticGreat+</title>
  <meta name="description" content="Smart, low-cost system that helps track and predict catalytic converter health">
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.gpteng.co/gptengineer.js" type="module"></script>
</head>

<body>
  <header class="navbar">
    <div class="container">
      <a href="index.php" class="logo">CatalyticGreat+</a>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="features.php">Features</a></li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="downloads.php">Downloads</a></li>
          <?php endif; ?>
          <li><a href="get-started.php">Get Started</a></li>
        </ul>
      </nav>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="auth-buttons">
          <a href="login.php" class="login-btn">Login</a>
          <a href="register.php" class="register-btn">Register</a>
        </div>
      <?php endif; ?>


      <button class="mobile-menu-button" aria-label="Toggle menu">☰</button>
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <div class="hero-content">
          <h1>Monitor Your Catalytic Converter Health in Real-Time</h1>
          <p>CatalyticGreat+ is a smart, low-cost system that helps track and predict the health of your vehicle's
            catalytic converter—using just the Veepeak OBDCheckII device.</p>
          <div class="hero-buttons">
            <a href="get-started.php" class="primary-btn">Get Started</a>
            <a href="features.php" class="secondary-btn">Learn More</a>
          </div>
        </div>
        <div class="hero-image">
          <img src="new logo.png" alt="CatalyticGreat+ Dashboard"
            width="500" height="300" />
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
      <div class="container">
        <h2>How It Works</h2>
        <div class="steps">
          <div class="step">
            <div class="step-icon">1</div>
            <h3>Plug-and-Play with OBD</h3>
            <p>Simply plug the Veepeak OBDCheckII device into your car's standard OBD-II port to start collecting data.
            </p>
          </div>
          <div class="step">
            <div class="step-icon">2</div>
            <h3>Smart Monitoring</h3>
            <p>Our system processes the raw data and identifies signs of reduced catalytic converter performance.</p>
          </div>
          <div class="step">
            <div class="step-icon">3</div>
            <h3>Predictive Insights</h3>
            <p>Using machine learning, we forecast when your catalytic converter might need attention.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits">
      <div class="container">
        <h2>Benefits for Everyone</h2>
        <div class="benefit-cards">
          <div class="benefit-card">
            <h3>For Drivers & Fleet Owners</h3>
            <p>Know exactly when your catalytic converter is failing without visiting a mechanic. Save money and reduce
              fuel waste.</p>
          </div>
          <div class="benefit-card">
            <h3>For Mechanics</h3>
            <p>Get accurate, real-time insights into emissions performance to improve diagnostics and build trust with
              clients.</p>
          </div>
          <div class="benefit-card">
            <h3>For Environmental Agencies</h3>
            <p>Access granular emissions data in real time, without needing expensive equipment or complex
              infrastructure.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
      <div class="container">
        <h2>Ready to Start Monitoring?</h2>
        <p>Join thousands of users who are taking control of their vehicle's emissions system.</p>
        <a href="get-started.php" class="primary-btn">Get Started Today</a>
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