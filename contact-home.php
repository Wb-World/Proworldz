<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | ProWorldz</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ===== CSS RESET & BASE ===== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    border-color: rgba(229, 231, 235, 0.3);
    outline-color: rgba(156, 163, 175, 0.5);
    overscroll-behavior: none;
}

body {
    font-family: 'Roboto Mono', monospace;
    background-color: #0d1015;
    color: #f8fafc;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    min-height: 100vh;
    overflow-x: hidden;
    line-height: 1.6;
}

/* ===== CUSTOM FONTS ===== */
@font-face {
    font-family: "Rebels";
    src: url("https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2") format("woff2");
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}

/* ===== CUSTOM PROPERTIES (CSS Variables) ===== */
:root {
    --radius: 0.625rem;
    --background: #0d1015;
    --foreground: #f8fafc;
    --card: #1a1d24;
    --card-foreground: #f8fafc;
    --popover: #1a1d24;
    --popover-foreground: #f8fafc;
    --primary: #6366f1;
    --primary-light: #8183f4;
    --primary-foreground: #ffffff;
    --secondary: #2d3748;
    --secondary-foreground: #f8fafc;
    --muted: #2d3748;
    --muted-foreground: #94a3b8;
    --accent: rgba(248, 250, 252, 0.05);
    --accent-foreground: #f8fafc;
    --border: rgba(255, 255, 255, 0.1);
    --input: rgba(255, 255, 255, 0.15);
    --ring: rgba(148, 163, 184, 0.5);
    
    --success: #10b981;
    --destructive: #ef4444;
    --warning: #f59e0b;
    
    --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    --gradient-subtle: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(129, 131, 244, 0.1) 100%);
    --gradient-dark: linear-gradient(135deg, var(--background) 0%, var(--card) 100%);
    
    --sidebar: #1a1d24;
    --sidebar-foreground: #f8fafc;
    --sidebar-primary: #6366f1;
    --sidebar-primary-foreground: #ffffff;
    --sidebar-accent: rgba(248, 250, 252, 0.05);
    --sidebar-accent-foreground: #f8fafc;
    --sidebar-border: rgba(255, 255, 255, 0.1);
    --sidebar-ring: rgba(148, 163, 184, 0.5);
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* ===== DASHBOARD LAYOUT ===== */
.dashboard {
    display: flex;
    min-height: 100vh;
    background: var(--gradient-dark);
    position: relative;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    background: var(--sidebar);
    border-right: 1px solid var(--sidebar-border);
    position: fixed;
    inset: 0 auto 0 0;
    z-index: 1000;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--sidebar-border);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo {
    font-family: 'Rebels', monospace;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--foreground);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logo span {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.logo::before {
    content: '';
    display: block;
    width: 6px;
    height: 6px;
    background: var(--primary);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.menu {
    list-style: none;
    padding: 1.5rem;
}

.menu li {
    margin-bottom: 0.5rem;
}

.menu li a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    border-radius: calc(var(--radius) - 2px);
    color: var(--sidebar-foreground);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.menu li a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    transition: left 0.5s;
}

.menu li a:hover::before {
    left: 100%;
}

.menu li a i {
    font-size: 1rem;
    width: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.menu li a:hover,
.menu li.active a {
    background-color: var(--sidebar-accent);
    color: var(--sidebar-primary);
    border-left: 3px solid var(--sidebar-primary);
}

.menu li a:hover i,
.menu li.active a i {
    color: var(--sidebar-primary);
    transform: scale(1.1);
}

.close-btn {
    display: none;
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    color: var(--muted-foreground);
    font-size: 1.25rem;
    cursor: pointer;
    transition: color 0.3s;
    z-index: 1001;
}

.close-btn:hover {
    color: var(--foreground);
}

/* ===== MAIN CONTENT ===== */
.main {
    margin-left: 260px;
    padding: 2rem;
    width: calc(100% - 260px);
    background: var(--background);
    position: relative;
    min-height: 100vh;
}

.main::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--gradient-primary);
    opacity: 0.2;
}

/* ===== PAGE HEADER ===== */
.page-header {
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
    padding: 2rem 0;
}

