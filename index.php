<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ProWorldz Courses</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <style>
    /* ====== GLOBAL STYLES ====== */
    :root {
  /* ===== CORE BACKGROUND ===== */
  --dark-bg: #0b0e14;
  --dark-card: rgba(20, 24, 35, 0.85);
  --dark-hover: rgba(28, 33, 48, 0.95);

  /* ===== PRIMARY NEON THEME ===== */
  --primary: #7c7cff;        /* Neon Blue/Violet */
  --primary-dark: #5a5aff;
  --primary-light: #a5a5ff;

  /* ===== SECONDARY ACCENTS ===== */
  --secondary: #2dd4bf;      /* Soft Neon Green */
  --danger: #ff4d4d;         /* Alerts / Rank */

  /* ===== TEXT ===== */
  --light-text: #ffffff;
  --light-text-secondary: #9aa4bf;

  /* ===== GRADIENTS ===== */
  --gradient: linear-gradient(
    135deg,
    #7c7cff 0%,
    #5eead4 100%
  );

  --gradient-hover: linear-gradient(
    135deg,
    #5eead4 0%,
    #7c7cff 100%
  );

  /* ===== EFFECTS ===== */
  --border-radius: 18px;

  --shadow: 
    0 10px 30px rgba(0, 0, 0, 0.6),
    inset 0 0 0 1px rgba(255, 255, 255, 0.04);

  --shadow-hover:
    0 25px 60px rgba(124, 124, 255, 0.25);

  --transition: all 0.35s ease;
}


    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--dark-bg);
      color: var(--light-text);
      overflow-x: hidden;
      line-height: 1.6;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 28px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.7s;
      z-index: -1;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn.login {
      background: transparent;
      color: var(--light-text);
      border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .btn.login:hover {
      border-color: var(--primary);
      color: var(--primary);
      transform: translateY(-2px);
    }

    .btn.signup {
      background: var(--gradient);
      color: white;
    }

    .btn.signup:hover {
      background: var(--gradient-hover);
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3);
    }

    /* ====== ANIMATIONS ====== */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
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

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(255, 87, 34, 0.4);
      }
      70% {
        box-shadow: 0 0 0 15px rgba(255, 87, 34, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(255, 87, 34, 0);
      }
    }

    @keyframes shimmer {
      0% {
        background-position: -1000px 0;
      }
      100% {
        background-position: 1000px 0;
      }
    }

    /* ====== NAVBAR ====== */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem 5%;
      background-color: rgba(10, 10, 10, 0.95);
      backdrop-filter: blur(15px);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      animation: slideInDown 0.8s ease;
    }

    .logo {
      font-size: 2rem;
      font-weight: 800;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      position: relative;
      display: inline-block;
    }

    .logo::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 3px;
      background: var(--gradient);
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.6s ease;
    }

    .logo:hover::after {
      transform: scaleX(1);
      transform-origin: left;
    }

    .nav-links {
      display: flex;
      list-style: none;
      gap: 2.5rem;
      align-items: center;
    }

    .nav-item {
      position: relative;
    }

    .nav-item a {
      font-weight: 500;
      font-size: 1rem;
      color: var(--light-text-secondary);
      transition: var(--transition);
      position: relative;
      padding: 0.5rem 0;
    }

    .nav-item a::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--gradient);
      transition: width 0.3s ease;
    }

    .nav-item a:hover,
    .nav-item.active a {
      color: var(--light-text);
    }

    .nav-item a:hover::before,
    .nav-item.active a::before {
      width: 100%;
    }

    .nav-btns {
      display: flex;
      gap: 1rem;
    }

    .mobile-btns {
      display: none;
      flex-direction: column;
      gap: 1rem;
      padding: 2rem;
      width: 100%;
    }

    /* HAMBURGER MENU */
    .menu-toggle {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      z-index: 1001;
      padding: 5px;
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
      background: var(--primary);
    }

    .menu-toggle.active span:nth-child(2) {
      opacity: 0;
    }

    .menu-toggle.active span:nth-child(3) {
      transform: rotate(-45deg) translate(7px, -6px);
      background: var(--primary);
    }

    /* ====== HERO SECTION ====== */
    .hero {
      padding: 12rem 5% 6rem;
      text-align: center;
      background: linear-gradient(135deg, 
        rgba(10, 10, 10, 0.95) 0%, 
        rgba(26, 26, 26, 0.9) 100%),
        url('https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at 30% 20%, rgba(255, 87, 34, 0.1) 0%, transparent 50%),
                  radial-gradient(circle at 70% 80%, rgba(33, 150, 243, 0.1) 0%, transparent 50%);
      animation: float 6s ease-in-out infinite;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.2;
      position: relative;
      z-index: 1;
      animation: fadeIn 1s ease-out;
    }

    .hero h1 span {
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      display: inline-block;
      animation: float 3s ease-in-out infinite;
    }

    .hero p {
      font-size: 1.2rem;
      color: var(--light-text-secondary);
      max-width: 700px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
      animation: fadeIn 1s ease-out 0.3s both;
    }

    /* ====== COURSES SECTION ====== */
    .courses {
      padding: 4rem 5%;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 2.5rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    .course-card-full {
      background: var(--dark-card);
      border-radius: var(--border-radius);
      overflow: hidden;
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.05);
      position: relative;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeIn 0.6s ease-out forwards;
      backdrop-filter: blur(16px);
  background: linear-gradient(
    180deg,
    rgba(25, 30, 45, 0.9),
    rgba(15, 18, 30, 0.95)
  );
    }

    .course-card-full:nth-child(1) { animation-delay: 0.1s; }
    .course-card-full:nth-child(2) { animation-delay: 0.2s; }
    .course-card-full:nth-child(3) { animation-delay: 0.3s; }
    .course-card-full:nth-child(4) { animation-delay: 0.4s; }
    .course-card-full:nth-child(5) { animation-delay: 0.5s; }
    .course-card-full:nth-child(6) { animation-delay: 0.6s; }
    .course-card-full:nth-child(7) { animation-delay: 0.7s; }
    .course-card-full:nth-child(8) { animation-delay: 0.8s; }
    .course-card-full:nth-child(9) { animation-delay: 0.9s; }

    .course-card-full:hover {
      transform: translateY(-15px);
      border-color: var(--primary);
      box-shadow: var(--shadow-hover);
    }

    .course-card-full::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 87, 34, 0.05), transparent);
      transition: left 0.8s;
    }

    .course-card-full:hover::before {
      left: 100%;
    }

    .course-img {
      height: 220px;
      overflow: hidden;
      position: relative;
    }

    .course-img::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
    }

    .course-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.8s ease;
      filter: brightness(0.8);
    }

    .course-card-full:hover .course-img img {
      transform: scale(1.1);
      filter: brightness(1);
    }

    .course-content {
      padding: 2rem;
      position: relative;
      z-index: 1;
    }

    .course-content h3 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: var(--light-text);
      position: relative;
      display: inline-block;
    }

    .course-content h3::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 50px;
      height: 3px;
      background: var(--gradient);
      border-radius: 2px;
      transition: width 0.3s ease;
    }

    .course-card-full:hover .course-content h3::after {
      width: 100%;
    }

    .course-content p {
      color: var(--light-text-secondary);
      margin-bottom: 1.5rem;
      line-height: 1.7;
      font-size: 0.95rem;
    }

    .course-btn {
      background: var(--gradient);
      color: white;
      border: none;
      padding: 12px 28px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      transition: var(--transition);
      width: 100%;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .course-btn:hover {
      background: var(--gradient-hover);
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(255, 87, 34, 0.3);
    }

    .course-btn::after {
      content: '→';
      opacity: 0;
      transform: translateX(-10px);
      transition: all 0.3s ease;
    }

    .course-btn:hover::after {
      opacity: 1;
      transform: translateX(0);
    }

    /* ====== RESPONSIVE DESIGN ====== */
    @media (max-width: 1200px) {
      .courses {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      }
      
      .hero h1 {
        font-size: 3rem;
      }
    }

    @media (max-width: 992px) {
      .navbar {
        padding: 1.2rem 5%;
      }
      
      .nav-links {
        gap: 2rem;
      }
      
      .hero {
        padding: 10rem 5% 5rem;
      }
      
      .hero h1 {
        font-size: 2.8rem;
      }
      
      .courses {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
      }
    }

    @media (max-width: 768px) {
      /* MOBILE NAVIGATION */
      .menu-toggle {
        display: flex;
      }
      
      .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 300px;
        height: 100vh;
        background: rgba(10, 10, 10, 0.98);
        backdrop-filter: blur(20px);
        flex-direction: column;
        padding: 6rem 2rem 2rem;
        transition: var(--transition);
        border-left: 1px solid rgba(255, 255, 255, 0.05);
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
      .hero {
        padding: 8rem 5% 4rem;
        background-attachment: scroll;
      }
      
      .hero h1 {
        font-size: 2.5rem;
      }
      
      .hero p {
        font-size: 1.1rem;
      }
      
      /* COURSES */
      .courses {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
      }
      
      .course-card-full {
        animation-delay: 0.2s !important;
      }
    }

    @media (max-width: 576px) {
      .hero h1 {
        font-size: 2rem;
      }
      
      .hero p {
        font-size: 1rem;
      }
      
      .courses {
        grid-template-columns: 1fr;
        padding: 3rem 5%;
      }
      
      .course-img {
        height: 200px;
      }
      
      .course-content {
        padding: 1.5rem;
      }
      
      .course-content h3 {
        font-size: 1.3rem;
      }
      
      .logo {
        font-size: 1.8rem;
      }
      
      .navbar {
        padding: 1rem 5%;
      }
      
      .nav-links {
        width: 100%;
      }
    }

    @media (max-width: 400px) {
      .hero h1 {
        font-size: 1.8rem;
      }
      
      .course-content h3 {
        font-size: 1.2rem;
      }
      
      .course-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
      }
    }

    /* ====== ACCESSIBILITY ====== */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }

    /* ====== LOADING ANIMATIONS ====== */
    .loading {
      position: relative;
      overflow: hidden;
    }

    .loading::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
      animation: shimmer 1.5s infinite;
    }

    /* ====== SCROLL ANIMATIONS ====== */
    .animate-on-scroll {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* ====== FOOTER (OPTIONAL) ====== */
    .footer {
      padding: 3rem 5%;
      text-align: center;
      background: rgba(10, 10, 10, 0.95);
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      margin-top: 4rem;
    }

    .footer p {
      color: var(--light-text-secondary);
      font-size: 0.9rem;
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
    <li class="nav-item active"><a href="./index.php">Courses</a></li>
    <li class="nav-item"><a href="about-home.php">About Us</a></li>
    <li class="nav-item"><a href="contact-home.php">Contact</a></li>

    <!-- MOBILE BUTTONS -->
    <div class="mobile-btns">
      <a href="login.php" class="btn login">Login</a>
      <a href="signup.php" class="btn signup">Sign Up</a>
    </div>
  </ul>

  <!-- DESKTOP BUTTONS -->
  <div class="nav-btns">
    <a href="login.php" class="btn login">Login</a>
    <a href="signup.php" class="btn signup">Sign Up</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <h1>Master the Skills <span>You Need to Succeed in Tech</span></h1>
  <p>Explore our comprehensive collection of courses designed to transform you into a tech professional</p>
</section>

<!-- COURSES -->
<section class="courses">
  <!-- CARD 1 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="Full Stack Development Course">
    </div>
    <div class="course-content">
      <h3>Full Stack Development</h3>
      <p>Master frontend and backend technologies to build complete web applications from scratch.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=fullstack'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 2 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="Python Programming Course">
    </div>
    <div class="course-content">
      <h3>Python Programming</h3>
      <p>Learn Python from basics to advanced level with data science, automation, and web development.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=python'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 3 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="Cyber Security Course">
    </div>
    <div class="course-content">
      <h3>Cyber Security</h3>
      <p>Learn ethical hacking, network security, cryptography, and system protection techniques.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=cyber'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 4 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="Data Science Course">
    </div>
    <div class="course-content">
      <h3>Data Science</h3>
      <p>Master data analysis, machine learning, and visualization with Python and TensorFlow.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=datascience'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 5 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="Mobile Development Course">
    </div>
    <div class="course-content">
      <h3>Mobile Development</h3>
      <p>Build cross-platform mobile apps with React Native and Flutter. Learn app deployment.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=mobile'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 6 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="UI/UX Design Course">
    </div>
    <div class="course-content">
      <h3>UI/UX Design</h3>
      <p>Master user interface and experience design principles with Figma and prototyping tools.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=design'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 7 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="Cloud Computing Course">
    </div>
    <div class="course-content">
      <h3>Cloud Computing</h3>
      <p>Learn AWS, Azure, and Google Cloud. Deploy, manage, and scale applications in the cloud.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=cloud'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 8 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="DevOps Course">
    </div>
    <div class="course-content">
      <h3>DevOps Engineering</h3>
      <p>Master CI/CD, Docker, Kubernetes, and infrastructure as code. Automate deployment pipelines.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=devops'">
        Course Details
      </button>
    </div>
  </div>

  <!-- CARD 9 -->
  <div class="course-card-full">
    <div class="course-img">
      <img src="./pydesk.jpeg" alt="AI & ML Course">
    </div>
    <div class="course-content">
      <h3>AI & Machine Learning</h3>
      <p>Learn artificial intelligence, deep learning, and neural networks with practical projects.</p>
      <button class="course-btn" onclick="location.href='course-details.php?course=ai'">
        Course Details
      </button>
    </div>
  </div>
</section>

<!-- OPTIONAL FOOTER -->
<footer class="footer">
  <p>&copy; 2026 ProWorldz. All rights reserved. | Empowering the next generation of tech professionals</p>
</footer>

<script>
  // ====== MOBILE MENU TOGGLE ======
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
  
  // ====== SCROLL ANIMATIONS ======
  const animateOnScroll = () => {
    const elements = document.querySelectorAll('.course-card-full');
    
    elements.forEach(element => {
      const elementPosition = element.getBoundingClientRect().top;
      const screenPosition = window.innerHeight / 1.2;
      
      if (elementPosition < screenPosition) {
        element.classList.add('visible');
      }
    });
  };
  
  // Initial check
  animateOnScroll();
  
  // Listen to scroll events
  window.addEventListener('scroll', animateOnScroll);
  
  // ====== PARALLAX EFFECT ======
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    
    if (hero) {
      hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
    }
  });
  
  // ====== COURSE CARDS HOVER EFFECT ======
  document.querySelectorAll('.course-card-full').forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.style.zIndex = '10';
    });
    
    card.addEventListener('mouseleave', () => {
      card.style.zIndex = '1';
    });
    
    // Touch support for mobile
    card.addEventListener('touchstart', () => {
      card.classList.add('hover');
    });
    
    card.addEventListener('touchend', () => {
      setTimeout(() => {
        card.classList.remove('hover');
      }, 300);
    });
  });
  
  // ====== SMOOTH SCROLL ======
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
  
  // ====== PAGE LOAD ANIMATION ======
  window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    
    // Add loading animation to all course cards
    const cards = document.querySelectorAll('.course-card-full');
    cards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.1}s`;
    });
  });
  
  // ====== RESIZE HANDLER ======
  window.addEventListener('resize', () => {
    // Close mobile menu if resized to desktop
    if (window.innerWidth > 768) {
      menuToggle.classList.remove('active');
      navLinks.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  });
</script>

</body>
</html>