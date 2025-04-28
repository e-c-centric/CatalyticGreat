// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function () {
  // Add scroll event to handle navbar background
  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.style.background = 'rgba(255, 255, 255, 0.95)';
      navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
    } else {
      navbar.style.background = 'var(--white)';
      navbar.style.boxShadow = 'none';
    }
  });

  // Add animation classes to elements when they come into view
  const animateElements = document.querySelectorAll('.step, .benefit-card, .feature, .feature-card, .download-card, .timeline-step, .compatibility-text, .compatibility-brands, .faq-item');

  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  function checkElements() {
    animateElements.forEach(element => {
      if (isElementInViewport(element) && !element.classList.contains('animate-visible')) {
        element.classList.add('animate-visible');
      }
    });
  }

  // Check elements on load
  checkElements();

  // Check elements on scroll
  window.addEventListener('scroll', checkElements);

  // Password visibility toggle
  const togglePasswordButtons = document.querySelectorAll('.toggle-password');
  togglePasswordButtons.forEach(button => {
    button.addEventListener('click', function () {
      const passwordInput = this.parentElement.querySelector('input');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.querySelector('.eye-icon').textContent = '👁️';
      } else {
        passwordInput.type = 'password';
        this.querySelector('.eye-icon').textContent = '👁️';
      }
    });
  });

  // FAQ accordion functionality
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    question.addEventListener('click', () => {
      // Close all other FAQ items
      faqItems.forEach(otherItem => {
        if (otherItem !== item && otherItem.classList.contains('active')) {
          otherItem.classList.remove('active');
          otherItem.querySelector('.faq-toggle').textContent = '+';
        }
      });

      // Toggle current FAQ item
      item.classList.toggle('active');
      const toggle = item.querySelector('.faq-toggle');
      toggle.textContent = item.classList.contains('active') ? '−' : '+';
    });
  });

  // Add hover animations to buttons
  const animateButtons = document.querySelectorAll('.primary-btn, .secondary-btn, .download-btn');
  animateButtons.forEach(button => {
    button.addEventListener('mouseenter', function () {
      this.classList.add('animate-pulse');
    });
    button.addEventListener('mouseleave', function () {
      this.classList.remove('animate-pulse');
    });
  });

  // Form validation for login/register forms
  const forms = document.querySelectorAll('form');
  forms.forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      let valid = true;
      const inputs = form.querySelectorAll('input[required], select[required]');

      inputs.forEach(input => {
        if (!input.value.trim()) {
          valid = false;
          input.classList.add('error');
        } else {
          input.classList.remove('error');
        }
      });

      // Password matching for register form
      const password = form.querySelector('#password');
      const confirmPassword = form.querySelector('#confirmPassword');

      if (password && confirmPassword && password.value !== confirmPassword.value) {
        valid = false;
        confirmPassword.classList.add('error');
        Swal.fire('Error', 'Passwords do not match', 'error');
      }

      if (valid) {
        // Collect form data
        const firstName = form.querySelector('#firstName').value.trim();
        const lastName = form.querySelector('#lastName').value.trim();
        const email = form.querySelector('#email').value.trim();
        const phone = form.querySelector('#phone').value.trim();
        const userType = form.querySelector('#userType').value.trim();
        const passwordValue = password.value.trim();
        const fullName = `${firstName} ${lastName}`;

        // Send data via AJAX
        fetch('/api.php/auth.php?action=register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            name: fullName,
            email: email,
            phone_number: phone,
            role: userType,
            password: passwordValue,
          }),
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              Swal.fire('Success', data.message, 'success');
              form.reset();
              setTimeout(() => {
                window.location.href = '/login.php';
              }, 2000); // Redirect after 2 seconds
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          })
          .catch(error => {
            Swal.fire('Error', 'An error occurred while submitting the form', 'error');
            console.error('Error:', error);
          });
      }
    });
  });

  const loginForm = document.querySelector('.login-form');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();

      // Collect login form data
      const email = loginForm.querySelector('#email').value.trim();
      const password = loginForm.querySelector('#password').value.trim();

      // Validate inputs
      if (!email || !password) {
        Swal.fire('Error', 'Please fill in all fields', 'error');
        return;
      }

      // Send data via AJAX
      fetch('/api.php/auth.php?action=login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          email: email,
          password: password,
        }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire('Success', data.message, 'success');
            setTimeout(() => {
              window.location.href = '/index.php'; // Redirect to index.php on success
            }, 2000); // Redirect after 2 seconds
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(error => {
          Swal.fire('Error', 'An error occurred while logging in', 'error');
          console.error('Error:', error);
        });
    });
  }

  // Mobile menu toggle
  const mobileMenuButton = document.querySelector('.mobile-menu-button');
  if (mobileMenuButton) {
    mobileMenuButton.addEventListener('click', function () {
      const nav = document.querySelector('nav');
      nav.classList.toggle('active');
    });
  }
});