.page-header h1 {
    font-family: 'Rebels', monospace;
    font-size: 3.5rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.page-header p {
    color: var(--muted-foreground);
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* ===== CONTACT CARDS ===== */
.contact-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    max-width: 1100px;
    margin: 0 auto 5rem;
}

.contact-card {
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
    padding: 3rem 2rem;
    border-radius: var(--radius);
    text-align: center;
    border: 1px solid var(--border);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.contact-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.contact-card:hover {
    transform: translateY(-10px);
    border-color: var(--primary);
    box-shadow: var(--shadow-2xl);
}

.contact-card:hover::before {
    transform: scaleX(1);
}

.contact-card i {
    font-size: 2.5rem;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--gradient-subtle);
    color: var(--primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 1;
}

.contact-card:hover i {
    transform: scale(1.1) rotate(5deg);
    background: var(--gradient-primary);
    color: var(--primary-foreground);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
}

.contact-card h3 {
    font-family: 'Rebels', monospace;
    font-size: 1.5rem;
    color: var(--foreground);
    margin-bottom: 0.75rem;
    position: relative;
    z-index: 1;
}

.contact-card p {
    color: var(--muted-foreground);
    font-size: 1.1rem;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}

/* ===== CONTACT FORM ===== */
.contact-form-box {
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.95) 100%);
    padding: 3.5rem;
    border-radius: var(--radius);
    max-width: 900px;
    margin: 0 auto;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-xl);
    position: relative;
    overflow: hidden;
}

.contact-form-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.contact-form-box h2 {
    text-align: center;
    font-family: 'Rebels', monospace;
    font-size: 2.25rem;
    margin-bottom: 2.5rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    z-index: 1;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
    position: relative;
    z-index: 1;
}

.input-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.75rem;
}

input, textarea {
    background: var(--input);
    border: 1px solid var(--border);
    color: var(--foreground);
    padding: 1rem 1.25rem;
    border-radius: calc(var(--radius) - 2px);
    font-size: 0.95rem;
    font-family: 'Roboto Mono', monospace;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

input::placeholder,
textarea::placeholder {
    color: var(--muted-foreground);
    opacity: 0.7;
}

input:focus,
textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    transform: translateY(-2px);
}

textarea {
    min-height: 150px;
    resize: vertical;
}

/* ===== SUBMIT BUTTON ===== */
button[type="submit"] {
    background: var(--gradient-primary);
    border: none;
    padding: 1.125rem;
    border-radius: calc(var(--radius) - 2px);
    color: var(--primary-foreground);
    font-size: 1.125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    font-family: 'Roboto Mono', monospace;
}

button[type="submit"]::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

button[type="submit"]:hover::before {
    left: 100%;
}

button[type="submit"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
}

