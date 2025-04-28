<?php session_start(); 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - CatalyticGreat+</title>
  <meta name="description" content="Login to your CatalyticGreat+ account">
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <section class="login-section">
      <div class="container">
        <div class="login-container">
          <div class="login-image">
            <img src="new logo.png" alt="Vehicle monitoring dashboard" width="500" height="400" class="animate-fade-in">
          </div>
          <div class="login-form-container animate-slide-up">
            <h1>Welcome Back</h1>
            <p class="login-subtitle">Sign in to your CatalyticGreat+ account</p>

            <form class="login-form">
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" placeholder="Enter your email" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <div class="password-input">
                  <input type="password" id="password" placeholder="Enter your password" required>
                  <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                    <span class="eye-icon">👁️</span>
                  </button>
                </div>
              </div>

              <div class="form-options">
                <div class="remember-me">
                  <input type="checkbox" id="remember">
                  <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
              </div>

              <button type="submit" class="submit-btn primary-btn animate-scale-hover">Sign In</button>
            </form>

            <div class="login-footer">
              <p>Don't have an account? <a href="register.php">Create an account</a></p>
            </div>
          </div>
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