<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us | ProWorldz</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Reset & Base */
/* ================= RESET ================= */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

/* ================= THEME ================= */
:root{
  --bg-main:#0b0f1a;
  --bg-sidebar:#0f1429;
  --bg-card:#171d36;

  --primary:#6aa9ff;
  --accent:#5eead4;

  --text-main:#ffffff;
  --text-muted:#9aa4bf;

  --border:rgba(255,255,255,0.08);
  --shadow:0 15px 40px rgba(0,0,0,0.6);

  --gradient:linear-gradient(135deg,#6aa9ff,#5eead4);
}

/* ================= BODY ================= */
body{
  background:
    radial-gradient(circle at 20% 20%, rgba(106,169,255,0.08), transparent 40%),
    radial-gradient(circle at 80% 80%, rgba(94,234,212,0.08), transparent 45%),
    linear-gradient(180deg,#070a14,#0b0f1a);
  color:var(--text-main);
  min-height:100vh;
}

/* ================= DASHBOARD ================= */
.dashboard{
  display:flex;
  min-height:100vh;
}

/* ================= SIDEBAR ================= */
.sidebar{
  width:240px;
  background:linear-gradient(180deg,#0f1429,#0b1020);
  padding:20px;
  position:fixed;
  inset:0 auto 0 0;
  border-right:1px solid var(--border);
  z-index:1000;
  transition:.4s ease;
}

.menu{list-style:none;padding-top:40px}

.menu li{margin-bottom:10px}

.menu li a{
  display:flex;
  align-items:center;
  gap:15px;
  padding:14px 16px;
  border-radius:12px;
  color:var(--text-muted);
  text-decoration:none;
  transition:.3s;
}

.menu li a i{font-size:18px}

.menu li a:hover,
.menu li.active a{
  background:rgba(106,169,255,0.15);
  color:var(--text-main);
  box-shadow:inset 0 0 0 1px rgba(106,169,255,.35);
}

.menu li a:hover i,
.menu li.active i{color:var(--primary)}

.close-btn{display:none;color:#fff}

/* ================= MAIN ================= */
.main{
  margin-left:240px;
  padding:40px;
  width:calc(100% - 240px);
}

/* ================= HEADER ================= */
.page-header{
  text-align:center;
  margin-bottom:60px;
}

.page-header h1{
  font-size:3rem;
  background:var(--gradient);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  letter-spacing:1px;
}

.page-header p{
  color:var(--text-muted);
  margin-top:8px;
  font-size:1.1rem;
}

/* ================= ABOUT CARD ================= */
.about-card{
  background:linear-gradient(180deg,rgba(23,29,54,.95),rgba(15,20,40,.95));
  padding:45px;
  border-radius:24px;
  border:1px solid var(--border);
  max-width:1000px;
  margin:0 auto 70px;
  box-shadow:var(--shadow);
}

.about-card h2{
  text-align:center;
  font-size:2.2rem;
  background:var(--gradient);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  margin-bottom:25px;
}

.about-card p{
  text-align:center;
  color:var(--text-muted);
  font-size:1.1rem;
  line-height:1.9;
  max-width:820px;
  margin:0 auto;
}

/* ================= INFO CARDS ================= */
.info-cards{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:30px;
  max-width:1200px;
  margin:0 auto 80px;
}

.info-card{
  background:linear-gradient(180deg,rgba(23,29,54,.95),rgba(15,20,40,.95));
  padding:40px 30px;
  border-radius:22px;
  text-align:center;
  border:1px solid var(--border);
  transition:.4s;
}

.info-card:hover{
  transform:translateY(-10px);
  border-color:var(--primary);
  box-shadow:var(--shadow);
}

.info-card i{
  font-size:2.6rem;
  margin-bottom:20px;
  width:72px;
  height:72px;
  border-radius:50%;
  background:rgba(106,169,255,.15);
  color:var(--primary);
  display:inline-flex;
  align-items:center;
  justify-content:center;
}

.info-card h3{
  font-size:1.5rem;
  margin-bottom:12px;
}

.info-card p{
  color:var(--text-muted);
  font-size:1rem;
  line-height:1.6;
}

/* ================= STATS ================= */
.stats{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:30px;
  max-width:1000px;
  margin:0 auto;
}

.stat-box{
  background:linear-gradient(180deg,rgba(23,29,54,.95),rgba(15,20,40,.95));
  padding:45px 30px;
  border-radius:22px;
  text-align:center;
  border:1px solid var(--border);
  transition:.35s;
}

.stat-box:hover{
  transform:translateY(-6px);
  border-color:var(--primary);
  box-shadow:var(--shadow);
}

.stat-box h2{
  font-size:3rem;
  background:var(--gradient);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  margin-bottom:8px;
}

.stat-box span{
  color:var(--text-muted);
  font-size:1.05rem;
  letter-spacing:1px;
  text-transform:uppercase;
}

/* ================= MOBILE ================= */
.menu-btn{
  display:none;
  position:fixed;
  top:18px;
  left:18px;
  font-size:24px;
  background:none;
  border:none;
  color:#fff;
  z-index:1100;
}

.overlay{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.6);
  z-index:900;
}

/* ================= RESPONSIVE ================= */
@media(max-width:1024px){
  .info-cards,.stats{grid-template-columns:repeat(2,1fr)}
}

@media(max-width:768px){
  .menu-btn{display:block}
  .sidebar{left:-100%;width:280px}
  .sidebar.active{left:0}
  .close-btn{display:block}
  .overlay.active{display:block}
  .main{margin-left:0;width:100%}
  .info-cards,.stats{grid-template-columns:1fr}
}

@media(max-width:480px){
  .page-header h1{font-size:2.1rem}
  .about-card{padding:30px}
}


/* ========== RESPONSIVE DESIGN ========== */

/* Tablets (769px - 1024px) */
@media (max-width: 1024px) {
    .sidebar {
        width: 220px;
    }
    
    .main {
        margin-left: 220px;
        width: calc(100% - 220px);
        padding: 30px;
    }
    
    .info-cards,
    .stats {
        grid-template-columns: repeat(2, 1fr);
        max-width: 800px;
    }
    
    .info-card:last-child,
    .stat-box:last-child {
        grid-column: span 2;
        max-width: 400px;
        justify-self: center;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
    }
    
    .about-card h2 {
        font-size: 1.8rem;
    }
}

/* Large Mobile Devices (481px - 768px) */
@media (max-width: 768px) {
    .menu-btn {
        display: block;
    }
    
    .sidebar {
        left: -100%;
        width: 280px;
    }
    
    .sidebar.active {
        left: 0;
    }
    
    .close-btn {
        display: block;
    }
    
    .overlay.active {
        display: block;
    }
    
    .main {
        margin-left: 0;
        width: 100%;
        padding: 25px;
    }
    
    .info-cards,
    .stats {
        grid-template-columns: 1fr;
        max-width: 500px;
    }
    
    .info-card:last-child,
    .stat-box:last-child {
        grid-column: 1;
        max-width: 100%;
    }
    
    .page-header {
        margin-bottom: 40px;
    }
    
    .page-header h1 {
        font-size: 2.2rem;
    }
    
    .page-header p {
        font-size: 1rem;
    }
    
    .about-card {
        padding: 30px;
    }
}

/* Small Mobile Devices (up to 480px) */
@media (max-width: 480px) {
    .main {
        padding: 20px;
    }
    
    .page-header {
        margin-bottom: 30px;
    }
    
    .page-header h1 {
        font-size: 1.8rem;
    }
    
    .about-card,
    .info-card,
    .stat-box {
        padding: 30px 20px;
    }
    
    .info-card i,
    .info-card h3,
    .stat-box h2 {
        font-size: 2rem;
    }
    
    .info-card i {
        width: 60px;
        height: 60px;
        line-height: 60px;
    }
    
    .stat-box h2 {
        font-size: 2.5rem;
    }
}

/* Extra Small Devices (up to 360px) */
@media (max-width: 360px) {
    .main {
        padding: 15px;
    }
    
    .page-header h1 {
        font-size: 1.6rem;
    }
    
    .page-header p {
        font-size: 0.9rem;
    }
    
    .about-card p,
    .info-card p,
    .stat-box span {
        font-size: 0.9rem;
    }
}

/* Landscape Mode for Mobile */
@media (max-height: 600px) and (orientation: landscape) {
    .sidebar {
        overflow-y: auto;
        height: 100vh;
    }
    
    .menu {
        padding-top: 20px;
    }
    
    .sidebar li {
        padding: 10px 12px;
        margin-bottom: 5px;
    }
    
    .info-cards,
    .stats {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .info-card,
    .stat-box {
        padding: 25px 20px;
    }
}

/* High DPI Screens */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .info-card,
    .stat-box,
    .about-card {
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
    
    .info-card,
    .stat-box,
    .about-card {
        border: 1px solid #000;
        box-shadow: none;
    }
}
</style>
</head>
<body>

<!-- Mobile Menu Button -->
<button class="menu-btn" id="menuBtn">
    <i class="fas fa-bars"></i>
</button>

<div class="dashboard">
  <!-- SIDEBAR NAVIGATION -->
  <aside class="sidebar">
    <div class="close-btn" id="closeBtn">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <ul class="menu">
        <li><a href="index.php" style="color: inherit; text-decoration: none;">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a></li>
        <li><a href="assignment.php" style="color: inherit; text-decoration: none;">
            <i class="fa-solid fa-book"></i>
            <span>Assignment</span>
        </a></li>
        <li><a href="ourcourse.php" style="color: inherit; text-decoration: none;">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Courses</span>
        </a></li>
    </ul>
  </aside>

  <!-- OVERLAY (for mobile) -->
  <div class="overlay" id="overlay"></div>

  <!-- MAIN -->
  <main class="main">

    <!-- HEADER -->
    <section class="page-header">
      <h1>About ProWorldz</h1>
      <p>Learn. Build. Succeed.</p>
    </section>

    <!-- ABOUT CARD -->
    <section class="about-card">
      <h2>Who We Are</h2>
      <p>
        ProWorldz is a modern learning platform focused on empowering students
        with real-world skills in technology, development, and startups.
        Our goal is to bridge the gap between education and industry.
      </p>
    </section>

    <!-- INFO CARDS -->
    <section class="info-cards">

      <div class="info-card">
        <i class="fa-solid fa-bullseye"></i>
        <h3>Our Mission</h3>
        <p>
          To provide practical, hands-on learning experiences that help students
          build confidence and job-ready skills.
        </p>
      </div>

      <div class="info-card">
        <i class="fa-solid fa-eye"></i>
        <h3>Our Vision</h3>
        <p>
          To become a trusted digital learning ecosystem for students,
          creators, and future innovators.
        </p>
      </div>

      <div class="info-card">
        <i class="fa-solid fa-users"></i>
        <h3>Who We Help</h3>
        <p>
          College students, beginners, and aspiring professionals who want
          to learn by doing and grow their careers.
        </p>
      </div>

    </section>

    <!-- STATS -->
    <section class="stats">

      <div class="stat-box">
        <h2>10K+</h2>
        <span>Students</span>
      </div>

      <div class="stat-box">
        <h2>50+</h2>
        <span>Courses</span>
      </div>

      <div class="stat-box">
        <h2>100+</h2>
        <span>Projects</span>
      </div>

    </section>

  </main>
</div>

<script>
// Mobile Menu Functionality
const menuBtn = document.getElementById('menuBtn');
const closeBtn = document.getElementById("closeBtn");
const sidebar = document.querySelector(".sidebar");
const overlay = document.getElementById("overlay");

// Toggle sidebar
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
</script>

</body>
</html>