/* ===== MOBILE MENU ===== */
.menu-btn {
    display: none;
    position: fixed;
    top: 1rem;
    left: 1rem;
    font-size: 1.5rem;
    background: var(--card);
    border: 1px solid var(--border);
    color: var(--foreground);
    z-index: 1100;
    cursor: pointer;
    padding: 0.75rem;
    border-radius: calc(var(--radius) - 4px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.menu-btn:hover {
    background: var(--accent);
    color: var(--primary);
    transform: translateY(-2px);
}

.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    z-index: 900;
}

/* ===== TV NOISE EFFECT ===== */
.tv-noise {
    position: absolute;
    inset: 0;
    background: 
        repeating-linear-gradient(
            0deg,
            rgba(0, 0, 0, 0.1) 0px,
            rgba(0, 0, 0, 0.1) 1px,
            transparent 1px,
            transparent 2px
        ),
        repeating-linear-gradient(
            90deg,
            rgba(0, 0, 0, 0.1) 0px,
            rgba(0, 0, 0, 0.1) 1px,
            transparent 1px,
            transparent 2px
        );
    opacity: 0.08;
    pointer-events: none;
    z-index: 1;
    animation: tvNoise 0.1s infinite;
}

@keyframes tvNoise {
    0%, 100% { background-position: 0 0; }
    10% { background-position: -5% -10%; }
    20% { background-position: -15% 5%; }
    30% { background-position: 7% -25%; }
    40% { background-position: 20% 25%; }
    50% { background-position: -25% 10%; }
    60% { background-position: 15% 5%; }
    70% { background-position: 0 15%; }
    80% { background-position: 25% 35%; }
    90% { background-position: -10% 10%; }
}

/* ===== ANIMATIONS ===== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    opacity: 0;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-fadeIn.delay-1 { animation-delay: 0.1s; }
.animate-fadeIn.delay-2 { animation-delay: 0.2s; }
.animate-fadeIn.delay-3 { animation-delay: 0.3s; }
.animate-fadeIn.delay-4 { animation-delay: 0.4s; }

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .sidebar {
        width: 240px;
    }
    
    .main {
        margin-left: 240px;
        width: calc(100% - 240px);
        padding: 1.5rem;
    }
    
    .page-header h1 {
        font-size: 2.75rem;
    }
    
    .contact-cards {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        max-width: 800px;
    }
    
    .contact-card:last-child {
        grid-column: span 2;
        max-width: 400px;
        justify-self: center;
    }
    
    .contact-form-box {
        padding: 2.5rem;
    }
}

@media (max-width: 768px) {
    .menu-btn {
        display: block;
    }
    
    .close-btn {
        display: block;
    }
    
    .sidebar {
        transform: translateX(-100%);
        width: 300px;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .overlay.active {
        display: block;
    }
    
    .main {
        margin-left: 0;
        width: 100%;
        padding: 1.25rem;
    }
    
    .page-header {
        margin-bottom: 3rem;
        padding: 1.5rem 0;
    }
    
    .page-header h1 {
        font-size: 2.25rem;
    }
    
    .page-header p {
        font-size: 1rem;
    }
    
    .contact-cards {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        max-width: 500px;
    }
    
    .contact-card:last-child {
        grid-column: 1;
        max-width: 100%;
    }
    
    .contact-form-box {
        padding: 2rem;
    }
    
    .contact-form-box h2 {
        font-size: 1.875rem;
    }
    
    .input-group {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .contact-card {
        padding: 2.5rem 2rem;
    }
}

@media (max-width: 480px) {
    .main {
        padding: 1rem;
    }
    
    .page-header {
        margin-bottom: 2.5rem;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .contact-card {
        padding: 2rem 1.5rem;
    }
    
    .contact-card i {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
    
    .contact-form-box {
        padding: 1.75rem 1.5rem;
    }
    
    .contact-form-box h2 {
        font-size: 1.75rem;
        margin-bottom: 2rem;
    }
    
    input, textarea {
        padding: 0.875rem 1rem;
    }
    
    button[type="submit"] {
        padding: 1rem;
        font-size: 1rem;
    }
}

@media (max-width: 360px) {
    .page-header h1 {
        font-size: 1.75rem;
    }
    
    .contact-card h3 {
        font-size: 1.3rem;
    }
    
    .contact-card p {
        font-size: 1rem;
    }
    
    .contact-form-box h2 {
        font-size: 1.5rem;
    }
}

/* Landscape Mode */
@media (max-height: 600px) and (orientation: landscape) {
    .sidebar {
        overflow-y: auto;
        height: 100vh;
    }
    
    .menu {
        padding: 1rem;
    }
    
    .menu li {
        margin-bottom: 0.25rem;
    }
    
    .menu li a {
        padding: 0.75rem 1rem;
    }
    
    .contact-cards {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
}

/* High DPI Screens */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .contact-card,
    .contact-form-box {
        border-width: 1.5px;
    }
    
    input, textarea {
        border-width: 1.5px;
    }
}

/* Print Styles */
@media print {
    body {
        background: white;
        color: black;
    }
    
    .sidebar {
        display: none;
    }
    
    .main {
        margin-left: 0;
        width: 100%;
    }
    
    .contact-card,
    .contact-form-box {
        border: 1px solid #000;
        box-shadow: none;
    }
    
    button[type="submit"] {
        background: #000;
        color: white;
    }
}
</style>
</head>
<body>
<!-- TV Noise Effect -->
<div class="tv-noise"></div>

<!-- Mobile Menu Button -->
<button class="menu-btn" id="menuBtn">
    <i class="fas fa-bars"></i>
</button>

<div class="dashboard">
  <!-- SIDEBAR NAVIGATION -->
  <aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">PRO<span>WORLDZ</span></div>
        <button class="close-btn" id="closeBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <ul class="menu">
        <li class="animate-fadeIn">
            <a href="dashboard.php" style="color: inherit; text-decoration: none;">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="animate-fadeIn delay-1">
            <a href="assignment.php" style="color: inherit; text-decoration: none;">
                <i class="fa-solid fa-file-alt"></i>
                <span>Assignment</span>
            </a>
        </li>
        <li class="animate-fadeIn delay-2 active">
            <a href="ourcourse.php" style="color: inherit; text-decoration: none;">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Courses</span>
            </a>
        </li>
    </ul>
  </aside>

  <!-- OVERLAY (for mobile) -->
  <div class="overlay" id="overlay"></div>

  <!-- MAIN -->
  <main class="main">
    <!-- HEADER -->
    <section class="page-header animate-fadeIn">
      <h1>Contact Us</h1>
      <p>We're here to help — get in touch with us</p>
    </section>

    <!-- CONTACT INFO -->
    <section class="contact-cards">
      <div class="contact-card animate-fadeIn delay-1">
        <i class="fa-solid fa-envelope"></i>
        <h3>Email</h3>
        <p>support@proworldz.com</p>
      </div>

      <div class="contact-card animate-fadeIn delay-2">
        <i class="fa-solid fa-phone"></i>
        <h3>Phone</h3>
        <p>+91 98765 43210</p>
      </div>

      <div class="contact-card animate-fadeIn delay-3">
        <i class="fa-solid fa-location-dot"></i>
        <h3>Location</h3>
        <p>Chennai, Tamil Nadu</p>
      </div>
    </section>

    <!-- CONTACT FORM -->
    <section class="contact-form-box animate-fadeIn delay-4">
      <h2>Send Us a Message</h2>

      <form class="contact-form">
        <div class="input-group">
          <input type="text" placeholder="Your Name" required>
          <input type="email" placeholder="Your Email" required>
        </div>

        <input type="text" placeholder="Subject" required>

        <textarea placeholder="Your Message" rows="5" required></textarea>

        <button type="submit">Send Message</button>
      </form>
    </section>
  </main>
</div>

<script>
// DOM Elements
const menuBtn = document.getElementById('menuBtn');
const closeBtn = document.getElementById("closeBtn");
const sidebar = document.querySelector(".sidebar");
const overlay = document.getElementById("overlay");

// Animation observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animationPlayState = 'running';
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

// Mobile Menu Functionality
menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : 'auto';
});

