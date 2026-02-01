<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Courses | ProWorldz</title>
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

/* ===== DESKTOP LAYOUT ===== */
.desktop-container {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 1.5rem;
    min-height: 100vh;
    padding: 1.5rem;
    background-color: var(--background);
    min-width: 1280px;
    overflow-x: auto;
}

/* ===== SIDEBAR STYLES ===== */
.desktop-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.card {
    background-color: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
}

.p-4 { padding: 1rem; }
.p-3 { padding: 0.75rem; }

.flex { display: flex; }
.items-center { align-items: center; }
.gap-3 { gap: 0.75rem; }
.size-12 { width: 3rem; height: 3rem; }
.bg-primary { background-color: var(--primary); }
.rounded-lg { border-radius: var(--radius); }
.text-primary-foreground { color: var(--primary-foreground); }
.text-2xl { font-size: 1.5rem; line-height: 2rem; }
.font-display { font-family: 'Rebels', monospace; font-weight: 700; }
.text-xs { font-size: 0.75rem; line-height: 1rem; }
.text-muted-foreground { color: var(--muted-foreground); }
.uppercase { text-transform: uppercase; }
.flex-1 { flex: 1 1 0%; }
.flex-shrink-0 { flex-shrink: 0; }

/* Navigation Styles */
.nav-section {
    margin-bottom: 1.5rem;
}

.space-y-1 > * + * {
    margin-top: 0.25rem;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: calc(var(--radius) - 2px);
    text-decoration: none;
    color: var(--sidebar-foreground);
    transition: all 0.2s;
    margin-bottom: 0.25rem;
    cursor: pointer;
}

.nav-item:hover {
    background-color: var(--sidebar-accent);
}

.nav-item.active {
    background-color: var(--sidebar-primary);
    color: var(--sidebar-primary-foreground);
}

.nav-item.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.nav-item.disabled:hover {
    background-color: transparent;
}

.nav-icon {
    width: 1.25rem;
    height: 1.25rem;
    flex-shrink: 0;
}

.nav-label {
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
}

/* ===== MAIN CONTENT ===== */
.desktop-main {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    overflow-y: auto;
    max-height: calc(100vh - 3rem);
    padding-right: 0.5rem;
}

/* Page Header */
.page-header {
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
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

/* ===== COURSES CONTAINER ===== */
.courses-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2.5rem;
    margin-bottom: 3rem;
}

/* Center the grid on desktop */
@media (min-width: 769px) {
    .courses-container {
        grid-template-columns: repeat(3, 380px);
        justify-content: center;
    }
}

/* ===== COURSE CARD ===== */
.course-card {
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-xl);
}

.course-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at center, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.5s ease;
    pointer-events: none;
}

.course-card:hover {
    border-color: var(--primary);
    transform: translateY(-10px);
    box-shadow: var(--shadow-2xl);
}

.course-card:hover::after {
    opacity: 1;
}

.course-image {
    position: relative;
    height: 220px;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(129, 131, 244, 0.05) 100%);
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.course-card:hover .course-image img {
    transform: scale(1.1);
}

.course-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    background: rgba(10, 10, 10, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(99, 102, 241, 0.3);
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary-light);
    text-transform: uppercase;
}

.course-body {
    padding: 2rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.course-body h3 {
    font-size: 1.6rem;
    margin-bottom: 1rem;
    color: var(--foreground);
    transition: color 0.3s ease;
    font-family: 'Rebels', monospace;
}

.course-card:hover .course-body h3 {
    color: var(--primary-light);
}

.course-body p {
    color: var(--muted-foreground);
    line-height: 1.7;
    margin-bottom: 2rem;
    flex-grow: 1;
    font-size: 0.95rem;
}

.course-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: var(--gradient-primary);
    color: var(--primary-foreground);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    border-radius: 10px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    width: 100%;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border: none;
    cursor: pointer;
    font-family: 'Roboto Mono', monospace;
}

.course-action:hover {
    background: var(--primary);
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
    transform: translateX(5px);
}

.course-action i {
    transition: transform 0.3s ease;
}

.course-action:hover i {
    transform: translateX(5px);
}

