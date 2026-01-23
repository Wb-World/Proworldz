<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Courses | ProWorldz</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ================= RESET ================= */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

/* ================= THEME VARS ================= */
:root{
  --bg-main:#0b0f1a;
  --bg-sidebar:#0e142f;
  --bg-card:#121833;

  --primary:#6aa9ff;
  --accent:#5eead4;

  --text-main:#ffffff;
  --text-muted:#9aa4bf;

  --border:rgba(255,255,255,0.12);
  --shadow:0 20px 45px rgba(0,0,0,.55);

  --gradient:linear-gradient(135deg,#6aa9ff,#5eead4);
}

/* ================= BODY ================= */
body{
  background:
    radial-gradient(circle at 20% 20%, rgba(106,169,255,.08), transparent 40%),
    radial-gradient(circle at 80% 80%, rgba(94,234,212,.08), transparent 45%),
    linear-gradient(180deg,#070a14,#0b0f1a);
  color:var(--text-main);
  min-height:100vh;
}

/* ================= LAYOUT ================= */
.dashboard{
  display:flex;
  min-height:100vh;
}

/* ================= SIDEBAR ================= */
.sidebar{
  width:240px;
  background:linear-gradient(180deg,#0e142f,#0a1025);
  padding:20px;
  height:100vh;
  position:fixed;
  top:0;
  left:0;
  z-index:1000;
  transition:.4s;
  border-right:1px solid var(--border);
}

.menu{
  list-style:none;
  padding-top:50px;
}

.sidebar li{
  margin-bottom:10px;
  border-radius:14px;
  transition:.3s;
}

.sidebar li a{
  display:flex;
  align-items:center;
  gap:14px;
  padding:14px 18px;
  color:var(--text-muted);
  text-decoration:none;
  font-size:15px;
  border-radius:14px;
}

.sidebar li i{
  font-size:18px;
  min-width:22px;
}

.sidebar li.active a,
.sidebar li:hover a{
  background:rgba(106,169,255,.12);
  color:#fff;
  box-shadow:0 0 18px rgba(106,169,255,.35);
}

.close-btn{
  display:none;
  position:absolute;
  top:18px;
  right:18px;
  font-size:22px;
  cursor:pointer;
  color:#fff;
}

/* ================= OVERLAY ================= */
.overlay{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.65);
  z-index:900;
}

/* ================= MAIN ================= */
.main{
  margin-left:240px;
  padding:40px 30px;
  width:calc(100% - 240px);
  min-height:100vh;
  transition:.4s;
}

/* ================= HEADER ================= */
.page-header{
  text-align:center;
  margin-bottom:45px;
}

.page-header h1{
  font-size:2.6rem;
  font-weight:700;
  background:var(--gradient);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  letter-spacing:1px;
}

/* ================= COURSE GRID ================= */
.course-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:30px;
  max-width:1200px;
  margin:0 auto;
}

/* ================= COURSE CARD ================= */
.course-card-full{
  background:linear-gradient(180deg,rgba(18,24,51,.96),rgba(12,18,40,.98));
  border-radius:22px;
  overflow:hidden;
  box-shadow:var(--shadow);
  transition:.4s;
  display:flex;
  flex-direction:column;
  border:1px solid var(--border);
}

.course-card-full:hover{
  transform:translateY(-10px);
  box-shadow:0 25px 50px rgba(106,169,255,.35);
}

/* IMAGE */
.course-img{
  height:190px;
  overflow:hidden;
}

.course-img img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:.4s;
}

.course-card-full:hover img{
  transform:scale(1.08);
}

/* CONTENT */
.course-content{
  padding:26px;
  display:flex;
  flex-direction:column;
  flex-grow:1;
}

.course-content h3{
  font-size:1.5rem;
  margin-bottom:14px;
  font-weight:600;
}

.course-content p{
  font-size:.95rem;
  color:var(--text-muted);
  line-height:1.6;
  margin-bottom:22px;
  flex-grow:1;
}

/* BUTTON */
.course-btn{
  width:100%;
  padding:14px;
  border:none;
  border-radius:30px;
  background:var(--gradient);
  color:#fff;
  font-weight:600;
  font-size:.9rem;
  cursor:pointer;
  letter-spacing:.6px;
  transition:.3s;
}

.course-btn:hover{
  transform:translateY(-3px);
  box-shadow:0 12px 30px rgba(106,169,255,.45);
}

/* ================= MOBILE MENU BTN ================= */
.menu-btn{
  display:none;
  font-size:24px;
  background:none;
  border:none;
  color:#fff;
  cursor:pointer;
  position:fixed;
  top:20px;
  left:20px;
  z-index:1100;
}

/* ================= RESPONSIVE ================= */
@media(max-width:1024px){
  .sidebar{width:200px}
  .main{margin-left:200px;width:calc(100% - 200px)}
}

@media(max-width:768px){
  .menu-btn{display:block}
  .sidebar{left:-100%;width:280px}
  .sidebar.active{left:0}
  .close-btn{display:block}
  .overlay.active{display:block}
  .main{margin-left:0;width:100%;padding:30px 20px}
  .page-header h1{font-size:2.1rem}
}

