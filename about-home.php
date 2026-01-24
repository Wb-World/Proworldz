<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | ProWorldz</title>
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
            --primary-dark: #4f52d0;
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

        /* ===== UTILITY CLASSES ===== */
        .font-display {
            font-family: 'Rebels', 'Roboto Mono', monospace;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== NAVBAR STYLES ===== */
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
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--foreground);
            text-decoration: none;
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

        .button-default {
            background: var(--gradient-primary);
            color: var(--primary-foreground);
        }

        .button-default:hover {
            background: var(--gradient-primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
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
        .about-hero {
            padding: 15rem 0 8rem;
            background: 
                linear-gradient(135deg, rgba(13, 16, 21, 0.95) 0%, rgba(26, 29, 36, 0.98) 100%),
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(94, 234, 212, 0.05) 0%, transparent 50%);
            background-size: cover;
            background-position: center;
            text-align: center;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
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
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Rebels', monospace;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: var(--muted-foreground);
            line-height: 1.8;
            max-width: 700px;
            margin: 0 auto;
        }

        /* ===== SECTION STYLES ===== */
        .section {
            padding: 6rem 0;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section.dark {
            background: var(--gradient-dark);
        }

        .content-box {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .section-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .section-title .icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title .icon i {
            color: white;
            font-size: 1rem;
        }

        .content-box h2 {
            font-size: 2.75rem;
            margin-bottom: 2rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
            line-height: 1.2;
        }

        .content-box h2 span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .content-box p {
            font-size: 1.15rem;
            color: var(--muted-foreground);
            line-height: 1.8;
        }

        /* ===== CARDS SECTION ===== */
        .center {
            text-align: center;
            font-size: 2.75rem;
            margin-bottom: 3rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .center span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .card {
            background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.8) 100%);
            padding: 2.5rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
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

        .card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
            box-shadow: var(--shadow-2xl);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card h3 i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .card p {
            color: var(--muted-foreground);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* ===== CTA SECTION ===== */
        .about-cta {
            padding: 8rem 0;
            text-align: center;
            background: 
                linear-gradient(135deg, var(--card) 0%, rgba(13, 16, 21, 0.95) 100%),
                radial-gradient(circle at 30% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        .about-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
            opacity: 0.5;
        }

        .about-cta h2 {
            font-size: 3rem;
            margin-bottom: 2rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
            line-height: 1.2;
        }

        .about-cta h2 span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.25rem 3rem;
            background: var(--gradient-primary);
            color: var(--primary-foreground);
            text-decoration: none;
            border-radius: calc(var(--radius) - 2px);
            font-weight: 600;
            font-size: 1.125rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .cta-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .cta-btn:hover::before {
            left: 100%;
        }

        .cta-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.4);
        }

        .cta-btn i {
            transition: transform 0.3s ease;
        }

        .cta-btn:hover i {
            transform: translateX(5px);
        }

        /* ===== FOOTER ===== */
        .footer {
            padding: 4rem 0;
            background-color: var(--card);
            text-align: center;
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

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .hero-content h1 {
                font-size: 3.25rem;
            }
            
            .content-box h2,
            .center {
                font-size: 2.5rem;
            }
            
            .about-cta h2 {
                font-size: 2.5rem;
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
            
            .hero-content h1 {
                font-size: 2.75rem;
            }
            
            .section {
                padding: 4rem 0;
            }
            
            .content-box h2,
            .center {
                font-size: 2.25rem;
            }
            
            .cards {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .about-cta {
                padding: 6rem 0;
            }
            
            .about-cta h2 {
                font-size: 2.25rem;
            }
            
            .cta-btn {
                padding: 1rem 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2.25rem;
            }
            
            .content-box h2,
            .center {
                font-size: 2rem;
            }
            
            .nav-container {
                padding: 1rem;
            }
            
            .nav-links {
                width: 100%;
            }
            
            .about-cta h2 {
                font-size: 2rem;
            }
            
            .card {
                padding: 2rem;
            }
            
            .hero-content p,
            .content-box p {
                font-size: 1rem;
            }
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-fadeIn {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-fadeIn.delay-1 { animation-delay: 0.1s; }
        .animate-fadeIn.delay-2 { animation-delay: 0.2s; }
        .animate-fadeIn.delay-3 { animation-delay: 0.3s; }
        .animate-fadeIn.delay-4 { animation-delay: 0.4s; }
        .animate-fadeIn.delay-5 { animation-delay: 0.5s; }

        .animate-slideIn {
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeInUp 0.6s ease-out forwards;
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

        /* ===== STATS COUNTER ===== */
        .stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--muted-foreground);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
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
    <!-- GLOW EFFECTS -->
    <div class="glow" style="top: 20%; left: 10%;"></div>
    <div class="glow" style="top: 60%; right: 15%;"></div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container nav-container">
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

                <!-- MOBILE BUTTONS -->
                <div class="nav-btns mobile-btns">
                    <button class="button button-secondary"><i class="fas fa-sign-in-alt"></i> Login</button>
                </div>
            </ul>

            <!-- DESKTOP BUTTONS -->
            <div class="nav-btns desktop-btns">
                <button class="button button-secondary"><i class="fas fa-sign-in-alt"></i> Login</button>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="about-hero">
        <div class="container hero-content">
            <h1 class="animate-fadeIn">About ProWorldz</h1>
            <p class="animate-fadeIn delay-1">
                A next-generation EdTech platform dedicated to empowering students with 
                real-world, job-ready technology skills through industry-aligned education.
            </p>
            
            <div class="stats animate-fadeIn delay-2">
                <div class="stat-item">
                    <div class="stat-number" data-count="5000">0</div>
                    <div class="stat-label">Students Trained</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="95">0</div>
                    <div class="stat-label">Success Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" data-count="200">0</div>
                    <div class="stat-label">Industry Partners</div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHO WE ARE -->
    <section class="section dark">
        <div class="container">
            <div class="content-box">
                <div class="section-title animate-fadeIn">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h2>Who <span>We Are</span></h2>
                </div>
                <p class="animate-fadeIn delay-1">
                    ProWorldz is a professional EdTech platform strategically designed to bridge the critical gap
                    between academic learning and industry requirements. We emphasize practical skills, 
                    hands-on projects, and mentorship-driven learning methodologies to prepare students 
                    for successful careers in the dynamic technology sector.
                </p>
            </div>
        </div>
    </section>

    <!-- OUR MISSION -->
    <section class="section">
        <div class="container">
            <div class="content-box">
                <div class="section-title animate-fadeIn">
                    <div class="icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2>Our <span>Mission</span></h2>
                </div>
                <p class="animate-fadeIn delay-1">
                    To democratize access to high-quality tech education by providing affordable, 
                    industry-relevant learning experiences that enable learners to build confidence, 
                    gain practical experience, and secure meaningful opportunities in the global IT industry.
                </p>
            </div>
        </div>
    </section>

    <!-- WHY PROWORLDZ -->
    <section class="section dark">
        <div class="container">
            <h2 class="center animate-fadeIn">
                <i class="fas fa-star"></i> Why <span>ProWorldz</span>?
            </h2>

            <div class="cards">
                <div class="card animate-fadeIn delay-1">
                    <h3><i class="fas fa-industry"></i> Industry-Oriented Curriculum</h3>
                    <p>Courses meticulously designed based on current and emerging industry needs, ensuring relevance and immediate applicability.</p>
                </div>

                <div class="card animate-fadeIn delay-2">
                    <h3><i class="fas fa-hands"></i> Hands-on Project Experience</h3>
                    <p>Gain practical expertise through live, real-time projects that simulate professional work environments.</p>
                </div>

                <div class="card animate-fadeIn delay-3">
                    <h3><i class="fas fa-user-tie"></i> Expert Industry Mentorship</h3>
                    <p>Learn directly from seasoned industry professionals who provide real-world insights and career guidance.</p>
                </div>

                <div class="card animate-fadeIn delay-4">
                    <h3><i class="fas fa-briefcase"></i> Comprehensive Career Support</h3>
                    <p>Receive personalized guidance, mentoring, and structured learning paths specifically tailored for career advancement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- VISION -->
    <section class="section">
        <div class="container">
            <div class="content-box">
                <div class="section-title animate-fadeIn">
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2>Our <span>Vision</span></h2>
                </div>
                <p class="animate-fadeIn delay-1">
                    To establish a globally trusted learning ecosystem that consistently nurtures innovation, 
                    fosters creativity, and cultivates technical excellence among students worldwide, 
                    ultimately shaping the future leaders of technology.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="about-cta">
        <div class="container">
            <h2 class="animate-fadeIn">Start Your Learning Journey With <span>ProWorldz</span></h2>
            <p class="animate-fadeIn delay-1" style="margin-bottom: 3rem; font-size: 1.2rem; color: var(--muted-foreground);">
                Join thousands of successful professionals who transformed their careers with our industry-focused education.
            </p>
            <a href="index.php" class="cta-btn animate-fadeIn delay-2">
                Explore Courses <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 ProWorldz Technologies. All Rights Reserved.</p>
            <p style="margin-top: 0.5rem; font-size: 0.8rem; color: var(--muted-foreground);">
                Empowering Future Tech Leaders
            </p>
        </div>
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
            const desktopBtns = document.querySelector('.desktop-btns');
            
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
        
        // Scroll animations
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observe all animated elements
        document.querySelectorAll('.animate-fadeIn').forEach(el => {
            observer.observe(el);
        });
        
        // Animate stats counter
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                if (element.dataset.count === '95') {
                    element.textContent = current.toFixed(1) + '%';
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 20);
        }
        
        // Start counter animation when in view
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = document.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const target = parseFloat(stat.dataset.count);
                        animateCounter(stat, target);
                    });
                    statObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        const statsSection = document.querySelector('.about-hero');
        if (statsSection) {
            statObserver.observe(statsSection);
        }
        
        // Add smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId !== '#') {
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
        
        // Add loading animation
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
        
        // Handle responsive menu buttons
        checkScreenSize();
        
        // Add hover effect to cards
        document.querySelectorAll('.card').forEach(card => {
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
            const hero = document.querySelector('.about-hero');
            if (hero) {
                hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
            }
        });
    </script>
</body>
</html>