closeBtn.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = 'auto';
});

overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = 'auto';
});

// Close sidebar when clicking on menu links (mobile)
const menuLinks = document.querySelectorAll('.menu a');
menuLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });
});

// Close sidebar on window resize (if resized to desktop)
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
});

// Form submission
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form values
        const name = contactForm.querySelector('input[type="text"]').value;
        const email = contactForm.querySelector('input[type="email"]').value;
        const subject = contactForm.querySelectorAll('input[type="text"]')[1].value;
        const message = contactForm.querySelector('textarea').value;
        
        // In a real application, you would send this data to a server
        // For demo purposes, we'll just show an alert
        alert(`Thank you, ${name}! Your message has been sent.\nWe'll respond to ${email} shortly.`);
        
        // Reset form
        contactForm.reset();
        
        // Add visual feedback
        const submitBtn = contactForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Message Sent!';
        submitBtn.style.background = 'var(--success)';
        
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.style.background = '';
        }, 3000);
    });
}

// Observe all animated elements
document.querySelectorAll('.animate-fadeIn').forEach(el => {
    observer.observe(el);
});

// Add hover effects to cards
document.querySelectorAll('.contact-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// Add form input focus effects
const inputs = document.querySelectorAll('input, textarea');
inputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
});

// Add parallax effect to TV noise
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const tvNoise = document.querySelector('.tv-noise');
    if (tvNoise) {
        tvNoise.style.transform = `translateY(${scrolled * 0.05}px)`;
    }
});

// Initialize on load
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});
</script>
</body>
</html>