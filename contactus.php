<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | ProWorldz</title>

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
  z-index:1000;
  border-right:1px solid var(--border);
  transition:0.4s ease;
}

.menu{
  padding-top:50px;
  list-style:none;
}

.sidebar li{
  margin-bottom:10px;
}

.sidebar li a{
  display:flex;
  align-items:center;
  gap:15px;
  padding:14px 16px;
  border-radius:12px;
  color:var(--text-muted);
  text-decoration:none;
  transition:0.3s ease;
}

.sidebar li a i{
  font-size:18px;
  min-width:22px;
}

.sidebar li:hover a,
.sidebar li.active a{
  background:rgba(106,169,255,0.15);
  color:var(--text-main);
  box-shadow:inset 0 0 0 1px rgba(106,169,255,0.35);
}

.sidebar li:hover i,
.sidebar li.active i{
  color:var(--primary);
}

.close-btn{
  display:none;
  position:absolute;
  top:18px;
  right:18px;
  font-size:22px;
  color:#fff;
  cursor:pointer;
}

/* ================= MOBILE MENU BTN ================= */
.menu-btn{
  display:none;
  position:fixed;
  top:20px;
  left:20px;
  z-index:1100;
  font-size:24px;
  background:none;
  border:none;
  color:#fff;
  cursor:pointer;
}

/* ================= OVERLAY ================= */
.overlay{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.6);
  z-index:900;
}

.overlay.active{display:block}

/* ================= MAIN ================= */
.main{
  margin-left:240px;
  padding:40px;
  width:calc(100% - 240px);
}

/* ================= PAGE HEADER ================= */
.page-header{
  text-align:center;
  margin-bottom:50px;
}

