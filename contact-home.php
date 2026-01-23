<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us | ProWorldz</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* RESET & BASE STYLES */
   /* ================= RESET ================= */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* ================= ROOT ================= */
:root {
  --bg-main: #05070d;
  --bg-soft: #0b0e14;
  --glass: rgba(20, 24, 35, 0.9);

  --primary: #7c7cff;
  --secondary: #5eead4;

  --text-main: #ffffff;
  --text-muted: #9aa4bf;

  --border-soft: rgba(255,255,255,0.06);

  --gradient-main: linear-gradient(135deg, #7c7cff, #5eead4);

  --shadow-soft:
    0 25px 60px rgba(0,0,0,0.65),
    inset 0 0 0 1px rgba(255,255,255,0.04);

  --transition: all 0.35s ease;
}

/* ================= BODY ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 20% 15%, rgba(124,124,255,0.12), transparent 40%),
    radial-gradient(circle at 80% 85%, rgba(94,234,212,0.10), transparent 45%),
    linear-gradient(180deg, #05070d 0%, #0b0e14 45%, #05070d 100%);
  color: var(--text-main);
  overflow-x: hidden;
  line-height: 1.6;
}

/* ================= NAVBAR ================= */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 80px;
  padding: 0 5%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(
    180deg,
    rgba(10,12,20,0.95),
    rgba(5,7,13,0.98)
  );
  backdrop-filter: blur(22px);
  border-bottom: 1px solid var(--border-soft);
  z-index: 1000;
}

/* LOGO */
.logo {
  font-size: 1.9rem;
  font-weight: 700;
}

.logo span {
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* NAV LINKS */
.nav-links {
  list-style: none;
  display: flex;
  gap: 2rem;
  align-items: center;
}

.nav-item a {
  color: var(--text-muted);
  text-decoration: none;
  font-weight: 500;
  position: relative;
  transition: var(--transition);
}

.nav-item a:hover {
  color: var(--text-main);
}

.nav-item a::after {
  content: '';
  position: absolute;
  bottom: -6px;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--gradient-main);
  transition: width .3s;
}

.nav-item a:hover::after {
  width: 100%;
}

/* BUTTONS */
.login,
.signup {
  padding: 0.6rem 1.6rem;
  border-radius: 999px;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  border: none;
}

.login {
  background: transparent;
  color: var(--text-main);
  border: 1px solid var(--border-soft);
}

.login:hover {
  border-color: var(--primary);
}

.signup {
  background: var(--gradient-main);
  color: #fff;
}

.signup:hover {
  transform: translateY(-2px);
  box-shadow: 0 25px 60px rgba(124,124,255,0.45);
}

