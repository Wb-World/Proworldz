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
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            background:#0e0e0e;
            color:#fff;
            min-height:100vh;
        }

        .dashboard{
            display:flex;
            min-height:100vh;
        }

        .menu{
            padding-top:50px;
        }

        .sidebar{
            width:240px;
            background:#121212;
            padding:20px;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            transition:0.4s ease;
            z-index:1000;
        }

        .logo{
            width:52px;
            height:52px;
            border-radius:50%;
            background:linear-gradient(135deg, #ff5722, #ff005d);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:20px;
            font-weight:700;
            margin-bottom:40px;
            box-shadow:0 5px 15px rgba(255,87,34,0.3);
        }

        .sidebar ul{
            list-style:none;
        }

        .sidebar li{
            display:flex;
            align-items:center;
            gap:15px;
            padding:14px 16px;
            margin-bottom:10px;
            border-radius:12px;
            cursor:pointer;
            transition:.3s ease;
        }

        .sidebar li span{
            font-size:15px;
            font-weight:500;
        }

        .sidebar li i{
            font-size:18px;
            min-width:22px;
            color:#888;
        }

        .sidebar li:hover,
        .sidebar li.active{
            background:#1a1a1a;
            box-shadow:0 0 12px rgba(255,87,34,.4);
            transform:translateX(5px);
        }

        .sidebar li:hover i,
        .sidebar li.active i{
            color:#ff5722;
        }

        .main{
            margin-left:240px;
            padding:30px;
            width:100%;
            transition:margin-left 0.4s ease;
            min-height:100vh;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .search{
            background:#1a1a1a;
            padding:12px 20px;
            border-radius:30px;
            display:flex;
            align-items:center;
            gap:10px;
            width:260px;
            border:1px solid #333;
            transition:all 0.3s ease;
        }

        .search:focus-within{
            border-color:#ff5722;
            box-shadow:0 0 15px rgba(255,87,34,0.2);
        }

        .search input{
            background:none;
            border:none;
            outline:none;
            color:#fff;
            width:100%;
            font-size:14px;
        }

        .search i{
            color:#888;
        }

        .profile{
            display:flex;
            align-items:center;
            gap:12px;
            position:relative;
        }

        .profile span{
            font-size:13px;
            opacity:.7;
        }

        .avatar{
            width:42px;
            height:42px;
            border-radius:50%;
            background:linear-gradient(135deg, #ff5722, #ff005d);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:600;
            font-size:16px;
        }

        .welcome{
            background:linear-gradient(135deg,#ff005d,#ff5722);
            padding:40px 35px;
            border-radius:24px;
            margin-bottom:40px;
            transition:.4s ease;
            min-height:200px;
            position:relative;
            overflow:hidden;
            box-shadow:0 15px 35px rgba(255,87,34,0.2);
        }

        .welcome::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background:linear-gradient(45deg,transparent 30%,rgba(255,255,255,0.1) 50%,transparent 70%);
            animation:shine 3s infinite;
        }

        @keyframes shine{
            0%{transform:translateX(-100%);}
            100%{transform:translateX(100%);}
        }

        .welcome h2{
            margin:15px 0;
            font-size:2.2rem;
            font-weight:700;
            letter-spacing:0.5px;
        }

        .welcome p{
            color:rgba(255,255,255,0.9);
            font-size:14px;
            margin-bottom:8px;
        }

        .welcome span{
            color:rgba(255,255,255,0.8);
            font-size:15px;
            display:block;
            margin-top:10px;
        }

        .welcome:hover{
            transform:translateY(-5px);
            box-shadow:0 20px 40px rgba(255,87,34,0.3);
        }

        .section-title{
            margin:25px 0 20px;
            color:#ff5722;
            font-size:1.5rem;
            font-weight:600;
            padding-bottom:10px;
            border-bottom:2px solid #333;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:30px;
        }

        .card{
            background:#1a1a1a;
            padding:28px;
            border-radius:18px;
            text-align:center;
            transition:.4s ease;
            border:1px solid #333;
        }

        .card h1{
            margin-bottom:5px;
            font-size:2.5rem;
            font-weight:700;
            background:linear-gradient(135deg, #ff5722, #ff005d);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .card:hover{
            transform:translateY(-8px);
            box-shadow:0 15px 30px rgba(255,87,34,.3);
            border-color:#ff5722;
        }

        .card.highlight{
            border:2px solid #ff5722;
            background:linear-gradient(135deg, rgba(255,87,34,0.1), rgba(255,0,93,0.1));
        }

        .courses{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
            gap:20px;
        }

        .course{
            background:#1a1a1a;
            padding:20px;
            border-radius:15px;
            transition:.35s ease;
            border:1px solid #333;
        }

        .course:hover{
            background:linear-gradient(135deg, rgba(255,87,34,0.1), rgba(255,0,93,0.1));
            transform:translateY(-6px);
            border-color:#ff5722;
        }

        .logout-btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 20px;
            border-radius:30px;
            background:linear-gradient(135deg, #ff5722, #ff005d);
            color:#fff;
            text-decoration:none;
            font-size:14px;
            font-weight:500;
            transition:.3s;
            white-space:nowrap;
            border:none;
            cursor:pointer;
        }

        .logout-btn:hover{
            background:linear-gradient(135deg, #ff005d, #ff5722);
            box-shadow:0 10px 20px rgba(255,60,0,.4);
            transform:translateY(-2px);
        }

        .menu-btn{
            display:none;
            font-size:24px;
            cursor:pointer;
            color:#fff;
            background:none;
            border:none;
            padding:5px;
        }

        .close-btn{
            display:none;
            position:absolute;
            top:18px;
            right:18px;
            font-size:22px;
            cursor:pointer;
            color:#fff;
            z-index:1100;
            background:none;
            border:none;
        }

        .overlay{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.6);
            z-index:900;
        }

        /* Course Card Styles */
        .course-card {
            background: #1a1a1a;
            padding: 30px;
            border-radius: 20px;
            width: 500px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            border: 1px solid #333;
            transition: all 0.4s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .course-card:hover {
            transform: translateY(-10px);
            border-color: #ff5722;
            box-shadow: 0 15px 30px rgba(255,87,34,0.3);
        }

        .course-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .badge {
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #be7f0aff;
            color: white;
        }

        .badge.completed {
            background: linear-gradient(135deg, #4CAF50, #45a049);
        }

        .badge.in-progress {
            background: linear-gradient(135deg, #2196F3, #1976D2);
        }

        .badge.not-started {
            background: linear-gradient(135deg, #9e9e9e, #757575);
        }

        .course-card h3 {
            font-size: 1.4rem;
            margin-bottom: 12px;
            color: #fff;
            font-weight: 600;
        }

        .course-card p {
            color: #aaa;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 30px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
            width: 100%;
        }

        .completed-btn {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .completed-btn:hover {
            background: linear-gradient(135deg, #45a049, #4CAF50);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .disabled-btn {
            background: #333;
            color: #888;
            cursor: not-allowed;
        }

        .enroll-btn {
            background: linear-gradient(135deg, #ff5722, #ff005d);
            color: white;
        }

        .enroll-btn:hover {
            background: linear-gradient(135deg, #ff005d, #ff5722);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.4);
        }

        /* No Courses Found State */
        .no-courses-container {
            text-align: center;
            padding: 60px 40px;
            background: #1a1a1a;
            border-radius: 20px;
            border: 2px dashed #333;
            width: 100%;
            margin: 0 auto;
        }

        .no-courses-icon {
            font-size: 64px;
            color: #ff5722;
            margin-bottom: 20px;
        }

        .no-courses-container h3 {
            color: #fff;
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .no-courses-container p {
            color: #aaa;
            font-size: 1rem;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .explore-btn {
            display: inline-block;
            padding: 14px 35px;
            background: linear-gradient(135deg, #ff5722, #ff005d);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .explore-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 87, 34, 0.4);
        }

        /* Courses Grid Layout */
        .courses-grid {
            display: flex;
            gap: 25px;
            justify-content: flex-start;
            flex-wrap: wrap;
            margin-top: 20px;
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