@media(max-width:480px){
  .course-content{padding:22px}
  .course-content h3{font-size:1.3rem}
  .course-img{height:170px}
}


/* RESPONSIVE DESIGN */
@media (max-width: 1200px) {
    .course-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        max-width: 900px;
    }
}

@media (max-width: 1024px) {
    .course-grid {
        grid-template-columns: repeat(2, 1fr);
        max-width: 700px;
    }
    
    .main {
        padding: 20px;
    }
    
    .sidebar {
        width: 200px;
    }
    
    .main {
        margin-left: 200px;
        width: calc(100% - 200px);
    }
}

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
    
    .main {
        margin-left: 0;
        width: 100%;
        padding: 15px;
    }
    
    .course-grid {
        grid-template-columns: 1fr;
        max-width: 500px;
        gap: 20px;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .close-btn {
        display: block;
    }
    
    .overlay.active {
        display: block;
    }
}

@media (max-width: 480px) {
    .course-content {
        padding: 20px;
    }
    
    .course-content h3 {
        font-size: 1.3rem;
    }
    
    .course-img {
        height: 180px;
    }
    
    .course-btn {
        padding: 10px 20px;
        font-size: 0.85rem;
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
       
        <li class="active"><a href="ourcourse.php" style="color: inherit; text-decoration: none;">
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
      <h1>Available Courses</h1>
    </section>

    <!-- COURSES GRID - 3 per row -->
    <section class="course-grid">
      
      <!-- Course 1: Secure X -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Secure X Course">
        </div>
        <div class="course-content">
          <h3>Secure X</h3>
          <p>Master advanced cybersecurity techniques, digital defense strategies, and learn to protect systems from sophisticated cyber threats and vulnerabilities.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=securex'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 2: AI Verse Web Labs -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="AI Verse Web Labs">
        </div>
        <div class="course-content">
          <h3>AI Verse Web Labs</h3>
          <p>Build intelligent web applications using AI-driven development, machine learning integration, and automated web engineering workflows.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=aiverse'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 3: Hunt Elite -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Hunt Elite Course">
        </div>
        <div class="course-content">
          <h3>Hunt Elite</h3>
          <p>Professional bug bounty hunting and exploit analysis. Learn advanced penetration testing, vulnerability assessment, and ethical hacking techniques.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=huntelite'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 4: Creative Craft -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Creative Craft">
        </div>
        <div class="course-content">
          <h3>Creative Craft</h3>
          <p>Master strategic visual communication design, branding, UI/UX principles, and create compelling digital experiences that drive engagement.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=creativecraft'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 5: Py Desk Systems -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Py Desk Systems">
        </div>
        <div class="course-content">
          <h3>Py Desk Systems</h3>
          <p>Develop enterprise-grade desktop applications with Python. Master GUI frameworks, database integration, and system-level programming.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=pydesk'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 6: Biz Dev -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Biz Dev">
        </div>
        <div class="course-content">
          <h3>Biz Dev</h3>
          <p>Combine business strategy with software development. Learn to build scalable tech solutions while understanding market needs and business models.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=bizdev'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 7: Code Foundry -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Code Foundry">
        </div>
        <div class="course-content">
          <h3>Code Foundry</h3>
          <p>Professional programming language mastery. Deep dive into multiple languages, best practices, and advanced software engineering concepts.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=codefoundry'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 8: Startup Gene Labs -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="Startup Gene Labs">
        </div>
        <div class="course-content">
          <h3>Startup Gene Labs</h3>
          <p>Venture creation and startup scaling. Learn to build, fund, and grow tech startups from idea to successful enterprise with proven methodologies.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=startupgene'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 9: CLI++ Systems -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="CLI++ Systems">
        </div>
        <div class="course-content">
          <h3>CLI++ Systems</h3>
          <p>C++ command-line tool engineering for Linux. Build powerful, efficient system tools and utilities using advanced C++ programming techniques.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=clipp'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 10: APMan -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="APMan">
        </div>
        <div class="course-content">
          <h3>APMan</h3>
          <p>Master API development, design, and management. Build RESTful and GraphQL APIs, implement security, and create scalable API architectures.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=apman'">
            Course Details
          </button>
        </div>
      </div>

      <!-- Course 11: WebCraft Full Stack -->
      <div class="course-card-full">
        <div class="course-img">
          <img src="./pydesk.jpeg" alt="WebCraft Full Stack">
        </div>
        <div class="course-content">
          <h3>WebCraft Full Stack</h3>
          <p>From idea to launch — learn to build and deploy complete startup-grade web applications using modern full-stack development technologies.</p>
          <button class="course-btn" onclick="location.href='course-details.php?course=webcraft'">
            Course Details
          </button>
        </div>
      </div>

    </section>

  </main>
</div>

<script>
// Mobile menu functionality
const menuBtn = document.getElementById('menuBtn');
const closeBtn = document.getElementById("closeBtn");
const sidebar = document.querySelector(".sidebar");
const overlay = document.getElementById("overlay");

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
});

closeBtn.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
});

overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
});

// Close sidebar when clicking on a menu item (mobile)
const menuItems = document.querySelectorAll('.menu a');
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }
    });
});

// Close sidebar on window resize (if resized to desktop)
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }
});
</script>

</body>
</html>