      <?php session_start(); ?>

      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Features - CatalyticGreat+</title>
        <meta name="description" content="Advanced features for smart vehicle monitoring">
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
                <li><a href="features.php" class="active">Features</a></li>
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
          </div>
        </header>

        <main>
          <!-- Hero Section -->
          <section class="page-hero features-hero">
            <div class="container">
              <div class="hero-content">
                <h1>Advanced Features for Smart Vehicle Monitoring</h1>
                <p>Discover how CatalyticGreat+ revolutionizes catalytic converter health monitoring with cutting-edge technology.</p>
              </div>
            </div>
          </section>

          <!-- Main Features -->
          <section class="main-features">
            <div class="container">
              <div class="features-grid">
                <div class="features-column">
                  <div class="feature">
                    <div class="feature-icon gauge-icon"></div>
                    <h3>Real-Time Monitoring</h3>
                    <p>Get instant insights into your catalytic converter's performance with continuous monitoring through the Veepeak OBDCheckII device.</p>
                  </div>

                  <div class="feature">
                    <div class="feature-icon database-icon"></div>
                    <h3>Smart Data Analysis</h3>
                    <p>Our AI-powered system analyzes emissions data patterns to detect potential issues before they become serious problems.</p>
                  </div>

                  <div class="feature">
                    <div class="feature-icon chart-icon"></div>
                    <h3>Predictive Maintenance</h3>
                    <p>Receive advance warnings about potential catalytic converter failures, allowing for proactive maintenance.</p>
                  </div>
                </div>

                <div class="features-column">
                  <div class="feature">
                    <div class="feature-icon car-icon"></div>
                    <h3>Fleet Management</h3>
                    <p>Monitor multiple vehicles from a single dashboard, perfect for fleet managers and auto repair shops.</p>
                  </div>

                  <div class="feature">
                    <div class="feature-icon shield-icon"></div>
                    <h3>Compliance Tracking</h3>
                    <p>Stay compliant with emissions regulations by monitoring your vehicle's performance against required standards.</p>
                  </div>

                  <div class="feature">
                    <div class="feature-icon chart-line-icon"></div>
                    <h3>Performance Reports</h3>
                    <p>Access detailed reports and analytics about your vehicle's emissions performance and efficiency.</p>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Additional Features Section -->
          <section class="additional-features">
            <div class="container">
              <h2>More Powerful Features</h2>
              <div class="feature-cards">
                <div class="feature-card">
                  <h3>Historical Data Tracking</h3>
                  <p>Access your vehicle's performance history to see trends and patterns over time, helping you make informed maintenance decisions.</p>
                </div>
                <div class="feature-card">
                  <h3>Multi-Device Support</h3>
                  <p>Access your dashboard from your computer, tablet, or smartphone with our responsive web application and mobile apps.</p>
                </div>
                <div class="feature-card">
                  <h3>Custom Alerts</h3>
                  <p>Set up personalized notifications for specific metrics or thresholds that matter most to you and your vehicle.</p>
                </div>
                <div class="feature-card">
                  <h3>Maintenance Scheduling</h3>
                  <p>Our system can suggest optimal maintenance times based on your vehicle's actual performance data.</p>
                </div>
              </div>
            </div>
          </section>

          <!-- Technology Behind Section -->
          <section class="technology">
            <div class="container">
              <h2>The Technology Behind CatalyticGreat+</h2>
              <div class="tech-details">
                <div class="tech-column">
                  <h3>Advanced OBD Integration</h3>
                  <p>The Veepeak OBDCheckII device connects directly to your vehicle's OBD-II port, allowing us to capture comprehensive data about your engine's performance and emissions system.</p>
                </div>
                <div class="tech-column">
                  <h3>Machine Learning Algorithms</h3>
                  <p>Our proprietary algorithms analyze patterns in emissions data to predict catalytic converter performance with increasing accuracy over time.</p>
                </div>
              </div>
            </div>
          </section>

          <!-- CTA Section -->
          <section class="cta">
            <div class="container">
              <h2>Ready to Get Started?</h2>
              <p>Join thousands of drivers and fleet managers who trust CatalyticGreat+ for their vehicle monitoring needs.</p>
              <a href="get-started.php" class="primary-btn">Start Monitoring Now</a>
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