/* ================= HERO ================= */
.contact-hero {
  padding: 170px 5% 130px;
  text-align: center;
  background:
    radial-gradient(circle at 30% 30%, rgba(124,124,255,0.15), transparent 45%),
    radial-gradient(circle at 70% 70%, rgba(94,234,212,0.12), transparent 50%),
    linear-gradient(180deg, #05070d 0%, #0b0e14 45%, #05070d 100%);
}

.hero-content h1 {
  font-size: 3.8rem;
  font-weight: 700;
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-content p {
  margin-top: 1rem;
  font-size: 1.2rem;
  color: var(--text-muted);
}

/* ================= CONTACT CONTAINER ================= */
.contact-container {
  max-width: 1200px;
  margin: -40px auto 0;
  padding: 5rem 5%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
}

/* GLASS CARDS */
.contact-info,
.contact-form {
  background: linear-gradient(
    180deg,
    rgba(25,30,45,0.92),
    rgba(15,18,30,0.97)
  );
  backdrop-filter: blur(20px);
  border-radius: 20px;
  padding: 3rem;
  border: 1px solid var(--border-soft);
  transition: var(--transition);
}

.contact-info:hover,
.contact-form:hover {
  transform: translateY(-10px);
  box-shadow: var(--shadow-soft);
  border-color: var(--primary);
}

/* INFO BOX */
.info-box {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  margin-bottom: 1.2rem;
  border-radius: 14px;
  background: rgba(255,255,255,0.04);
}

.info-box span {
  font-size: 1.6rem;
}

.info-box p {
  color: var(--text-main);
}

/* ================= FORM ================= */
.input-group {
  position: relative;
  margin-bottom: 2rem;
}

.input-group input,
.input-group textarea {
  width: 100%;
  padding: 1.2rem;
  background: rgba(255,255,255,0.05);
  border: 1px solid var(--border-soft);
  border-radius: 12px;
  color: var(--text-main);
}

.input-group label {
  position: absolute;
  top: 50%;
  left: 1.2rem;
  transform: translateY(-50%);
  color: var(--text-muted);
  transition: var(--transition);
  pointer-events: none;
}

.input-group input:focus + label,
.input-group textarea:focus + label,
.input-group input:valid + label,
.input-group textarea:valid + label {
  top: -8px;
  font-size: 0.75rem;
  color: var(--primary);
  background: var(--bg-soft);
  padding: 0 6px;
}

/* SUBMIT */
.contact-form button {
  width: 100%;
  padding: 1.2rem;
  border-radius: 12px;
  border: none;
  background: var(--gradient-main);
  color: #fff;
  font-weight: 600;
  cursor: pointer;
}

.contact-form button:hover {
  transform: translateY(-3px);
  box-shadow: 0 25px 60px rgba(124,124,255,0.45);
}

/* ================= CTA ================= */
.contact-cta {
  padding: 6rem 5%;
  text-align: center;
  background:
    radial-gradient(circle at center, rgba(124,124,255,0.15), transparent 60%),
    linear-gradient(180deg, rgba(20,24,35,0.9), rgba(5,7,13,0.95));
}

.contact-cta h2 span {
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* ================= FOOTER ================= */
.footer {
  padding: 2rem;
  text-align: center;
  color: var(--text-muted);
  border-top: 1px solid var(--border-soft);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .contact-container {
    grid-template-columns: 1fr;
  }

  .hero-content h1 {
    font-size: 2.4rem;
  }
}


    /* RESPONSIVE DESIGN */
    @media (max-width: 1024px) {
        .hero-content h1 {
            font-size: 3rem;
        }
        
        .contact-container {
            gap: 3rem;
        }
        
        .contact-info h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        /* NAVBAR MOBILE */
        .menu-toggle {
            display: flex;
        }
        
        .nav-links {
            position: fixed;
            top: 0;
            right: -100%;
            width: 300px;
            height: 100vh;
            background: rgba(15, 15, 15, 0.98);
            backdrop-filter: blur(20px);
            flex-direction: column;
            padding-top: 6rem;
            transition: var(--transition);
            border-left: 1px solid var(--border-color);
        }
        
        .nav-links.active {
            right: 0;
        }
        
        .nav-btns {
            display: none;
        }
        
        .mobile-btns {
            display: flex;
        }
        
        /* HERO */
        .contact-hero {
            padding: 8rem 5% 4rem;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        /* CONTACT CONTAINER */
        .contact-container {
            grid-template-columns: 1fr;
            padding: 3rem 5%;
            gap: 2rem;
        }
        
        .contact-info,
        .contact-form {
            padding: 2rem;
        }
        
        /* CTA */
        .contact-cta h2 {
            font-size: 2rem;
        }
        
        /* ANIMATIONS ON MOBILE */
        @media (max-width: 768px) {
            .contact-hero::before {
                animation: none;
            }
        }
    }

    @media (max-width: 480px) {
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .contact-hero {
            padding: 7rem 5% 3rem;
            background-attachment: scroll;
        }
        
        .navbar {
            padding: 1rem 5%;
        }
        
        .logo {
            font-size: 1.5rem;
        }
        
        .nav-links {
            width: 100%;
        }
        
        .contact-info h2 {
            font-size: 1.8rem;
        }
        
        .contact-cta h2 {
            font-size: 1.6rem;
        }
        
        .info-box span {
            font-size: 1.5rem;
        }
        
        .info-box p {
            font-size: 1rem;
        }
    }

    /* DARK/LIGHT MODE SUPPORT */
    @media (prefers-color-scheme: light) {
        :root {
            --dark-bg: #ffffff;
            --dark-card: #f5f5f5;
            --light-text: #333333;
            --gray-text: #666666;
            --border-color: #dddddd;
        }
        
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        .nav-item a {
            color: #333333;
        }
        
        .login {
            border-color: #dddddd;
            color: #333333;
        }
        
        .menu-toggle span {
            background: #333333;
        }
        
        body {
            color: #333333;
        }
        
        .contact-hero {
            background: linear-gradient(135deg, rgba(245, 245, 245, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%), 
                        url('https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80');
        }
    }

    /* PREFERS-REDUCED-MOTION */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        
        .contact-form button {
            animation: none !important;
        }
    }

    /* PRINT STYLES */
    @media print {
        .navbar,
        .contact-cta,
        .contact-form button {
            display: none;
        }
        
        body {
            background: white;
            color: black;
        }
        
        .contact-container {
            padding: 1rem;
        }
    }

    /* CUSTOM SCROLLBAR */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: var(--dark-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--gradient);
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-color);
    }

    /* FORM VALIDATION STYLES */
    .input-group input:invalid:not(:focus):not(:placeholder-shown),
    .input-group textarea:invalid:not(:focus):not(:placeholder-shown) {
        border-color: #ff4757;
    }

    .input-group input:valid:not(:focus):not(:placeholder-shown),
    .input-group textarea:valid:not(:focus):not(:placeholder-shown) {
        border-color: #2ed573;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="logo">PRO<span>WORLDZ</span></div>

  <!-- HAMBURGER -->
  <div class="menu-toggle" id="menuToggle">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <ul class="nav-links" id="navLinks">
    <li class="nav-item"><a href="index.php">Courses</a></li>
    <li class="nav-item"><a href="about-home.php">About Us</a></li>
    <li class="nav-item"><a href="contact-home.php">Contact</a></li>

    <!-- MOBILE BUTTONS -->
    <div class="mobile-btns">
      <button class="login">Login</button>
      <button class="signup">Sign Up</button>
    </div>
  </ul>

  <!-- DESKTOP BUTTONS -->
  <div class="nav-btns">
    <button class="login">Login</button>
    <button class="signup">Sign Up</button>
  </div>
</nav>

<!-- HERO -->
<section class="contact-hero">
  <div class="hero-content">
    <h1>Contact ProWorldz</h1>
    <p>Let's connect and build your future in tech</p>
  </div>
</section>

<!-- CONTACT CONTAINER -->
<div class="contact-container">
  
  <!-- LEFT INFO -->
  <div class="contact-info">
    <h2>Get in Touch</h2>
    <p>Have questions about our courses or platform?  
       Send us a message and our team will reach out to you.</p>

    <div class="info-box">
      <span>📧</span>
      <p>proworldz0311@gmail.com</p>
    </div>

    <div class="info-box">
      <span>📞</span>
      <p>+91 98765 43210</p>
    </div>

    <div class="info-box">
      <span>📍</span>
      <p>India</p>
    </div>
  </div>

  <!-- RIGHT FORM -->
  <form class="contact-form" id="contactForm">
    <div class="input-group">
      <input type="text" id="name" required>
      <label for="name">Name</label>
    </div>

    <div class="input-group">
      <input type="email" id="email" required>
      <label for="email">Email</label>
    </div>

    <div class="input-group">
      <textarea id="message" rows="4" required></textarea>
      <label for="message">Message</label>
    </div>

    <button type="submit">Send Message</button>
  </form>

</div>

<section class="contact-cta">
  <h2>Ready to Start Your <span>Tech Journey</span>?</h2>
  <a href="index.php" class="cta-btn" style="display: inline-block; padding: 1rem 2.5rem; background: var(--gradient); color: white; text-decoration: none; border-radius: 30px; font-weight: 600; font-size: 1.1rem; transition: var(--transition); position: relative; z-index: 1; overflow: hidden;">
    Explore Courses
  </a>
</section>

<!-- FOOTER -->
<footer class="footer">
  <p>&copy; 2026 ProWorldz. All rights reserved.</p>
</footer>

<script>
  // MOBILE MENU TOGGLE
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');
  
  menuToggle.addEventListener('click', () => {
    menuToggle.classList.toggle('active');
    navLinks.classList.toggle('active');
    document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : 'auto';
  });
  
  // Close menu when clicking on links
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
      menuToggle.classList.remove('active');
      navLinks.classList.remove('active');
      document.body.style.overflow = 'auto';
    });
  });
  
  // FORM SUBMISSION
  const contactForm = document.getElementById('contactForm');
  
  contactForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    
    // Form validation
    if (!name || !email || !message) {
      showNotification('Please fill in all fields', 'error');
      return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      showNotification('Please enter a valid email address', 'error');
      return;
    }
    
    // Disable submit button and show loading
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.8';
    
    // Simulate API call
    setTimeout(() => {
      // Show success message
      showNotification('Message sent successfully! We will get back to you soon.', 'success');
      
      // Reset form
      contactForm.reset();
      
      // Reset button
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
      submitBtn.style.opacity = '1';
      
      // Add success animation
      submitBtn.style.animation = 'pulse 1s ease';
      setTimeout(() => {
        submitBtn.style.animation = 'pulse 2s infinite';
      }, 1000);
    }, 2000);
  });
  
  // Notification function
  function showNotification(message, type) {
    // Remove existing notification
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
      existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
      <span>${message}</span>
      <button class="close-notification">&times;</button>
    `;
    
    // Add styles
    notification.style.cssText = `
      position: fixed;
      top: 100px;
      right: 20px;
      background: ${type === 'success' ? 'linear-gradient(135deg, #2ed573 0%, #1e90ff 100%)' : 'linear-gradient(135deg, #ff4757 0%, #ff6b81 100%)'};
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      z-index: 10000;
      animation: slideInRight 0.3s ease;
      max-width: 400px;
      box-shadow: var(--shadow);
    `;
    
    // Add close button styles
    const closeBtn = notification.querySelector('.close-notification');
    closeBtn.style.cssText = `
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
      padding: 0;
      line-height: 1;
    `;
    
    // Add close functionality
    closeBtn.addEventListener('click', () => {
      notification.style.animation = 'slideInRight 0.3s ease reverse';
      setTimeout(() => notification.remove(), 300);
    });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
      if (notification.parentNode) {
        notification.style.animation = 'slideInRight 0.3s ease reverse';
        setTimeout(() => notification.remove(), 300);
      }
    }, 5000);
    
    // Add to document
    document.body.appendChild(notification);
  }
  
  // Input focus effects
  document.querySelectorAll('.input-group input, .input-group textarea').forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
      if (!this.value) {
        this.parentElement.classList.remove('focused');
      }
    });
  });
  
  // Intersection Observer for animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated');
      }
    });
  }, observerOptions);
  
  // Observe elements
  document.querySelectorAll('.contact-info, .contact-form, .info-box').forEach(el => {
    observer.observe(el);
  });
  
  // Parallax effect on hero
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.contact-hero');
    if (hero) {
      hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
    }
  });
  
  // Add keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navLinks.classList.contains('active')) {
      menuToggle.classList.remove('active');
      navLinks.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  });
</script>

</body>
</html>