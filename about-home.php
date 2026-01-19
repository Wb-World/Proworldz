<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | ProWorldz</title>

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
        animation: slideInDown 0.8s ease;
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
    .about-hero {
        padding: 12rem 5% 6rem;
        background: linear-gradient(135deg, rgba(15, 15, 15, 0.9) 0%, rgba(26, 26, 26, 0.95) 100%), 
                    url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        text-align: center;
        animation: fadeIn 1s ease-out;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
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

    /* SECTION STYLES */
    .section {
        padding: 5rem 5%;
        animation: fadeIn 0.8s ease-out;
    }

    .section.dark {
        background: linear-gradient(135deg, var(--dark-card) 0%, rgba(26, 26, 26, 0.9) 100%);
        position: relative;
        overflow: hidden;
    }

    .section.dark::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--gradient);
        animation: gradientShift 3s ease infinite;
        background-size: 200% 200%;
    }

    .content-box {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .content-box h2 {
        font-size: 3rem;
        margin-bottom: 2rem;
        color: var(--light-text);
    }

    .content-box h2 span {
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        display: inline-block;
    }

    .content-box h2 span::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gradient);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.6s ease;
    }

    .content-box:hover h2 span::after {
        transform: scaleX(1);
    }

    .content-box p {
        font-size: 1.1rem;
        color: var(--gray-text);
        line-height: 1.8;
        animation: fadeIn 1s ease-out;
    }

    /* CARDS SECTION */
    .center {
        text-align: center;
        font-size: 3rem;
        margin-bottom: 3rem;
        color: var(--light-text);
    }

    .center span {
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .card {
        background: var(--dark-card);
        padding: 2.5rem;
        border-radius: 15px;
        transition: var(--transition);
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
        animation: fadeIn 0.6s ease-out;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 87, 34, 0.1), transparent);
        transition: left 0.6s;
    }

    .card:hover::before {
        left: 100%;
    }

    .card:hover {
        transform: translateY(-10px);
        border-color: var(--primary-color);
        box-shadow: var(--shadow);
    }

    .card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--light-text);
    }

    .card p {
        color: var(--gray-text);
        font-size: 1rem;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }

    /* CTA SECTION */
    .about-cta {
        padding: 6rem 5%;
        text-align: center;
        background: linear-gradient(135deg, var(--dark-card) 0%, rgba(15, 15, 15, 0.9) 100%);
        position: relative;
        overflow: hidden;
    }

    .about-cta::before {
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

    .about-cta h2 {
        font-size: 2.5rem;
        margin-bottom: 2rem;
        color: var(--light-text);
        position: relative;
        z-index: 1;
    }

    .about-cta h2 span {
        background: var(--gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .cta-btn {
        display: inline-block;
        padding: 1rem 2.5rem;
        background: var(--gradient);
        color: white;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: var(--transition);
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .cta-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .cta-btn:hover::before {
        left: 100%;
    }

    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(255, 87, 34, 0.3);
    }

    /* FOOTER (optional - not in original but good practice) */
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
        
        .content-box h2,
        .center {
            font-size: 2.5rem;
        }
        
        .cards {
            grid-template-columns: repeat(2, 1fr);
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
        .about-hero {
            padding: 8rem 5% 4rem;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        /* SECTIONS */
        .section {
            padding: 3rem 5%;
        }
        
        .content-box h2,
        .center {
            font-size: 2rem;
        }
        
        .content-box p {
            font-size: 1rem;
        }
        
        /* CARDS */
        .cards {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .card {
            padding: 2rem;
        }
        
        /* CTA */
        .about-cta h2 {
            font-size: 2rem;
        }
        
        .cta-btn {
            padding: 0.8rem 2rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .content-box h2,
        .center {
            font-size: 1.8rem;
        }
        
        .about-hero {
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
        
        .about-cta h2 {
            font-size: 1.6rem;
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
    }

    /* PREFERS-REDUCED-MOTION */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* PRINT STYLES */
    @media print {
        .navbar,
        .about-cta,
        .cta-btn {
            display: none;
        }
        
        body {
            background: white;
            color: black;
        }
        
        .section {
            padding: 1rem;
        }
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
<section class="about-hero">
  <div class="hero-content">
    <h1>About ProWorldz</h1>
    <p>
      ProWorldz is a next-generation learning platform focused on empowering
      students with real-world, job-ready technology skills.
    </p>
  </div>
</section>

<!-- WHO WE ARE -->
<section class="section">
  <div class="content-box">
    <h2>Who <span>We Are</span></h2>
    <p>
      ProWorldz is a professional EdTech platform designed to bridge the gap
      between academic learning and industry requirements. We focus on
      practical skills, hands-on projects, and mentorship-driven learning
      to prepare students for real careers in technology.
    </p>
  </div>
</section>

<!-- OUR MISSION -->
<section class="section dark">
  <div class="content-box">
    <h2>Our <span>Mission</span></h2>
    <p>
      Our mission is to provide affordable, high-quality tech education
      that enables learners to build confidence, gain experience, and
      secure opportunities in the IT industry.
    </p>
  </div>
</section>

<!-- WHY PROWORLDZ -->
<section class="section">
  <h2 class="center">Why <span>ProWorldz</span>?</h2>

  <div class="cards">
    <div class="card">
      <h3>Industry-Oriented Learning</h3>
      <p>Courses designed based on real-world industry needs.</p>
    </div>

    <div class="card">
      <h3>Hands-on Projects</h3>
      <p>Practical experience with live and real-time projects.</p>
    </div>

    <div class="card">
      <h3>Expert Mentorship</h3>
      <p>Learn directly from experienced industry professionals.</p>
    </div>

    <div class="card">
      <h3>Career Support</h3>
      <p>Guidance, mentoring, and career-focused learning paths.</p>
    </div>
  </div>
</section>

<!-- VISION -->
<section class="section dark">
  <div class="content-box">
    <h2>Our <span>Vision</span></h2>
    <p>
      To become a trusted learning ecosystem that nurtures innovation,
      creativity, and technical excellence among students worldwide.
    </p>
  </div>
</section>

<!-- CTA -->
<section class="about-cta">
  <h2>Start Your Learning Journey With <span>ProWorldz</span></h2>
  <a href="index.php" class="cta-btn">Explore Courses</a>
</section>

<!-- OPTIONAL FOOTER -->
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
  
  // Add hover effect to cards on mobile
  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('touchstart', () => {
      card.classList.add('hover');
    });
    
    card.addEventListener('touchend', () => {
      setTimeout(() => {
        card.classList.remove('hover');
      }, 150);
    });
  });
  
  // Scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = 'running';
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);
  
  // Observe all animated elements
  document.querySelectorAll('.section, .card, .content-box').forEach(el => {
    observer.observe(el);
  });
  
  // Add smooth scroll
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const targetId = this.getAttribute('href');
      if (targetId !== '#') {
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      }
    });
  });
  
  // Add loading animation
  window.addEventListener('load', () => {
    document.body.classList.add('loaded');
  });
  
  // Parallax effect on hero
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.about-hero');
    if (hero) {
      hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
    }
  });
</script>

</body>
</html>