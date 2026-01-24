<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | ProWorldz</title>
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
        .contact-hero {
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

        .contact-hero::before {
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

        /* ===== CONTACT CONTAINER ===== */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            padding: 6rem 0;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            border-bottom: 1px solid var(--border);
        }

        .contact-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
            opacity: 0.5;
        }

        /* ===== CONTACT INFO ===== */
        .contact-info {
            background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
            padding: 3rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .contact-info::before {
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

        .contact-info:hover::before {
            transform: scaleX(1);
        }

        .contact-info:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-2xl);
        }

        .contact-info h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
        }

        .contact-info > p {
            color: var(--muted-foreground);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
        }

        .info-box {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            border-radius: calc(var(--radius) - 2px);
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.5s;
        }

        .info-box:hover::before {
            left: 100%;
        }

        .info-box:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            transform: translateX(8px);
        }

        .info-box i {
            font-size: 1.5rem;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .info-box:hover i {
            background: var(--gradient-primary);
            color: var(--primary-foreground);
            transform: scale(1.1);
        }

        .info-box p {
            color: var(--foreground);
            font-size: 1.125rem;
            font-weight: 500;
            margin: 0;
        }

        /* ===== CONTACT FORM ===== */
        .contact-form {
            background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
            padding: 3rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .contact-form::before {
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

        .contact-form:hover::before {
            transform: scaleX(1);
        }

        .contact-form:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-2xl);
        }

        .contact-form h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--muted-foreground);
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: color 0.3s ease;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 4px);
            color: var(--foreground);
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--muted-foreground);
            opacity: 0.7;
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 1.125rem;
            background: var(--gradient-primary);
            color: var(--primary-foreground);
            border: none;
            border-radius: calc(var(--radius) - 4px);
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .submit-btn i {
            margin-right: 0.75rem;
        }

        /* ===== CTA SECTION ===== */
        .contact-cta {
            padding: 6rem 0;
            text-align: center;
            background: 
                linear-gradient(135deg, var(--card) 0%, rgba(13, 16, 21, 0.95) 100%),
                radial-gradient(circle at 30% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        .contact-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
            opacity: 0.5;
        }

        .contact-cta h2 {
            font-size: 3rem;
            margin-bottom: 2rem;
            color: var(--foreground);
            font-family: 'Rebels', monospace;
            line-height: 1.2;
        }

        .contact-cta h2 span {
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

        /* ===== NOTIFICATION STYLES ===== */
        .notification {
            position: fixed;
            top: 100px;
            right: 2rem;
            padding: 1.25rem 1.75rem;
            border-radius: calc(var(--radius) - 2px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            z-index: 10000;
            animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
        }

        .notification.success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(30, 144, 255, 0.9));
            color: white;
        }

        .notification.error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(255, 107, 129, 0.9));
            color: white;
        }

        .notification span {
            flex: 1;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .close-notification {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .close-notification:hover {
            opacity: 1;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .hero-content h1 {
                font-size: 3.25rem;
            }
            
            .contact-cta h2 {
                font-size: 2.5rem;
            }
            
            .contact-info h2,
            .contact-form h2 {
                font-size: 2rem;
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
            
            .contact-container {
                grid-template-columns: 1fr;
                padding: 4rem 0;
                gap: 2rem;
            }
            
            .contact-info,
            .contact-form {
                padding: 2.5rem;
            }
            
            .contact-cta {
                padding: 5rem 0;
            }
            
            .contact-cta h2 {
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
            
            .contact-info h2,
            .contact-form h2,
            .contact-cta h2 {
                font-size: 1.8rem;
            }
            
            .nav-container {
                padding: 1rem;
            }
            
            .nav-links {
                width: 100%;
            }
            
            .contact-info,
            .contact-form {
                padding: 2rem;
            }
            
            .info-box {
                padding: 1.25rem;
            }
            
            .info-box i {
                width: 45px;
                height: 45px;
                font-size: 1.25rem;
            }
            
            .info-box p {
                font-size: 1rem;
            }
            
            .form-group input,
            .form-group textarea {
                padding: 0.875rem 1rem;
            }
            
            .hero-content p,
            .contact-info > p {
                font-size: 1rem;
            }
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
                <li class="nav-item"><a href="../index.php"><i class="fas fa-graduation-cap"></i> Courses</a></li>
                <li class="nav-item"><a href="about-home.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="contact-home.php"><i class="fas fa-envelope"></i> Contact</a></li>

                <!-- MOBILE BUTTONS -->
                <div class="nav-btns mobile-btns">
                    <a class="button button-secondary" href="../login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <!-- <button class="button button-default"><i class="fas fa-user-plus"></i> Sign Up</button> -->
                </div>
            </ul>

            <!-- DESKTOP BUTTONS -->
            <div class="nav-btns desktop-btns">
                <a class="button button-secondary" href="../login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                <!-- <button class="button button-default"><i class="fas fa-user-plus"></i> Sign Up</button> -->
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="contact-hero">
        <div class="container hero-content">
            <h1 class="animate-fadeIn">Contact ProWorldz</h1>
            <p class="animate-fadeIn delay-1">
                Let's connect and build your future in tech
            </p>
        </div>
    </section>

    <!-- CONTACT CONTAINER -->
    <div class="container">
        <div class="contact-container">
            <!-- LEFT INFO -->
            <div class="contact-info animate-fadeIn delay-1">
                <h2>Get in Touch</h2>
                <p>Have questions about our courses or platform? Send us a message and our team will reach out to you.</p>

                <div class="info-box animate-fadeIn delay-2">
                    <i class="fas fa-envelope"></i>
                    <p>proworldz0311@gmail.com</p>
                </div>

                <div class="info-box animate-fadeIn delay-3">
                    <i class="fas fa-phone"></i>
                    <p>+91 98765 43210</p>
                </div>

                <div class="info-box animate-fadeIn delay-4">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>India</p>
                </div>
            </div>

            <!-- RIGHT FORM -->
            <form class="contact-form animate-fadeIn delay-2" id="contactForm">
                <h2>Send Message</h2>
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4" required placeholder="Enter your message"></textarea>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- CTA SECTION -->
    <section class="contact-cta">
        <div class="container">
            <h2 class="animate-fadeIn">Ready to Start Your <span>Tech Journey</span>?</h2>
            <a href="../index.php" class="cta-btn animate-fadeIn delay-2">
                Explore Courses <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 ProWorldz. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // MOBILE MENU TOGGLE
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');
        
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
        
        // Form submission
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            
            // Form validation
            if (!name || !email || !message) {
                showNotification('Please fill in all fields', 'error');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }
            
            // Disable submit button and show loading
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Show success message
                showNotification('Message sent successfully! We will get back to you soon.', 'success');
                
                // Reset form
                contactForm.reset();
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
        
        // Notification function
        function showNotification(message, type) {
            // Remove existing notification
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <span>${message}</span>
                <button class="close-notification">&times;</button>
            `;
            
            // Add close button event
            const closeBtn = notification.querySelector('.close-notification');
            closeBtn.addEventListener('click', () => {
                notification.style.animation = 'slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1) reverse';
                setTimeout(() => notification.remove(), 400);
            });
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1) reverse';
                    setTimeout(() => notification.remove(), 400);
                }
            }, 5000);
            
            // Add to document
            document.body.appendChild(notification);
        }
        
        // Add hover effect to info boxes
        document.querySelectorAll('.info-box').forEach(box => {
            box.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
            });
            
            box.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Add hover effect to form container
        const formContainer = document.querySelector('.contact-container');
        if (formContainer) {
            const formElements = formContainer.querySelectorAll('.contact-info, .contact-form');
            formElements.forEach(el => {
                el.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                el.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
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
        
        // Add parallax effect to hero
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.contact-hero');
            if (hero) {
                hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
            }
        });
        
        // Handle responsive menu buttons
        checkScreenSize();
    </script>
</body>
</html>