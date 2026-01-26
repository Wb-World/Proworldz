<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Courses | ProWorldz</title>

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
        
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* ===== NAVBAR ===== */
    .navbar {
        background-color: rgba(26, 29, 36, 0.95);
        border-bottom: 1px solid var(--border);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .logo {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--foreground);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Rebels', monospace;
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
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .nav-links {
        display: flex;
        list-style: none;
        gap: 2.5rem;
        align-items: center;
    }

    .nav-item a {
        color: var(--muted-foreground);
        text-decoration: none;
        text-transform: uppercase;
        font-size: 0.875rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0.5rem 0;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-item a i {
        font-size: 0.8rem;
    }

    .nav-item a:hover {
        color: var(--foreground);
    }

    .nav-item.active a {
        color: var(--primary);
        font-weight: 600;
    }

    .nav-item a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-primary);
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-item a:hover::after,
    .nav-item.active a::after {
        width: 100%;
    }

    .nav-btns {
        display: flex;
        gap: 1rem;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: calc(var(--radius) - 2px);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: 1px solid transparent;
        user-select: none;
        white-space: nowrap;
        padding: 0.75rem 2rem;
        font-size: 0.875rem;
        position: relative;
        overflow: hidden;
        font-family: 'Roboto Mono', monospace;
    }

    .button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .button:hover::before {
        left: 100%;
    }

    .button-secondary {
        background-color: transparent;
        color: var(--foreground);
        border-color: var(--border);
    }

    .button-secondary:hover {
        background-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .menu-toggle {
        display: none;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
        z-index: 1001;
        padding: 0.5rem;
    }

    .menu-toggle span {
        width: 25px;
        height: 2px;
        background: var(--foreground);
        border-radius: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== HERO SECTION ===== */
    .hero {
        padding: 15rem 0 8rem;
        background: 
            linear-gradient(135deg, rgba(13, 16, 21, 0.95) 0%, rgba(26, 29, 36, 0.98) 100%),
            radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 50%, rgba(94, 234, 212, 0.05) 0%, transparent 50%);
        background-size: cover;
        background-position: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--gradient-primary);
        opacity: 0.5;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 1;
    }

    .hero h1 {
        font-family: 'Rebels', monospace;
        font-size: 4rem;
        margin-bottom: 1.5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.2;
    }

    .hero p {
        font-size: 1.25rem;
        color: var(--muted-foreground);
        line-height: 1.8;
        max-width: 700px;
        margin: 0 auto;
    }

    /* ===== COURSES SECTION ===== */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
        padding: 4rem 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .course-card-full {
        background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card-full::before {
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

    .course-card-full:hover {
        transform: translateY(-8px);
        border-color: var(--primary);
        box-shadow: var(--shadow-2xl);
    }

    .course-card-full:hover::before {
        transform: scaleX(1);
    }

    .course-img {
        height: 200px;
        overflow: hidden;
        position: relative;
        background: var(--gradient-subtle);
    }

    .course-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .course-card-full:hover .course-img img {
        transform: scale(1.05);
    }

    .course-content {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 1;
    }

    .course-content h3 {
        font-family: 'Rebels', monospace;
        font-size: 1.5rem;
        color: var(--foreground);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .course-content p {
        color: var(--muted-foreground);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }

    .course-btn {
        background: var(--gradient-primary);
        border: none;
        padding: 0.875rem 1.5rem;
        border-radius: calc(var(--radius) - 2px);
        color: var(--primary-foreground);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Roboto Mono', monospace;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .course-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .course-btn:hover::before {
        left: 100%;
    }

    .course-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
    }

    /* ===== TV NOISE EFFECT ===== */
    .tv-noise {
        position: fixed;
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
        opacity: 0.05;
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

    /* ===== FOOTER ===== */
    .footer {
        padding: 4rem 2rem;
        text-align: center;
        background-color: var(--card);
        border-top: 1px solid var(--border);
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--gradient-primary);
        opacity: 0.5;
    }

    .footer p {
        color: var(--muted-foreground);
        font-size: 0.9rem;
        letter-spacing: 0.05em;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    .fade-in:nth-child(4) { animation-delay: 0.4s; }
    .fade-in:nth-child(5) { animation-delay: 0.5s; }
    .fade-in:nth-child(6) { animation-delay: 0.6s; }
    .fade-in:nth-child(7) { animation-delay: 0.7s; }
    .fade-in:nth-child(8) { animation-delay: 0.8s; }
    .fade-in:nth-child(9) { animation-delay: 0.9s; }
    .fade-in:nth-child(10) { animation-delay: 1s; }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 1024px) {
        .hero h1 {
            font-size: 3rem;
        }
        
        .course-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }
        
        .nav-links {
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .menu-toggle {
            display: flex;
        }
        
        .nav-links {
            position: fixed;
            top: 0;
            right: -100%;
            width: 320px;
            height: 100vh;
            background: var(--card);
            flex-direction: column;
            padding: 6rem 2rem 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 1px solid var(--border);
            backdrop-filter: blur(20px);
            box-shadow: -20px 0 40px rgba(0, 0, 0, 0.3);
        }
        
        .nav-links.active {
            right: 0;
        }
        
        .nav-btns {
            display: none;
        }
        
        .nav-btns.mobile-btns {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .hero {
            padding: 12rem 0 6rem;
        }
        
        .hero h1 {
            font-size: 2.5rem;
        }
        
        .hero p {
            font-size: 1.1rem;
        }
        
        .course-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            padding: 3rem 1rem;
        }
        
        .course-img {
            height: 180px;
        }
    }

    @media (max-width: 480px) {
        .hero h1 {
            font-size: 2rem;
        }
        
        .hero p {
            font-size: 1rem;
        }
        
        .nav-container {
            padding: 1rem;
        }
        
        .nav-links {
            width: 100%;
        }
        
        .course-content {
            padding: 1.5rem;
        }
        
        .course-content h3 {
            font-size: 1.3rem;
        }
        
        .footer {
            padding: 3rem 1rem;
        }
    }

    @media (max-width: 360px) {
        .hero h1 {
            font-size: 1.8rem;
        }
        
        .course-img {
            height: 160px;
        }
        
        .course-content h3 {
            font-size: 1.2rem;
        }
    }

    /* ===== MOBILE MENU ANIMATION ===== */
    .menu-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(6px, 6px);
        background: var(--primary);
    }

    .menu-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .menu-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(6px, -6px);
        background: var(--primary);
    }

    /* ===== GLOW EFFECTS ===== */
    .glow {
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }
  </style>
</head>
<body>
    <!-- TV Noise Effect -->
    <div class="tv-noise"></div>
    
    <!-- Glow Effects -->
    <div class="glow" style="top: 20%; left: 10%;"></div>
    <div class="glow" style="top: 60%; right: 15%;"></div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <!-- <img 
    src="image.png" 
    alt="ProWorldz Logo" 
    class="logo-img"
    style="
        width: 40px;
        height: 40px;
        object-fit: contain;
        mix-blend-mode: screen;
    "
> -->
            <div class="logo">PRO<span>WORLDZ</span></div>

            <!-- HAMBURGER MENU -->
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul class="nav-links" id="navLinks">
                <li class="nav-item"><a href="index.php"><i class="fas fa-graduation-cap"></i> Courses</a></li>
                <li class="nav-item"><a href="about-home.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="contact-home.php"><i class="fas fa-envelope"></i> Contact</a></li>

                
            </ul>

            <!-- DESKTOP BUTTONS -->
            <div class="nav-btns">
                <a href="login.php" class="button button-secondary"><i class="fas fa-sign-in-alt"></i> Login</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero fade-in">
        <div class="hero-content">
            <h1>Master Advanced Technology Skills</h1>
            <p>Explore our comprehensive collection of professional courses designed to transform you into a tech industry expert with hands-on, real-world projects</p>
        </div>
    </section>

    <!-- COURSES -->
<section class="course-grid">

    <!-- Course 1: Secure X -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/secure-x.png" alt="Secure X Course">
        </div>
        <div class="course-content">
            <h3>Secure X</h3>
            <p>Master advanced cybersecurity techniques, digital defense strategies, and learn to protect systems from sophisticated cyber threats and vulnerabilities.</p>
            <button class="course-btn" onclick="window.location.href='course-details/secure-x.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 2: AI Verse Web Labs -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/ai.png" alt="AI Verse Web Labs">
        </div>
        <div class="course-content">
            <h3>AI Verse Web Labs</h3>
            <p>Build intelligent web applications using AI-driven development, machine learning integration, and automated web engineering workflows.</p>
            <button class="course-btn" onclick="window.location.href='course-details/Ai.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 3: Hunt Elite -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/hunt-elite.png" alt="Hunt Elite Course">
        </div>
        <div class="course-content">
            <h3>Hunt Elite</h3>
            <p>Professional bug bounty hunting and exploit analysis. Learn advanced penetration testing, vulnerability assessment, and ethical hacking techniques.</p>
            <button class="course-btn" onclick="window.location.href='course-details/Hunt.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 4: Creative Craft -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/creative-craft.png" alt="Creative Craft">
        </div>
        <div class="course-content">
            <h3>Creative Craft</h3>
            <p>Master strategic visual communication design, branding, UI/UX principles, and create compelling digital experiences that drive engagement.</p>
            <button class="course-btn" onclick="window.location.href='course-details/Canva.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 5: Py Desk Systems -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/py-desk.png" alt="Py Desk Systems">
        </div>
        <div class="course-content">
            <h3>Py Desk Systems</h3>
            <p>Develop enterprise-grade desktop applications with Python. Master GUI frameworks, database integration, and system-level programming.</p>
            <button class="course-btn" onclick="window.location.href='course-details/py.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 6: Biz Dev -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/biz.png" alt="Biz Dev">
        </div>
        <div class="course-content">
            <h3>Biz Dev</h3>
            <p>Combine business strategy with software development. Learn to build scalable tech solutions while understanding market needs and business models.</p>
            <button class="course-btn" onclick="window.location.href='course-details/biz.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 7: Code Foundry -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/code-f.png" alt="Code Foundry">
        </div>
        <div class="course-content">
            <h3>Code Foundry</h3>
            <p>Professional programming language mastery. Deep dive into multiple languages, best practices, and advanced software engineering concepts.</p>
            <button class="course-btn" onclick="window.location.href='course-details/Code.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 8: Startup Gene Labs -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/startup.png" alt="Startup Gene Labs">
        </div>
        <div class="course-content">
            <h3>Startup Gene Labs</h3>
            <p>Venture creation and startup scaling. Learn to build, fund, and grow tech startups from idea to successful enterprise with proven methodologies.</p>
            <button class="course-btn" onclick="window.location.href='course-details/startup.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 9: CLI++ Systems -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/cli.png" alt="CLI++ Systems">
        </div>
        <div class="course-content">
            <h3>CLI++ Systems</h3>
            <p>C++ command-line tool engineering for Linux. Build powerful, efficient system tools and utilities using advanced C++ programming techniques.</p>
            <button class="course-btn" onclick="window.location.href='course-details/CLI.pdf'">
                Course Details
            </button>
        </div>
    </div>

    <!-- Course 10: API Man -->
    <div class="course-card-full fade-in">
        <div class="course-img">
            <img src="images/jai-bro/app.png" alt="APMan">
        </div>
        <div class="course-content">
            <h3>API Man</h3>
            <p>Master API development, design, and management. Build RESTful and GraphQL APIs, implement security, and create scalable API architectures.</p>
            <button class="course-btn" onclick="window.location.href='course-details/api.pdf'">
                Course Details
            </button>
        </div>
    </div>

</section>


    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2026 ProWorldz. All rights reserved. | Empowering the next generation of tech professionals</p>
    </footer>

<script>
    // MOBILE MENU TOGGLE
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
    
    // Show mobile buttons on mobile
    function checkScreenSize() {
        const mobileBtns = document.querySelector('.mobile-btns');
        const desktopBtns = document.querySelector('.nav-btns:not(.mobile-btns)');
        
        if (window.innerWidth <= 768) {
            mobileBtns.style.display = 'flex';
            desktopBtns.style.display = 'none';
        } else {
            mobileBtns.style.display = 'none';
            desktopBtns.style.display = 'flex';
        }
    }
    
    // Check on load and resize
    window.addEventListener('load', checkScreenSize);
    window.addEventListener('resize', checkScreenSize);
    
    // Add hover effect to cards
    document.querySelectorAll('.course-card-full').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add parallax effect to hero
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
        }
    });
    
    // Initialize animations
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.fade-in').forEach(el => {
                el.style.opacity = '1';
            });
        }, 300);
    });
</script>
</body>
</html>