<?php
session_start();
if(!isset($_SESSION['current-student'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProWorldz Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ================= RESET ================= */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

/* ================= ROOT THEME ================= */
:root{
  --bg-main:#0b0f1a;
  --bg-sidebar:#0f1429;
  --bg-card:#171d36;

  --primary:#6aa9ff;
  --accent:#5eead4;

  --text-main:#ffffff;
  --text-muted:#9aa4bf;

  --border:rgba(255,255,255,0.08);
  --shadow:0 15px 40px rgba(0,0,0,0.5);

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

/* ================= DASHBOARD LAYOUT ================= */
.dashboard{
  display:flex;
  min-height:100vh;
}

/* ================= SIDEBAR ================= */
.sidebar{
  width:240px;
  background:linear-gradient(180deg,#0f1429,#0b1020);
  border-right:1px solid var(--border);
  padding:25px 20px;
  position:fixed;
  height:100vh;
  z-index:1000;
  transition:0.4s ease;
}

.logo{
  width:52px;
  height:52px;
  border-radius:50%;
  background:var(--gradient);
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:700;
  margin-bottom:40px;
  box-shadow:0 10px 30px rgba(106,169,255,0.4);
}

.menu{
  list-style:none;
}

.menu li{
  margin-bottom:10px;
}

.menu li a{
  display:flex;
  align-items:center;
  gap:15px;
  padding:14px 16px;
  border-radius:12px;
  color:var(--text-muted);
  text-decoration:none;
  transition:0.3s ease;
}

.menu li a i{
  font-size:18px;
}

.menu li a:hover,
.menu li.active a{
  background:rgba(106,169,255,0.15);
  color:var(--text-main);
  box-shadow:inset 0 0 0 1px rgba(106,169,255,0.35);
}

.menu li a:hover i,
.menu li.active i{
  color:var(--primary);
}

/* ================= MAIN ================= */
.main{
  margin-left:240px;
  padding:30px;
  width:100%;
  min-height:100vh;
}

/* ================= TOPBAR ================= */
.topbar{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:20px;
  margin-bottom:30px;
}

.menu-btn{
  display:none;
  background:none;
  border:none;
  color:#fff;
  font-size:22px;
}

.search{
  background:rgba(255,255,255,0.05);
  border:1px solid var(--border);
  border-radius:30px;
  padding:12px 20px;
  display:flex;
  align-items:center;
  gap:10px;
  width:260px;
}

.search input{
  background:none;
  border:none;
  outline:none;
  color:#fff;
  width:100%;
}

.search:focus-within{
  border-color:var(--primary);
  box-shadow:0 0 15px rgba(106,169,255,0.3);
}

.profile{
  display:flex;
  align-items:center;
  gap:15px;
}

.avatar{
  width:42px;
  height:42px;
  border-radius:50%;
  background:var(--gradient);
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:600;
}

/* ================= BUTTONS ================= */
.logout-btn,
.enroll-btn,
.explore-btn{
  background:var(--gradient);
  color:#fff;
  padding:10px 22px;
  border-radius:30px;
  border:none;
  font-weight:600;
  cursor:pointer;
  transition:0.3s;
  text-decoration:none;
}

.logout-btn:hover,
.enroll-btn:hover,
.explore-btn:hover{
  transform:translateY(-2px);
  box-shadow:0 15px 35px rgba(106,169,255,0.45);
}

/* ================= WELCOME CARD ================= */
.welcome{
  background:var(--gradient);
  padding:40px;
  border-radius:24px;
  margin-bottom:40px;
  box-shadow:0 20px 50px rgba(106,169,255,0.35);
}

.welcome h2{
  font-size:2.2rem;
  margin:15px 0;
}

.welcome p,
.welcome span{
  opacity:0.9;
}

/* ================= SECTION TITLE ================= */
.section-title{
  font-size:1.4rem;
  color:var(--primary);
  margin-bottom:20px;
  border-bottom:1px solid var(--border);
  padding-bottom:10px;
}

/* ================= COURSE CARD ================= */
.course-card{
  background:linear-gradient(180deg,rgba(23,29,54,0.95),rgba(15,20,40,0.95));
  border:1px solid var(--border);
  padding:28px;
  border-radius:20px;
  width:420px;
  transition:0.4s ease;
}

.course-card:hover{
  transform:translateY(-8px);
  border-color:var(--primary);
  box-shadow:var(--shadow);
}

.course-card h3{
  font-size:1.4rem;
  margin-bottom:10px;
}

.course-card p{
  color:var(--text-muted);
  font-size:0.95rem;
  line-height:1.6;
}

/* ================= BADGES ================= */
.badge{
  padding:6px 18px;
  border-radius:30px;
  font-size:12px;
  font-weight:600;
  color:#fff;
}

.badge.completed{
  background:linear-gradient(135deg,#22c55e,#16a34a);
}

.badge.in-progress{
  background:linear-gradient(135deg,#6aa9ff,#4f8cff);
}

.badge.not-started{
  background:linear-gradient(135deg,#64748b,#475569);
}

/* ================= GRID ================= */
.courses-grid{
  display:flex;
  gap:25px;
  flex-wrap:wrap;
}

/* ================= EMPTY STATE ================= */
.no-courses-container{
  width:100%;
  background:var(--bg-card);
  border:2px dashed var(--border);
  border-radius:20px;
  padding:50px;
  text-align:center;
}

.no-courses-icon{
  font-size:60px;
  color:var(--primary);
  margin-bottom:15px;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
  .menu-btn{display:block}

  .sidebar{
    left:-100%;
    width:280px;
  }

  .sidebar.active{
    left:0;
  }

  .main{
    margin-left:0;
    padding:25px 20px;
  }

  .search{
    width:100%;
  }

  .course-card{
    width:100%;
  }
}

        @media(max-width:1024px){
            .sidebar{
                width:200px;
            }

            .main{
                margin-left:200px;
                width: calc(100% - 200px);
            }

            .search{
                width:220px;
            }
            
            .course-card {
                width: 450px;
            }
        }

        @media(max-width:768px){
            .menu-btn{
                display:block;
            }

            .close-btn{
                display:block;
            }

            .sidebar{
                left:-100%;
                width:280px;
            }

            .sidebar.active{
                left:0;
            }

            .main{
                margin-left:0;
                width: 100%;
                padding:25px 20px;
            }

            .topbar{
                flex-wrap:wrap;
                gap:15px;
            }

            .search{
                width:100%;
                order:3;
            }

            .profile{
                margin-left:auto;
            }

            .cards,
            .courses{
                grid-template-columns:1fr;
            }

            .logout-btn{
                padding:8px 16px;
                font-size:13px;
            }

            .overlay.active{
                display:block;
            }

            .course-card {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }
            
            .welcome{
                padding:30px 25px;
            }
            
            .welcome h2{
                font-size:1.8rem;
            }
            
            .courses-grid {
                justify-content: center;
            }
        }

        @media(max-width:480px){
            .main{
                padding:20px 15px;
            }
            
            .welcome{
                padding:25px 20px;
            }
            
            .welcome h2{
                font-size:1.5rem;
            }
            
            .course-card {
                padding:25px 20px;
            }
            
            .no-courses-container {
                padding:40px 20px;
            }
            
            .no-courses-icon {
                font-size:48px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="close-btn" id="closeBtn">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="logo">P</div>
            <ul class="menu">
                <li class="active">
                    <a href="dashboard.php" style="color: inherit; text-decoration: none;">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="assignment.php" style="color: inherit; text-decoration: none;">
                        <i class="fa-solid fa-book"></i>
                        <span>Assignment</span>
                    </a>
                </li>
                <li>
                    <a href="ourcourse.php" style="color: inherit; text-decoration: none;">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Courses</span>
                    </a>
                </li>
            </ul>
        </aside>

        <div class="overlay" id="overlay"></div>

        <main class="main">
            <div class="topbar">
                <button class="menu-btn" id="menuBtn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search courses, assignments...">
                </div>
                <div class="profile">
                    <div class="avatar">
                        <?= substr($_SESSION['current-student'], 0, 1); ?>
                    </div>
                    <a href="logout.php" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>
                </div>
            </div>
            
            <section class="welcome">
                <p><?=date("D, M j, Y");?></p>
                <h2 id="showname">Welcome back, <?=$_SESSION['current-student'];?></h2>
                <span>Always stay updated in your student portal</span>
            </section>
            
            <h3 class="section-title">Enrolled Courses</h3>
            <div class="courses-grid" id="uploader">
                <!-- Courses will be dynamically loaded here -->
            </div>
            
        </main>
    </div>
    
    <script>
        const menuBtn = document.getElementById("menuBtn");
        const closeBtn = document.getElementById("closeBtn");
        const sidebar = document.querySelector(".sidebar");
        const overlay = document.getElementById("overlay");

        menuBtn.addEventListener("click", () => {
            sidebar.classList.add("active");
            overlay.classList.add("active");
        });

        closeBtn.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });

        const menuLinks = document.querySelectorAll('.menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });

        fetch('http://localhost:3000/api/get_courses.php',{
            method:'GET',
            credentials:'include'
        })
        .then(res => res.json())
        .then(data => {
            const uploader = document.getElementById('uploader');
            
            if (data.error) {
                window.location.href = 'login.php';
                return;
            }
            
            if (data.result === 'No Course found') {
                uploader.innerHTML = `
                    <div class="no-courses-container">
                        <div class="no-courses-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>No Courses Enrolled</h3>
                        <p>You haven't enrolled in any courses yet. Explore our course catalog to start your learning journey with PROWORLDZ.</p>
                        <a href="ourcourse.php" class="explore-btn">
                            <i class="fas fa-search"></i> Explore Courses
                        </a>
                    </div>
                `;
            } else if (data.result) {
                const info = data.result;
                const courseCard = document.createElement('div');
                courseCard.className = 'course-card';
                
                const courseTop = document.createElement('div');
                courseTop.className = 'course-top';
                
                const badge = document.createElement('span');
                
                if(info.assignment_completion == 1) {
                    badge.className = 'badge completed';
                    badge.textContent = 'Completed';
                } else if(info.is_complete == 1) {
                    badge.className = 'badge in-progress';
                    badge.textContent = 'In Progress';
                } else {
                    badge.className = 'badge not-started';
                    badge.textContent = 'Not Started';
                }
                
                const courseTitle = document.createElement('h3');
                courseTitle.textContent = info.course_name || 'Untitled Course';
                
                const courseDescription = document.createElement('p');
                courseDescription.textContent = info.description || 'No description available';
                
                const button = document.createElement('button');
                
                if(info.assignment_completion == 1){
                    button.className = 'btn completed-btn';
                    button.innerHTML = '<i class="fas fa-certificate"></i> View Certificate';
                    button.onclick = () => {
                        // Add certificate viewing logic here
                        alert('Certificate viewing feature coming soon!');
                    };
                } else {
                    button.className = 'btn disabled-btn';
                    button.textContent = 'Submit Assignment';
                    button.disabled = true;
                    if(info.total_assigns > 0) {
                        button.className = 'btn enroll-btn';
                        button.textContent = `Submit (${info.total_assigns} pending)`;
                        button.disabled = false;
                        button.onclick = () => {
                            window.location.href = 'assignment.php';
                        };
                    }
                }

                courseTop.appendChild(badge);
                courseCard.appendChild(courseTop);
                courseCard.appendChild(courseTitle);
                courseCard.appendChild(courseDescription);
                courseCard.appendChild(button);
                uploader.appendChild(courseCard);
                
                // Add progress stats if available
                if(info.total_assigns > 0) {
                    const progressDiv = document.createElement('div');
                    progressDiv.style.marginTop = '10px';
                    progressDiv.style.fontSize = '14px';
                    progressDiv.style.color = '#888';
                    
                    const completed = info.assignment_completion || 0;
                    const progress = Math.round((completed / info.total_assigns) * 100);
                    
                    progressDiv.innerHTML = `
                        <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                            <span>Progress</span>
                            <span>${progress}%</span>
                        </div>
                        <div style="background:#333; height:6px; border-radius:3px; overflow:hidden;">
                            <div style="background:#ff5722; height:100%; width:${progress}%; transition:width 0.5s ease;"></div>
                        </div>
                    `;
                    courseCard.appendChild(progressDiv);
                }
                
            } else {
                uploader.innerHTML = `
                    <div class="no-courses-container">
                        <div class="no-courses-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <h3>Unable to Load Courses</h3>
                        <p>There was an issue loading your courses. Please try again later or contact support.</p>
                        <button class="explore-btn" onclick="location.reload()">
                            <i class="fas fa-redo"></i> Retry
                        </button>
                    </div>
                `;
            }
        })
        .catch(err => {
            // console.error('Error loading courses:', err);
            document.getElementById('uploader').innerHTML = `
                <div class="no-courses-container">
                    <div class="no-courses-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>No course found</h3>
                </div>
            `;
        });
    </script>
</body>
</html>