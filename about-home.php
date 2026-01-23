<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | ProWorldz</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
   /* ================= RESET ================= */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* ================= ROOT THEME ================= */
:root {
  --bg-main: #05070d;
  --bg-soft: #0b0e14;
  --glass-dark: rgba(20, 24, 35, 0.88);

  --primary: #7c7cff;
  --secondary: #2dd4bf;

  --text-main: #ffffff;
  --text-muted: #9aa4bf;

  --border-soft: rgba(255,255,255,0.06);

  --gradient-main: linear-gradient(135deg, #7c7cff 0%, #5eead4 100%);

  --shadow-soft:
    0 20px 50px rgba(0,0,0,0.6),
    inset 0 0 0 1px rgba(255,255,255,0.04);

  --transition: all 0.35s ease;
}

/* ================= BODY (EXACT IMAGE FEEL) ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 20% 15%, rgba(124,124,255,0.12), transparent 40%),
    radial-gradient(circle at 80% 85%, rgba(45,212,191,0.10), transparent 45%),
    linear-gradient(180deg, #05070d 0%, #0b0e14 45%, #05070d 100%);
  color: var(--text-main);
  overflow-x: hidden;
  line-height: 1.6;
}

/* ================= NAVBAR ================= */
.navbar {
  position: fixed;
  inset: 0 0 auto 0;
  height: 80px;
  padding: 0 5%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(
    180deg,
    rgba(10,12,20,0.9),
    rgba(5,7,13,0.95)
  );
  backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border-soft);
  z-index: 1000;
}

/* LOGO */
.logo {
  font-size: 1.9rem;
  font-weight: 700;
  color: var(--text-main);
}

.logo span {
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* ================= NAV LINKS ================= */
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
  left: 0;
  bottom: -6px;
  width: 0;
  height: 2px;
  background: var(--gradient-main);
  transition: width .3s;
}

.nav-item a:hover::after {
  width: 100%;
}

/* ================= BUTTONS ================= */
.login,
.signup {
  padding: 0.6rem 1.5rem;
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
  box-shadow: 0 0 0 rgba(124,124,255,0);
}

.signup:hover {
  transform: translateY(-2px);
  box-shadow: 0 25px 60px rgba(124,124,255,0.35);
}

/* ================= HERO ================= */
.about-hero {
  padding: 160px 5% 100px;
  text-align: center;
  background:
    linear-gradient(180deg, rgba(5,7,13,0.75), rgba(5,7,13,0.95)),
    url("https://images.unsplash.com/photo-1516321318423-f06f85e504b3");
  background-size: cover;
  background-position: center;
}

.hero-content h1 {
  font-size: 3.8rem;
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-content p {
  margin-top: 1rem;
  color: var(--text-muted);
  font-size: 1.2rem;
}

/* ================= SECTIONS ================= */
.section {
  padding: 5rem 5%;
}

.section.dark {
  background: linear-gradient(
    180deg,
    rgba(20,24,35,0.9),
    rgba(12,15,25,0.95)
  );
  backdrop-filter: blur(18px);
}

/* ================= CONTENT BOX ================= */
.content-box {
  max-width: 850px;
  margin: auto;
  text-align: center;
}

.content-box h2 {
  font-size: 3rem;
}

.content-box h2 span {
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.content-box p {
  margin-top: 1rem;
  color: var(--text-muted);
  font-size: 1.1rem;
}

/* ================= CARDS ================= */
.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.card {
  padding: 2.5rem;
  border-radius: 18px;
  background: linear-gradient(
    180deg,
    rgba(25,30,45,0.9),
    rgba(15,18,30,0.95)
  );
  backdrop-filter: blur(18px);
  border: 1px solid var(--border-soft);
  transition: var(--transition);
}

.card:hover {
  transform: translateY(-12px);
  box-shadow: var(--shadow-soft);
  border-color: var(--primary);
}

.card h3 {
  margin-bottom: .7rem;
}

.card p {
  color: var(--text-muted);
}

/* ================= CTA ================= */
.about-cta {
  padding: 6rem 5%;
  text-align: center;
  background:
    radial-gradient(circle at center, rgba(124,124,255,0.15), transparent 60%),
    linear-gradient(180deg, rgba(20,24,35,0.9), rgba(5,7,13,0.95));
}

.cta-btn {
  display: inline-block;
  margin-top: 2rem;
  padding: 1rem 2.5rem;
  border-radius: 999px;
  background: var(--gradient-main);
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  transition: var(--transition);
}

.cta-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 25px 60px rgba(124,124,255,0.4);
}

/* ================= FOOTER ================= */
.footer {
  padding: 2rem;
  text-align: center;
  color: var(--text-muted);
  border-top: 1px solid var(--border-soft);
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
            backdrop-filter: blur(16px);
  background: linear-gradient(
    180deg,
    rgba(25, 30, 45, 0.9),
    rgba(15, 18, 30, 0.95)
  );
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