/* ===== STATS SECTION ===== */
.stats-section {
    padding: 6rem 2rem;
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    margin-bottom: 3rem;
}

.stats-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 3rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    font-family: 'Rebels', monospace;
}

.stat-label {
    font-size: 1rem;
    color: var(--muted-foreground);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

/* ===== FOOTER ===== */
.footer {
    text-align: center;
    padding: 2rem;
    color: var(--muted-foreground);
    border-top: 1px solid var(--border);
    margin-top: auto;
    font-size: 0.875rem;
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
    opacity: 0.1;
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

/* Stagger animations for course cards */
.course-card:nth-child(1) { animation-delay: 0.1s; }
.course-card:nth-child(2) { animation-delay: 0.2s; }
.course-card:nth-child(3) { animation-delay: 0.3s; }
.course-card:nth-child(4) { animation-delay: 0.4s; }
.course-card:nth-child(5) { animation-delay: 0.5s; }
.course-card:nth-child(6) { animation-delay: 0.6s; }
.course-card:nth-child(7) { animation-delay: 0.7s; }
.course-card:nth-child(8) { animation-delay: 0.8s; }
.course-card:nth-child(9) { animation-delay: 0.9s; }
.course-card:nth-child(10) { animation-delay: 1s; }

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1400px) {
    .desktop-container {
        min-width: 100%;
        grid-template-columns: 240px 1fr;
    }
    
    .courses-container {
        gap: 2rem;
    }
}

@media (max-width: 1200px) {
    .courses-container {
        grid-template-columns: repeat(2, 1fr);
        justify-content: center;
    }
}

@media (max-width: 1024px) {
    .desktop-container {
        grid-template-columns: 1fr;
        min-width: 100%;
        padding: 1rem;
    }
    
    .desktop-sidebar {
        display: none;
    }
    
    .courses-container {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .page-header h1 {
        font-size: 2.75rem;
    }
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2.25rem;
    }
    
    .page-header p {
        font-size: 1rem;
        padding: 0 1rem;
    }
    
    .courses-container {
        grid-template-columns: 1fr;
        max-width: 500px;
    }
    
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
}

@media (max-width: 480px) {
    .desktop-container {
        padding: 0.75rem;
    }
    
    .page-header {
        margin-bottom: 1.5rem;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .course-body {
        padding: 1.5rem;
    }
    
    .course-body h3 {
        font-size: 1.4rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
}

@media (max-width: 360px) {
    .page-header h1 {
        font-size: 1.75rem;
    }
}

/* Custom Scrollbar */
.desktop-main::-webkit-scrollbar {
    width: 6px;
}

.desktop-main::-webkit-scrollbar-track {
    background: transparent;
}

.desktop-main::-webkit-scrollbar-thumb {
    background: var(--muted);
    border-radius: 3px;
}

.desktop-main::-webkit-scrollbar-thumb:hover {
    background: var(--muted-foreground);
}
</style>
</head>
<body>
<!-- TV Noise Effect -->
<div class="tv-noise"></div>

<div class="desktop-container">
    <!-- Left Sidebar - Navigation -->
    <div class="desktop-sidebar">
        <!-- Logo Section -->
        <div class="card">
            <div class="p-4">
                <div class="flex items-center gap-3">
                    <div class="size-12 flex items-center justify-center bg-primary rounded-lg">
                        <svg class="size-8 text-primary-foreground" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 6.559 6.166 8.16l-.22 3.536 1.76 1.587.346 1.729L10 15.42l1.949-.408.345-1.729 1.76-1.587-.22-3.536L10 6.56Zm0-4.039 1.556 1.791 2.326-.691-.833 1.996 2.703 1.131A3.055 3.055 0 0 1 18.8 9.811c0 1.666-1.32 3.018-2.954 3.065l-1.681 1.461-.503 2.42L10 17.48l-3.661-.723-.503-2.42-1.682-1.461C2.52 12.829 1.2 11.477 1.2 9.81A3.055 3.055 0 0 1 4.25 6.747l2.703-1.131-.833-1.996 2.325.691L10 2.52Zm-.597 7.04c0 .754-.566 1.383-1.336 1.383-.785 0-1.367-.629-1.367-1.383h2.703Zm-.597 2.451h2.389L10 13.913 8.806 12.01ZM13.3 9.56c0 .754-.581 1.383-1.367 1.383-.77 0-1.336-.629-1.336-1.383H13.3Zm-10.198.251c0 .519.361.959.832 1.085l.173-2.2A1.111 1.111 0 0 0 3.102 9.81Zm12.964 1.085c.471-.126.833-.566.833-1.085 0-.581-.44-1.052-1.006-1.115l.173 2.2Z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-display"><?= $_SESSION['c-user']; ?></div>
                        <div class="text-xs uppercase text-muted-foreground"><?= $_SESSION['c-course']; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-3">
                <!-- Tools Section -->
                <div class="nav-section">
                    <div class="space-y-1" style="height: 45cap;">
                        <a href="dashboard.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M5.833 3.333h-2.5v13.334h2.5m8.333-13.334h2.5v13.334h-2.5"/>
                            </svg>
                            <span class="nav-label">Overview</span>
                        </a>
                        <a href="lab.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-width="1.667" d="M16.228 3.772c1.31 1.31-.416 5.16-3.856 8.6-3.44 3.44-7.29 5.167-8.6 3.856-1.31-1.31.415-5.16 3.855-8.6 3.44-3.44 7.29-5.167 8.6-3.856Z"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M16.228 16.228c-1.31 1.31-5.161-.416-8.601-3.855-3.44-3.44-5.166-7.29-3.856-8.601 1.31-1.31 5.162.416 8.601 3.855 3.44 3.44 5.166 7.29 3.856 8.601Z"/>
                            </svg>
                            <span class="nav-label">Laboratory</span>
                        </a>
                       <a href="ourcourse.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <!-- Book icon -->
                                <path stroke-width="1.5" d="M16.667 15V5.833a2.5 2.5 0 0 0-2.5-2.5H5.833a2.5 2.5 0 0 0-2.5 2.5v10a2.5 2.5 0 0 0 2.5 2.5h10"/>
                                <path stroke-width="1.5" d="M6.667 3.333v13.334"/>
                                <path stroke-width="1.5" d="M10 6.667h3.333"/>
                                <path stroke-width="1.5" d="M10 10h3.333"/>
                            </svg>
                            <span class="nav-label">Courses</span>
                        </a>
                        <a href="assignment.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <!-- Book -->
                                <path stroke-width="1.5" d="M16.667 16.667V5a2.5 2.5 0 0 0-2.5-2.5H6.667a2.5 2.5 0 0 0-2.5 2.5v11.667"/>
                                <path stroke-width="1.5" d="M6.667 2.5v15"/>
                                <!-- Pencil -->
                                <path stroke-width="1.5" d="M11.667 4.167l4.166 4.166" stroke-linecap="round"/>
                                <path stroke-width="1.5" d="M13.333 8.333l-2.5 2.5-2.5-2.5 2.5-2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="nav-label">Assignments</span>
                        </a>
                        <a href="maintanance.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 4.164V2.497m3.333 1.67V2.5M6.667 4.167v-1.67M10 17.5v-1.667m3.333 1.667v-1.667M6.667 17.5v-1.667m9.166-2.5H17.5m-1.667-6.667H17.5M15.833 10H17.5m-15 0h1.667M2.5 13.334h1.667M2.5 6.666h1.667M12.5 10a2.501 2.501 0 1 1-5.002 0 2.501 2.501 0 0 1 5.002 0ZM4.167 4.167h11.666v11.666H4.167V4.167Z"/>
                            </svg>
                            <span class="nav-label">Devices</span>
                        </a>
                        <a href="leaderboard.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-width="1.667" d="M10 2.5l3.333 6.667H6.667L10 2.5z"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M3.333 10.833h13.334"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M5.833 13.333h8.334"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M7.5 15.833h5"/>
                            </svg>
                            <span class="nav-label">Leaderboard</span>
                        </a>
                        <a href="maintanance.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 3.333H4.166v7.5h11.667v-7.5H10Zm0 0V1.667m-6.667 12.5 1.25-1.25m12.083 1.25-1.25-1.25M7.5 6.667V7.5m5-.833V7.5M5 10.833V12.5a5 5 0 0 0 10 0v-1.667"/>
                            </svg>
                            <span class="nav-label">Security status</span>
                        </a>
                        <a href="contactus.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                <path fill="currentColor" d="M17.5 4.167h.833v-.834H17.5v.834Zm0 11.666v.834h.833v-.834H17.5Zm-15 0h-.833v.834H2.5v-.834Zm0-11.666v-.834h-.833v.834H2.5Zm7.5 6.666-.528.645.528.432.528-.432-.528-.645Zm7.5-6.666h-.833v11.666h1.666V4.167H17.5Zm0 11.666V15h-15V16.667h15v-.834Zm-15 0h.833V4.167H1.667v11.666H2.5Zm0-11.666V5h15V3.333h-15v.834Zm7.5 6.666.528-.645-7.084-5.795-.527.645-.528.645 7.083 5.795.528-.645Zm7.083-5.795-.527-.645-7.084 5.795.528.645.528.645 7.083-5.795-.528-.645Z"/>
                            </svg>
                            <span class="nav-label">Contact support</span>
                        </a>
                       <a href="https://dragotool.shop/"
                        class="nav-item"
                        target="_blank"
                        rel="noopener noreferrer">
                            <svg class="nav-icon" viewBox="0 0 640 512" fill="currentColor">
                                <path d="M18.32 255.78L192 223.96l-91.28 68.69c-10.08 10.08-2.94 27.31 11.31 27.31h222.7c.94 0 1.78-.23 2.65-.29l-79.21 88.62c-9.85 11.03-2.16 28.11 12.58 28.11 6.34 0 12.27-3.59 15.99-9.26l79.21-88.62c.39.04.78.07 1.18.07h78.65c14.26 0 21.39-17.22 11.32-27.31l-79.2-88.62c.39-.04.78-.07 1.18-.07h78.65c14.26 0 21.39-17.22 11.32-27.31L307.33 9.37c-6.01-6.76-17.64-6.76-23.65 0l-265.38 246.4c-10.08 10.08-2.94 27.31 11.31 27.31h79.21c.39 0 .78-.03 1.17-.07L18.32 255.78z"/>
                            </svg>
                            <span class="nav-label">Drago Tool</span>
                        </a>

                        <a href="logout.php" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 512 512" fill="currentColor">
                                <!-- Font Awesome Sign-out icon -->
                                <path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/>
                            </svg>
                            <span class="nav-label">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="desktop-main">
        <!-- HEADER -->
        <section class="page-header animate-fadeIn">
            <h1>Our Courses</h1>
            <p>Comprehensive programs designed by industry experts to transform you into a sought-after technology professional.</p>
        </section>

        <!-- COURSES GRID -->
        <div class="courses-container">
            <!-- Secure X -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/secure-x.png" alt="Secure X">
                    <div class="course-badge">Advanced</div>
                </div>
                <div class="course-body">
                    <h3>Secure X</h3>
                    <p>Master advanced cybersecurity techniques and digital defense strategies. Learn to protect systems from sophisticated cyber threats and vulnerabilities.</p>
                    <button onclick="window.location.href='course-details/secure-x.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- AI Verse Web Labs -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/ai.png" alt="AI Verse Web Labs">
                    <div class="course-badge">Professional</div>
                </div>
                <div class="course-body">
                    <h3>AI Verse Web Labs</h3>
                    <p>Build intelligent web applications using AI-driven development, machine learning integration, and automated engineering workflows.</p>
                    <button onclick="window.location.href='course-details/Ai.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Hunt Elite -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/hunt-elite.png" alt="Hunt Elite">
                    <div class="course-badge">Expert</div>
                </div>
                <div class="course-body">
                    <h3>Hunt Elite</h3>
                    <p>Professional bug bounty hunting and exploit analysis. Learn advanced penetration testing and ethical hacking techniques.</p>
                    <button onclick="window.location.href='course-details/Hunt.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Creative Craft -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/creative-craft.png" alt="Creative Craft">
                    <div class="course-badge">Creative</div>
                </div>
                <div class="course-body">
                    <h3>Creative Craft</h3>
                    <p>Master strategic visual communication design, branding, and UI/UX principles to create compelling digital experiences.</p>
                    <button onclick="window.location.href='course-details/Canva.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Py Desk Systems -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/py-desk.png" alt="Py Desk Systems">
                    <div class="course-badge">Development</div>
                </div>
                <div class="course-body">
                    <h3>Py Desk Systems</h3>
                    <p>Develop enterprise-grade desktop applications with Python. Master GUI frameworks and system-level programming.</p>
                    <button onclick="window.location.href='course-details/py.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Biz Dev -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/biz.png" alt="Biz Dev">
                    <div class="course-badge">Business</div>
                </div>
                <div class="course-body">
                    <h3>Biz Dev</h3>
                    <p>Combine business strategy with software development. Build scalable tech solutions while understanding market needs.</p>
                    <button onclick="window.location.href='course-details/biz.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Code Foundry -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/code-f.png" alt="Code Foundry">
                    <div class="course-badge">Fundamental</div>
                </div>
                <div class="course-body">
                    <h3>Code Foundry</h3>
                    <p>Professional programming language mastery. Deep dive into best practices and advanced software engineering concepts.</p>
                    <button onclick="window.location.href='course-details/Code.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Startup Gene Labs -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/startup.png" alt="Startup Gene Labs">
                    <div class="course-badge">Entrepreneurship</div>
                </div>
                <div class="course-body">
                    <h3>Startup Gene Labs</h3>
                    <p>Venture creation and startup scaling. Build, fund, and grow tech startups from idea to successful enterprise.</p>
                    <button onclick="window.location.href='course-details/startup.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- CLI++ Systems -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/cli.png" alt="CLI++ Systems">
                    <div class="course-badge">Systems</div>
                </div>
                <div class="course-body">
                    <h3>CLI++ Systems</h3>
                    <p>C++ command-line tool engineering for Linux. Build powerful system tools using advanced programming techniques.</p>
                    <button onclick="window.location.href='course-details/CLI.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- API Man -->
            <div class="course-card animate-fadeIn">
                <div class="course-image">
                    <img src="images/jai-bro/app.png" alt="API Man">
                    <div class="course-badge">Backend</div>
                </div>
                <div class="course-body">
                    <h3>API Man</h3>
                    <p>Master API development and management. Build RESTful and GraphQL APIs with scalable architecture patterns.</p>
                    <button onclick="window.location.href='course-details/api.pdf'" class="course-action">
                        View Details
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// DOM Elements
const courseCards = document.querySelectorAll('.course-card');

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

// Observe all animated elements
document.querySelectorAll('.animate-fadeIn').forEach(el => {
    observer.observe(el);
});

// Add hover effects to course cards
courseCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
        this.style.boxShadow = '0 25px 50px rgba(220, 38, 38, 0.3)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
        this.style.boxShadow = 'var(--shadow-xl)';
    });
});

// Navigation active states
const navItems = document.querySelectorAll('.nav-item');
navItems.forEach(item => {
    item.addEventListener('click', function(e) {
        if (!this.classList.contains('disabled')) {
            // Remove active class from all items
            navItems.forEach(i => i.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
        }
    });
});

// Initialize on load
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    // Add loading animation to page header
    const header = document.querySelector('.page-header h1');
    if (header) {
        header.style.opacity = '0';
        header.style.transform = 'translateY(20px)';
        setTimeout(() => {
            header.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            header.style.opacity = '1';
            header.style.transform = 'translateY(0)';
        }, 100);
    }
    
    // Animate stats
    const stats = document.querySelectorAll('.stat-number');
    stats.forEach(stat => {
        const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
        const suffix = stat.textContent.replace(/[0-9]/g, '');
        
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                stat.textContent = target + suffix;
                clearInterval(timer);
            } else {
                stat.textContent = Math.floor(current) + suffix;
            }
        }, 30);
    });
});
</script>
</body>
</html>