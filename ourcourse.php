<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Courses | ProWorldz</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #0e0e0e;
    color: #fff;
    min-height: 100vh;
}

.dashboard {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR STYLES */
.sidebar {
    width: 240px;
    background: #121212;
    padding: 20px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    transition: 0.4s ease;
    z-index: 1000;
    overflow-y: auto;
}

.menu {
    padding-top: 50px;
    list-style: none;
}

.sidebar li {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 14px 16px;
    margin-bottom: 10px;
    border-radius: 12px;
    cursor: pointer;
    transition: .3s ease;
}

.sidebar li a {
    color: inherit;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 15px;
    width: 100%;
}

.sidebar li span {
    font-size: 15px;
}

.sidebar li i {
    font-size: 18px;
    min-width: 22px;
}

.sidebar li:hover,
.sidebar li.active {
    background: #1f1f1f;
    box-shadow: 0 0 12px rgba(255, 87, 34, .4);
}

.close-btn {
    display: none;
    position: absolute;
    top: 18px;
    right: 18px;
    font-size: 22px;
    cursor: pointer;
    color: #fff;
    z-index: 1100;
}

.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .6);
    z-index: 900;
}

/* MAIN CONTENT */
.main {
    margin-left: 240px;
    padding: 30px;
    width: calc(100% - 240px);
    transition: margin-left 0.4s ease, width 0.4s ease;
    min-height: 100vh;
}

/* PAGE HEADER */
.page-header {
    margin-bottom: 40px;
    text-align: center;
}

.page-header h1 {
    font-size: 2.5rem;
    color: #ff5722;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* COURSES GRID */
.course-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

/* COURSE CARD */
.course-card-full {
    background: #1a1a1a;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.course-card-full:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(255, 87, 34, 0.3);
}

.course-img {
    height: 200px;
    overflow: hidden;
}

.course-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.course-card-full:hover .course-img img {
    transform: scale(1.05);
}

.course-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.course-content h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #fff;
}

.course-content p {
    color: #aaa;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
}

.course-btn {
    background: linear-gradient(135deg, #ff5722, #ff005d);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9rem;
    width: 100%;
}

.course-btn:hover {
    background: linear-gradient(135deg, #ff005d, #ff5722);
    box-shadow: 0 5px 15px rgba(255, 87, 34, 0.4);
    transform: translateY(-2px);
}

/* Mobile menu button (hidden by default, shown on mobile) */
.menu-btn {
    display: none;
    font-size: 24px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1001;
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