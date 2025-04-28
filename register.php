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
  <title>Register - CatalyticGreat+</title>
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
    </div>
  </header>

  <main>
    <section class="register-section">
      <div class="container">
        <div class="register-container">
          <div class="register-image">
            <img src="https://media.istockphoto.com/id/1360708914/vector/catalytic-converter-and-chemical-element-system-icon.jpg?s=1024x1024&w=is&k=20&c=XQOp31JQpaEucU7-YT4fc9-Tp5lTN-nmno9lf6TBA8Q=" alt="Vehicle data monitoring" class="animate-fade-in">
          </div>
          <div class="register-form-container animate-slide-up">
            <h1>Create Your Account</h1>
            <p class="register-subtitle">Join CatalyticGreat+ to start monitoring your vehicle</p>

            <form class="register-form">
              <div class="form-row">
                <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" id="firstName" placeholder="Enter your first name" required>
                </div>
                <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" id="lastName" placeholder="Enter your last name" required>
                </div>
              </div>

              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" placeholder="Enter your email" required>
              </div>

              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" placeholder="Enter your phone number">
              </div>

              <div class="form-group">
                <label for="userType">I am a:</label>
                <select id="userType" required>
                  <option value="">Select user type</option>
                  <option value="driver">Driver</option>
                  <option value="mechanic">Mechanic</option>
                  <option value="dvla">Regulatory Body</option>
                  <option value="epa">Environmental Agency</option>
                </select>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <div class="password-input">
                  <input type="password" id="password" placeholder="Create a password" required>
                  <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                    <span class="eye-icon">👁️</span>
                  </button>
                </div>
              </div>

              <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="password-input">
                  <input type="password" id="confirmPassword" placeholder="Confirm your password" required>
                  <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                    <span class="eye-icon">👁️</span>
                  </button>
                </div>
              </div>

              <div class="form-options">
                <div class="terms-checkbox">
                  <input type="checkbox" id="terms" required>
                  <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                </div>
              </div>

              <button type="submit" class="submit-btn primary-btn animate-scale-hover">Create Account</button>
            </form>

            <div class="register-footer">
              <p>Already have an account? <a href="login.php">Sign in</a></p>
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