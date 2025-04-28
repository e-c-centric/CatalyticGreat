<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Get Started - CatalyticGreat+</title>
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
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="downloads.php">Downloads</a></li>
          <?php endif; ?>
          <li><a href="get-started.php" class="active">Get Started</a></li>
        </ul>
      </nav>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="auth-buttons">
          <a href="login.php" class="login-btn">Login</a>
          <a href="register.php" class="register-btn">Register</a>
        </div>
      <?php endif; ?>
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    <section class="page-hero get-started-hero">
      <div class="container">
        <div class="hero-content animate-fade-in">
          <h1>Get Started with CatalyticGreat+</h1>
          <p>Follow these simple steps to set up your vehicle monitoring system and start tracking catalytic converter health.</p>
        </div>
      </div>
    </section>

    <!-- Quick Start Steps -->
    <section class="quickstart-section">
      <div class="container">
        <h2 class="section-title">Quick Start Guide</h2>
        <div class="steps-timeline">
          <div class="timeline-step animate-slide-up">
            <div class="step-number">1</div>
            <div class="step-content">
              <h3>Purchase Equipment</h3>
              <p>Get a Veepeak OBDCheckII device from an <a style="color: #007bff;" target="_blank" rel="noopener noreferrer" href="https://www.amazon.com/dp/B073XKQQQW">authorised retaler</a>.</p>
              <img src="veepeak.jpg" alt="Veepeak OBD Device" class="step-image" style="width: 100%; max-width: 300px; margin-top: 10px;">
              <img src="veepeak-2.jpg" alt="Veepeak OBD Device" class="step-image" style="width: 100%; max-width: 300px; margin-top: 10px;">
              <p>Note: The Veepeak OBDCheckII device is compatible with most vehicles and is required for the CatalyticGreat+ system to function.</p>
            </div>
          </div>

          <div class="timeline-step animate-slide-up" style="animation-delay: 0.1s;">
            <div class="step-number">2</div>
            <div class="step-content">
              <h3>Create an Account</h3>
              <p><a href="register.php">Register</a> for a CatalyticGreat+ account to access the dashboard and mobile app.</p>
            </div>
          </div>

          <div class="timeline-step animate-slide-up" style="animation-delay: 0.2s;">
            <div class="step-number">3</div>
            <div class="step-content">
              <h3>Install the Software</h3>
              <p>Download and install the CatalyticGreat+ app for your <a href="downloads.php">device</a>.</p>
            </div>
          </div>

          <div class="timeline-step animate-slide-up" style="animation-delay: 0.3s;">
            <div class="step-number">4</div>
            <div class="step-content">
              <h3>Connect Your Vehicle</h3>
              <p>Plug the OBD device into your vehicle's OBD-II port, typically located under the dashboard.</p>
              <img src="connected_dongle.jpg" alt="OBD Port Connection" class="step-image" style="width: 100%; max-width: 300px; margin-top: 10px;">
              <p>Note: The OBD-II port is usually located near the driver's side, under the steering wheel. If you have trouble finding it, refer to your vehicle's manual.</p>
            </div>
          </div>

          <div class="timeline-step animate-slide-up" style="animation-delay: 0.4s;">
            <div class="step-number">5</div>
            <div class="step-content">
              <h3>Pair with the App</h3>
              <p>Open the app and follow the on-screen instructions to pair with your OBD device.</p>
              <img src="homepage-2.jpg" alt="Pairing with App" class="step-image" style="width: 100%; max-width: 300px; margin-top: 10px;">
              <img src="select_adapter.jpg" alt="Pairing with App" class="step-image" style="width: 100%; max-width: 300px; margin-top: 10px;">
              <p>Ensure you approve all app permission requests for successful pairing.</p>
            </div>
          </div>

          <div class="timeline-step animate-slide-up" style="animation-delay: 0.5s;">
            <div class="step-number">6</div>
            <div class="step-content">
              <h3>Start Monitoring</h3>
              <p>That's it! Your vehicle is now connected and you can start monitoring your catalytic converter health.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Compatibility Section -->
    <section class="compatibility-section">
      <div class="container">
        <h2 class="section-title">Vehicle Compatibility</h2>
        <div class="compatibility-content">
          <div class="compatibility-text animate-fade-in">
            <p>CatalyticGreat+ works with most vehicles manufactured after 1996 that have an OBD-II port. This includes:</p>
            <ul class="compatibility-list">
              <li>Passenger cars and light trucks</li>
              <li>SUVs and crossovers</li>
              <li>Most hybrid vehicles</li>
              <li>Many electric vehicles with OBD-II support</li>
            </ul>
            <p>Not sure if your vehicle is compatible? Use our compatibility checker or contact our support team.</p>
            <a href="#" class="secondary-btn animate-scale-hover">Check Compatibility</a>
          </div>
          <div class="compatibility-brands animate-fade-in">
            <h3>Supported Brands</h3>
            <div class="brand-logos">
              <div class="brand-logo">Toyota</div>
              <div class="brand-logo">Honda</div>
              <div class="brand-logo">Ford</div>
              <div class="brand-logo">Chevrolet</div>
              <div class="brand-logo">BMW</div>
              <div class="brand-logo">Mercedes</div>
              <div class="brand-logo">Audi</div>
              <div class="brand-logo">Nissan</div>
              <div class="brand-logo">Hyundai</div>
              <div class="brand-logo">Kia</div>
              <div class="brand-logo">And many more...</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <div class="container">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-list">
          <div class="faq-item animate-fade-in">
            <div class="faq-question">
              <h3>How does CatalyticGreat+ work?</h3>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
              <p>CatalyticGreat+ uses your vehicle's OBD-II port to collect data about your catalytic converter's performance. Our software analyzes this data using machine learning algorithms to predict potential issues before they become serious problems.</p>
            </div>
          </div>

          <div class="faq-item animate-fade-in" style="animation-delay: 0.1s;">
            <div class="faq-question">
              <h3>Will this void my vehicle's warranty?</h3>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
              <p>No, CatalyticGreat+ only reads data from your vehicle's onboard computer. It does not modify any vehicle systems or settings, so it will not void your warranty.</p>
            </div>
          </div>

          <div class="faq-item animate-fade-in" style="animation-delay: 0.2s;">
            <div class="faq-question">
              <h3>How accurate are the predictions?</h3>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
              <p>Our system has been tested with thousands of vehicles and has a prediction accuracy of over 90% for catalytic converter failures up to 3 months in advance. The more you use the system, the more accurate it becomes for your specific vehicle.</p>
            </div>
          </div>

          <div class="faq-item animate-fade-in" style="animation-delay: 0.3s;">
            <div class="faq-question">
              <h3>Do I need to keep the OBD device connected all the time?</h3>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
              <p>For best results, we recommend keeping the device connected, but you can disconnect it when needed. The system will continue to learn from the data collected during connected periods.</p>
            </div>
          </div>

          <div class="faq-item animate-fade-in" style="animation-delay: 0.4s;">
            <div class="faq-question">
              <h3>Is my data secure?</h3>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
              <p>Yes, we take data security seriously. All vehicle data is encrypted during transmission and storage. We never share your personal information or vehicle data with third parties without your explicit consent.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
      <div class="container">
        <h2>Ready to Start Monitoring?</h2>
        <p>Join thousands of users who are taking control of their vehicle's emissions system.</p>
        <div class="cta-buttons">
          <a href="register.php" class="primary-btn animate-scale-hover">Create Account</a>
          <a href="downloads.php" class="secondary-btn animate-scale-hover">Download Software</a>
        </div>
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