.page-header h1{
  font-size:3rem;
  background:var(--gradient);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.page-header p{
  color:var(--text-muted);
  font-size:1.1rem;
  margin-top:10px;
}

/* ================= CONTACT CARDS ================= */
.contact-cards{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:30px;
  max-width:1100px;
  margin:0 auto 60px;
}

.contact-card{
  background:linear-gradient(180deg,rgba(23,29,54,0.95),rgba(15,20,40,0.95));
  padding:40px 30px;
  border-radius:20px;
  text-align:center;
  border:1px solid var(--border);
  transition:0.4s ease;
}

.contact-card:hover{
  transform:translateY(-10px);
  border-color:var(--primary);
  box-shadow:var(--shadow);
}

.contact-card i{
  font-size:2.5rem;
  color:var(--primary);
  background:rgba(106,169,255,0.15);
  width:70px;
  height:70px;
  line-height:70px;
  border-radius:50%;
  margin-bottom:20px;
}

.contact-card h3{
  font-size:1.5rem;
  margin-bottom:10px;
}

.contact-card p{
  color:var(--text-muted);
}

/* ================= CONTACT FORM ================= */
.contact-form-box{
  background:linear-gradient(180deg,rgba(23,29,54,0.95),rgba(15,20,40,0.95));
  padding:50px;
  border-radius:24px;
  max-width:900px;
  margin:0 auto;
  border:1px solid var(--border);
  box-shadow:var(--shadow);
}

.contact-form-box h2{
  text-align:center;
  font-size:2.2rem;
  margin-bottom:35px;
  background:var(--gradient);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.contact-form{
  display:flex;
  flex-direction:column;
  gap:25px;
}

.input-group{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:25px;
}

input,textarea{
  background:rgba(255,255,255,0.05);
  border:1px solid var(--border);
  color:#fff;
  padding:18px 22px;
  border-radius:12px;
  font-size:1rem;
}

input::placeholder,
textarea::placeholder{
  color:var(--text-muted);
}

input:focus,
textarea:focus{
  outline:none;
  border-color:var(--primary);
  box-shadow:0 0 0 3px rgba(106,169,255,0.25);
}

textarea{min-height:150px}

/* ================= SUBMIT BTN ================= */
button[type="submit"]{
  background:var(--gradient);
  border:none;
  padding:18px;
  border-radius:14px;
  color:#fff;
  font-size:1.1rem;
  font-weight:600;
  cursor:pointer;
  transition:0.3s;
}

button[type="submit"]:hover{
  transform:translateY(-3px);
  box-shadow:0 15px 35px rgba(106,169,255,0.45);
}

/* ================= RESPONSIVE ================= */
@media(max-width:1024px){
  .contact-cards{grid-template-columns:repeat(2,1fr)}
}

@media(max-width:768px){
  .menu-btn{display:block}

  .sidebar{left:-100%;width:280px}
  .sidebar.active{left:0}

  .close-btn{display:block}

  .main{
    margin-left:0;
    width:100%;
    padding:25px;
  }

  .contact-cards{grid-template-columns:1fr}

  .input-group{grid-template-columns:1fr}
}

@media(max-width:480px){
  .page-header h1{font-size:2rem}
  .contact-form-box{padding:30px 20px}
}


/* ========== RESPONSIVE DESIGN ========== */

/* Large Tablets & Small Laptops (1025px - 1200px) */
@media (max-width: 1200px) {
    .main {
        padding: 30px;
    }
    
    .contact-cards {
        gap: 25px;
        max-width: 1000px;
    }
    
    .contact-form-box {
        padding: 40px;
        max-width: 800px;
    }
}

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
    
    .contact-cards {
        grid-template-columns: repeat(2, 1fr);
        max-width: 800px;
    }
    
    .contact-card:last-child {
        grid-column: span 2;
        max-width: 400px;
        justify-self: center;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
    }
    
    .contact-form-box h2 {
        font-size: 2rem;
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
    
    .contact-cards {
        grid-template-columns: 1fr;
        max-width: 500px;
    }
    
    .contact-card:last-child {
        grid-column: 1;
        max-width: 100%;
    }
    
    .contact-form-box {
        padding: 30px;
    }
    
    .input-group {
        grid-template-columns: 1fr;
        gap: 20px;
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
    
    .contact-card {
        padding: 30px 20px;
    }
    
    .contact-card i {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        line-height: 60px;
    }
    
    .contact-form-box {
        padding: 25px 20px;
        border-radius: 20px;
    }
    
    .contact-form-box h2 {
        font-size: 1.6rem;
        margin-bottom: 30px;
    }
    
    input, textarea {
        padding: 16px 20px;
        font-size: 0.95rem;
    }
    
    button[type="submit"] {
        padding: 16px;
        font-size: 1rem;
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
    
    .contact-card h3 {
        font-size: 1.3rem;
    }
    
    .contact-card p {
        font-size: 0.9rem;
    }
    
    .contact-form-box h2 {
        font-size: 1.4rem;
    }
    
    input, textarea {
        padding: 14px 18px;
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
    
    .contact-cards {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .contact-card {
        padding: 25px 20px;
    }
}

/* High DPI Screens */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .contact-card {
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
    
    .contact-card {
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
        <li><a href="dashboard.php" style="color: inherit; text-decoration: none;">
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
      <h1>Contact Us</h1>
      <p>We’re here to help — get in touch with us</p>
    </section>

    <!-- CONTACT INFO -->
    <section class="contact-cards">

      <div class="contact-card">
        <i class="fa-solid fa-envelope"></i>
        <h3>Email</h3>
        <p>support@proworldz.com</p>
      </div>

      <div class="contact-card">
        <i class="fa-solid fa-phone"></i>
        <h3>Phone</h3>
        <p>+91 98765 43210</p>
      </div>

      <div class="contact-card">
        <i class="fa-solid fa-location-dot"></i>
        <h3>Location</h3>
        <p>Chennai, Tamil Nadu</p>
      </div>

    </section>

    <!-- CONTACT FORM -->
    <section class="contact-form-box">
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
        submitBtn.style.background = '#4CAF50';
        
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.style.background = '';
        }, 3000);
    });
}
</script>

</body>
</html>