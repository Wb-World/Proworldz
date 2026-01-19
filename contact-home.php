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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    :root {
        --primary-color: #ff5722;
        --primary-dark: #e64a19;
        --secondary-color: #2196f3;
        --dark-bg: #0f0f0f;
        --dark-card: #1a1a1a;
        --light-text: #ffffff;
        --gray-text: #b0b0b0;
        --border-color: #333333;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        --gradient: linear-gradient(135deg, #ff5722 0%, #ff4081 100%);
        --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
    }

    body {
        background-color: var(--dark-bg);
        color: var(--light-text);
        overflow-x: hidden;
        line-height: 1.6;
    }

    /* ANIMATIONS */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 87, 34, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(255, 87, 34, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 87, 34, 0);
        }
    }

    @keyframes glow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* NAVBAR STYLES */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 5%;
        background-color: rgba(15, 15, 15, 0.95);
        backdrop-filter: blur(10px);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        border-bottom: 1px solid var(--border-color);
        animation: slideInLeft 0.8s ease;
    }

    .logo {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--light-text);
        text-decoration: none;
    }

    .logo span {
        color: var(--primary-color);
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 3s ease infinite;
        background-size: 200% 200%;
    }

    .nav-links {
        display: flex;
        list-style: none;
        gap: 2rem;
        align-items: center;
    }

    .nav-item {
        position: relative;
    }

    .nav-item a {
        color: var(--light-text);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        padding: 0.5rem 0;
        position: relative;
    }

    .nav-item a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient);
        transition: width 0.3s ease;
    }

    .nav-item a:hover::after,
    .nav-item.active a::after {
        width: 100%;
    }

    .nav-item.active a {
        color: var(--primary-color);
        font-weight: 600;
    }

    .nav-btns {
        display: flex;
        gap: 1rem;
    }

    .login, .signup {
        padding: 0.7rem 1.5rem;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        font-size: 0.9rem;
    }

    .login {
        background: transparent;
        color: var(--light-text);
        border: 2px solid var(--border-color);
    }

    .login:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .signup {
        background: var(--gradient);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .signup::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .signup:hover::before {
        left: 100%;
    }

    .signup:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3);
    }

    /* HAMBURGER MENU */
    .menu-toggle {
        display: none;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
        z-index: 1001;
    }

    .menu-toggle span {
        width: 25px;
        height: 3px;
        background: var(--light-text);
        border-radius: 2px;
        transition: var(--transition);
    }

    .menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(6px, 6px);
    }

    .menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }

    .mobile-btns {
        display: none;
        flex-direction: column;
        gap: 1rem;
        padding: 2rem;
        width: 100%;
    }

    /* HERO SECTION */
    .contact-hero {
        padding: 12rem 5% 6rem;
        background: linear-gradient(135deg, rgba(15, 15, 15, 0.9) 0%, rgba(26, 26, 26, 0.95) 100%), 
                    url('https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        text-align: center;
        animation: fadeIn 1s ease-out;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(255, 87, 34, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 64, 129, 0.1) 0%, transparent 50%);
        animation: gradientShift 8s ease infinite;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .hero-content h1 {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: fadeIn 1s ease-out 0.3s both;
    }

    .hero-content h1 span {
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    .hero-content p {
        font-size: 1.2rem;
        color: var(--gray-text);
        animation: fadeIn 1s ease-out 0.6s both;
    }

    /* CONTACT CONTAINER */
    .contact-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 5%;
        animation: fadeIn 1s ease-out 0.8s both;
    }

    /* CONTACT INFO */
    .contact-info {
        background: var(--dark-card);
        padding: 3rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .contact-info::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient);
        animation: gradientShift 3s ease infinite;
    }

    .contact-info:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
        border-color: var(--primary-color);
    }

    .contact-info h2 {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .contact-info p {
        color: var(--gray-text);
        margin-bottom: 2.5rem;
        line-height: 1.8;
    }

    .info-box {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .info-box:hover {
        background: rgba(255, 87, 34, 0.1);
        border-color: var(--primary-color);
        transform: translateX(10px);
    }

    .info-box span {
        font-size: 1.8rem;
        margin-right: 1rem;
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: glow 2s ease-in-out infinite;
    }

    .info-box p {
        margin: 0;
        font-size: 1.1rem;
        color: var(--light-text);
    }

    /* CONTACT FORM */
    .contact-form {
        background: var(--dark-card);
        padding: 3rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .contact-form::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient);
        animation: gradientShift 3s ease infinite reverse;
    }

    .contact-form:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
        border-color: var(--primary-color);
    }

    .input-group {
        position: relative;
        margin-bottom: 2rem;
    }

    .input-group input,
    .input-group textarea {
        width: 100%;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        color: var(--light-text);
        font-size: 1rem;
        transition: var(--transition);
    }

    .input-group input:focus,
    .input-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        background: rgba(255, 87, 34, 0.05);
        box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.1);
    }

    .input-group label {
        position: absolute;
        top: 1.2rem;
        left: 1.2rem;
        color: var(--gray-text);
        font-size: 1rem;
        pointer-events: none;
        transition: var(--transition);
        padding: 0 0.5rem;
    }

    .input-group input:focus + label,
    .input-group input:valid + label,
    .input-group textarea:focus + label,
    .input-group textarea:valid + label {
        top: -0.8rem;
        left: 1rem;
        font-size: 0.85rem;
        background: var(--dark-card);
        color: var(--primary-color);
        font-weight: 600;
    }

    .contact-form button {
        width: 100%;
        padding: 1.2rem;
        background: var(--gradient);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        animation: pulse 2s infinite;
    }

    .contact-form button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .contact-form button:hover::before {
        left: 100%;
    }

    .contact-form button:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 87, 34, 0.3);
        animation: none;
    }

    /* CTA SECTION */
    .contact-cta {
        padding: 6rem 5%;
        text-align: center;
        background: linear-gradient(135deg, var(--dark-card) 0%, rgba(15, 15, 15, 0.9) 100%);
        position: relative;
        overflow: hidden;
    }

    .contact-cta::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 87, 34, 0.1) 0%, transparent 70%);
        animation: pulse 2s infinite;
    }

    .contact-cta h2 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: var(--light-text);
        position: relative;
        z-index: 1;
    }

    .contact-cta h2 span {
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* FOOTER */
    .footer {
        padding: 3rem 5%;
        background: #000;
        text-align: center;
        border-top: 1px solid var(--border-color);
    }

    .footer p {
        color: var(--gray-text);
        font-size: 0.9rem;
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