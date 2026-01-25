<?php
session_start();
// if(!isset($_SESSION['current-student'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programming Tasks | ProWorldz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6C63FF;
            --secondary: #36D1DC;
            --dark: #0F0F23;
            --card-bg: #16162D;
            --accent: #FF6B9D;
            --success: #4ECDC4;
            --warning: #FFD166;
            --text: #FFFFFF;
            --text-secondary: #A0A0C0;
            --border: #2A2A4A;
            --glow-primary: rgba(108, 99, 255, 0.4);
            --glow-secondary: rgba(54, 209, 220, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            background-color: var(--dark);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(108, 99, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(54, 209, 220, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: rgba(22, 22, 45, 0.95);
            padding: 25px 20px;
            border-right: 1px solid var(--border);
            backdrop-filter: blur(10px);
            position: fixed;
            height: 100vh;
            z-index: 100;
            transition: width 0.3s ease;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            padding-left: 10px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 0 15px var(--glow-primary);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 10px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-item.active {
            background-color: rgba(108, 99, 255, 0.2);
            border-left: 3px solid var(--primary);
        }

        .nav-item:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
        }

        .nav-icon {
            margin-right: 15px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .nav-text {
            transition: opacity 0.3s ease;
        }

        .profile-section {
            position: absolute;
            bottom: 30px;
            left: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: rgba(40, 40, 70, 0.5);
            border-radius: 15px;
            border: 1px solid var(--border);
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .profile-info h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .profile-info p {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .page-title h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-title p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-avatar-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-btn {
            background-color: rgba(40, 40, 70, 0.5);
            border-radius: 12px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-btn:hover {
            background-color: rgba(108, 99, 255, 0.2);
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--accent);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            animation: pulse 2s infinite;
        }

        .header-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            border: 2px solid var(--primary);
            box-shadow: 0 0 10px var(--glow-primary);
        }

        .header-avatar-info {
            text-align: right;
        }

        .header-avatar-info h4 {
            font-size: 1rem;
            margin-bottom: 3px;
        }

        .header-avatar-info p {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 20px 20px 0 0;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .stat-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info h3 {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            background: rgba(108, 99, 255, 0.1);
            color: var(--primary);
        }

        .tasks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .task-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 20px 20px 0 0;
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .task-title h3 {
            font-size: 1.3rem;
            margin-bottom: 8px;
            color: var(--text);
        }

        .task-difficulty {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .difficulty-easy {
            background: rgba(78, 205, 196, 0.2);
            color: var(--success);
        }

        .difficulty-medium {
            background: rgba(255, 209, 102, 0.2);
            color: var(--warning);
        }

        .difficulty-hard {
            background: rgba(255, 107, 157, 0.2);
            color: var(--accent);
        }

        .task-points {
            background: linear-gradient(45deg, var(--primary), var(--accent));
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .task-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .task-details {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .task-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .task-detail i {
            color: var(--primary);
        }

        .task-actions {
            display: flex;
            gap: 12px;
        }

        .task-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .solve-btn {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
        }

        .solve-btn:hover {
            background: linear-gradient(45deg, var(--secondary), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 10px 20px var(--glow-primary);
        }

        .preview-btn {
            background: rgba(40, 40, 70, 0.5);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .preview-btn:hover {
            background: rgba(108, 99, 255, 0.1);
            border-color: var(--primary);
        }

        .completed-badge {
            background: rgba(78, 205, 196, 0.2);
            color: var(--success);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 40px 0 20px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: var(--text-secondary);
            font-size: 0.9rem;
            border-top: 1px solid var(--border);
            margin-top: 30px;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }
            
            .main-content {
                margin-left: 220px;
                padding: 20px;
            }
            
            .tasks-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .header-avatar-info {
                display: none;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .header-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 768px) {
            body::before {
                content: 'This dashboard is optimized for desktop devices only.';
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                text-align: center;
                padding: 20px;
                background: var(--dark);
                z-index: 1000;
            }
            
            .container {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .tasks-grid {
                grid-template-columns: 1fr;
            }
            
            .task-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .task-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">EduDash</div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="ourcourse.php" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <span class="nav-text">Courses</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="tasks.php" class="nav-link">
                        <i class="fas fa-tasks nav-icon"></i>
                        <span class="nav-text">Tasks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="leaderboard.php" class="nav-link">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">Leader board</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="lab.php" class="nav-link">
                        <i class="fas fa-flask nav-icon"></i>
                        <span class="nav-text">Laboratory</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="setting.php" class="nav-link">
                        <i class="fas fa-cog nav-icon"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            </ul>
            
            <div class="profile-section">
                <div class="profile-img">
                    JS
                </div>
                <div class="profile-info">
                    <h4>John Smith</h4>
                    <p>Eagle Points: 1,250</p>
                </div>
            </div>
        </div>
        
        <div class="main-content" id="mainContent">
            <div class="header">
                <div class="page-title">
                    <h1>Programming Tasks</h1>
                    <p>Complete challenges to earn Eagle Points and improve your skills</p>
                </div>
                
                <div class="header-actions">
                    <div class="profile-avatar-container">
                        <div class="header-avatar">
                            JS
                        </div>
                        <div class="header-avatar-info">
                            <h4>John Smith</h4>
                            <p>Eagle Points: 1,250</p>
                        </div>
                        <div class="notification-btn" id="notificationBtn">
                            <i class="fas fa-bell"></i>
                            <div class="notification-badge">3</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="stats-grid fade-in">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <h3>Total Eagle Points</h3>
                            <div class="stat-value">1,250</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-info">
                            <h3>Tasks Completed</h3>
                            <div class="stat-value">8/15</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="section-title"><i class="fas fa-code"></i> Python Challenges</h2>
            <div class="tasks-grid fade-in">
                <!-- Task 1 -->
                <div class="task-card">
                    <div class="task-header">
                        <div class="task-title">
                            <h3>Fibonacci Sequence Generator</h3>
                            <span class="task-difficulty difficulty-easy">Easy</span>
                        </div>
                        <div class="task-points">
                            <i class="fas fa-star"></i> 100 Points
                        </div>
                    </div>
                    
                    <p class="task-description">
                        Write a function that generates the first N numbers of the Fibonacci sequence.
                        The sequence starts with 0 and 1, and each subsequent number is the sum of the previous two.
                    </p>
                    
                    <div class="task-actions">
                        <button class="task-btn solve-btn" onclick="openTask(1)">
                            <i class="fas fa-play"></i> Solve Challenge
                        </button>
                    </div>
                </div>
                
                <!-- Task 2 -->
                <div class="task-card">
                    <div class="task-header">
                        <div class="task-title">
                            <h3>Palindrome Checker</h3>
                            <span class="task-difficulty difficulty-easy">Easy</span>
                        </div>
                        <div class="task-points">
                            <i class="fas fa-star"></i> 75 Points
                        </div>
                    </div>
                    
                    <p class="task-description">
                        Create a function that checks if a given string is a palindrome.
                        A palindrome reads the same forwards and backwards, ignoring case and spaces.
                    </p>
                    
                    <div class="task-actions">
                        <button class="task-btn solve-btn" onclick="openTask(2)">
                            <i class="fas fa-play"></i> Solve Challenge
                        </button>
    
                    </div>
                </div>
                
                <!-- Task 3 -->
                <div class="task-card">
                    <div class="task-header">
                        <div class="task-title">
                            <h3>Prime Number Finder</h3>
                            <span class="task-difficulty difficulty-medium">Medium</span>
                        </div>
                        <div class="task-points">
                            <i class="fas fa-star"></i> 150 Points
                        </div>
                    </div>
                    
                    <p class="task-description">
                        Implement a function that finds all prime numbers up to a given limit N.
                        Use the Sieve of Eratosthenes algorithm for optimal performance.
                    </p>
                    
                    <div class="task-actions">
                        <button class="task-btn solve-btn" onclick="openTask(3)">
                            <i class="fas fa-play"></i> Solve Challenge
                        </button>
                        
                    </div>
                </div>
                
                <!-- Task 4 -->
                <div class="task-card">
                    <div class="task-header">
                        <div class="task-title">
                            <h3>Binary Search Algorithm</h3>
                            <span class="task-difficulty difficulty-medium">Medium</span>
                        </div>
                        <div class="task-points">
                            <i class="fas fa-star"></i> 200 Points
                        </div>
                    </div>
                    
                    <p class="task-description">
                        Implement the binary search algorithm to find an element in a sorted list.
                        Return the index of the element if found, or -1 if not present.
                    </p>
                    
                    <div class="task-actions">
                        <button class="task-btn solve-btn" onclick="openTask(4)">
                            <i class="fas fa-play"></i> Solve Challenge
                        </button>
                        
                    </div>
                </div>
                
                <!-- Task 5 -->
                <div class="task-card">
                    <div class="task-header">
                        <div class="task-title">
                            <h3>Matrix Multiplication</h3>
                            <span class="task-difficulty difficulty-hard">Hard</span>
                        </div>
                        <div class="task-points">
                            <i class="fas fa-star"></i> 300 Points
                        </div>
                    </div>
                    
                    <p class="task-description">
                        Write a function that multiplies two matrices together.
                        Handle edge cases for incompatible dimensions and implement efficient multiplication.
                    </p>
                    
                    
                    <div class="task-actions">
                        <button class="task-btn solve-btn" onclick="openTask(5)">
                            <i class="fas fa-play"></i> Solve Challenge
                        </button>
                        
                    </div>
                </div>
                
                <!-- Task 6 (Completed) -->
                <div class="task-card">
                    <div class="task-header">
                        <div class="task-title">
                            <h3>FizzBuzz</h3>
                            <span class="task-difficulty difficulty-easy">Easy</span>
                        </div>
                        <div class="task-points">
                            <i class="fas fa-star"></i> 50 Points
                        </div>
                    </div>
                    
                    <p class="task-description">
                        Classic FizzBuzz problem: Print numbers from 1 to N, but for multiples of 3 print "Fizz",
                        for multiples of 5 print "Buzz", and for multiples of both print "FizzBuzz".
                    </p>
                    
                    <div class="task-details">
                        <div class="task-detail">
                            <i class="fas fa-code"></i>
                            <span>Python</span>
                        </div>
                        <div class="task-detail">
                            <i class="fas fa-clock"></i>
                            <span>5 min</span>
                        </div>
                        <div class="task-detail">
                            <i class="fas fa-users"></i>
                            <span>98% solved</span>
                        </div>
                    </div>
                    
                    <div class="completed-badge">
                        <i class="fas fa-check-circle"></i> Completed ✓
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <p>© 2026 ProWorldz copyrights reserved. Complete tasks to earn Eagle Points and climb the leaderboard!</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelectorAll('.fade-in').forEach(el => {
                    el.style.opacity = '1';
                });
            }, 300);
            
            const notificationBtn = document.getElementById('notificationBtn');
            
            notificationBtn.addEventListener('click', showNotifications);
            
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (this.querySelector('a').getAttribute('href') !== '#') {
                        return;
                    }
                    e.preventDefault();
                    document.querySelectorAll('.nav-item').forEach(nav => {
                        nav.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });
        });

        function showNotifications() {
            const badge = notificationBtn.querySelector('.notification-badge');
            badge.style.display = 'none';
            alert('New task available: "Graph Traversal Algorithms" - 250 Eagle Points!\nDaily login bonus: 10 Eagle Points added.\nWeekly challenge starting tomorrow!');
        }

        function openTask(taskId) {
            const taskTitles = [
                "Fibonacci Sequence Generator",
                "Palindrome Checker",
                "Prime Number Finder",
                "Binary Search Algorithm",
                "Matrix Multiplication",
                "FizzBuzz",
                "SQL Query Optimizer"
            ];
            
            const taskPoints = [100, 75, 150, 200, 300, 50, 180];
            
            alert(`Opening "${taskTitles[taskId-1]}" challenge!\n\nYou can earn ${taskPoints[taskId-1]} Eagle Points for completing this task.\n\nRedirecting to coding environment...`);
            
            // In a real implementation, this would redirect to the coding interface
            // window.location.href = `task_editor.php?task=${taskId}`;
        }

        function previewTask(taskId) {
            const taskPreviews = [
                "Task Preview: Fibonacci Sequence Generator\n\nWrite a function fibonacci(n) that returns a list containing the first n Fibonacci numbers.\n\nExample:\nfibonacci(5) → [0, 1, 1, 2, 3]\n\nConstraints:\n• 1 ≤ n ≤ 1000\n• Must handle large numbers efficiently",
                
                "Task Preview: Palindrome Checker\n\nWrite a function is_palindrome(s) that returns True if the string s is a palindrome, False otherwise.\n\nExample:\nis_palindrome('racecar') → True\nis_palindrome('hello') → False\n\nConstraints:\n• Ignore case and non-alphanumeric characters",
                
                "Task Preview: Prime Number Finder\n\nWrite a function find_primes(limit) that returns a list of all prime numbers up to limit.\n\nExample:\nfind_primes(20) → [2, 3, 5, 7, 11, 13, 17, 19]\n\nConstraints:\n• 2 ≤ limit ≤ 10^6\n• Must use Sieve of Eratosthenes",
                
                "Task Preview: Binary Search Algorithm\n\nWrite a function binary_search(arr, target) that returns the index of target in sorted array arr.\n\nExample:\nbinary_search([1, 3, 5, 7, 9], 5) → 2\nbinary_search([1, 3, 5, 7, 9], 6) → -1\n\nConstraints:\n• arr is sorted in ascending order\n• O(log n) time complexity required",
                
                "Task Preview: Matrix Multiplication\n\nWrite a function matrix_multiply(A, B) that returns the product of matrices A and B.\n\nExample:\nmatrix_multiply([[1,2],[3,4]], [[5,6],[7,8]]) → [[19,22],[43,50]]\n\nConstraints:\n• Handle incompatible dimensions appropriately\n• Optimize for large matrices",
                
                "Task Preview: FizzBuzz\n\nWrite a function fizzbuzz(n) that prints numbers from 1 to n with FizzBuzz rules.\n\nExample output for n=5:\n1\n2\nFizz\n4\nBuzz\n\nConstraints:\n• 1 ≤ n ≤ 100",
                
                "Task Preview: SQL Query Optimizer\n\nGiven a slow SQL query, rewrite it for better performance.\n\nExample query:\nSELECT * FROM orders WHERE customer_id IN (SELECT id FROM customers WHERE country = 'USA');\n\nOptimize using JOINs and proper indexing.\n\nConstraints:\n• Must maintain same result set\n• Improve execution time"
            ];
            
            alert(taskPreviews[taskId-1]);
        }

        // Simulate earning points animation
        setInterval(() => {
            // Randomly update notification badge
            const badge = notificationBtn.querySelector('.notification-badge');
            if (Math.random() > 0.8 && badge.style.display !== 'none') {
                const currentCount = parseInt(badge.textContent);
                if (currentCount < 9) {
                    badge.textContent = currentCount + 1;
                }
            }
        }, 30000); // Check every 30 seconds
    </script>
</body>
</html>