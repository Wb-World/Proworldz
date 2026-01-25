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
    /* opacity: 0.5; */
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

/* ===== CONTACT CONTAINER ===== */
.contact-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

/* ===== CONTACT INFO ===== */
.contact-info {
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
    padding: 3rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
}

.contact-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.contact-info h2 {
    font-family: 'Rebels', monospace;
    font-size: 2.25rem;
    color: var(--foreground);
    margin-bottom: 1.5rem;
    position: relative;
}

.contact-info > p {
    color: var(--muted-foreground);
    font-size: 1.125rem;
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
    background: var(--gradient-subtle);
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
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
}

.contact-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.contact-form h2 {
    font-family: 'Rebels', monospace;
    font-size: 2.25rem;
    color: var(--foreground);
    margin-bottom: 2rem;
    position: relative;
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
    box-shadow: var(--shadow-lg);
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
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
    padding: 4rem;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    text-align: center;
    margin: 0 auto 4rem;
    max-width: 800px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
}

.contact-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.contact-cta h2 {
    font-family: 'Rebels', monospace;
    font-size: 2.5rem;
    color: var(--foreground);
    margin-bottom: 1.5rem;
    position: relative;
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
    padding: 1.125rem 2.5rem;
    background: var(--gradient-primary);
    color: var(--primary-foreground);
    text-decoration: none;
    border-radius: calc(var(--radius) - 4px);
    font-size: 1rem;
    font-weight: 600;
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
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.cta-btn i {
    transition: transform 0.3s ease;
}

.cta-btn:hover i {
    transform: translateX(5px);
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

/* ===== NOTIFICATION ===== */
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
    box-shadow: var(--shadow-2xl);
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

.animate-fadeIn.delay-1 { animation-delay: 0.1s; }
.animate-fadeIn.delay-2 { animation-delay: 0.2s; }
.animate-fadeIn.delay-3 { animation-delay: 0.3s; }
.animate-fadeIn.delay-4 { animation-delay: 0.4s; }

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1400px) {
    .desktop-container {
        min-width: 100%;
        grid-template-columns: 240px 1fr;
    }
    
    .contact-container {
        gap: 2rem;
    }
    
    .contact-info,
    .contact-form,
    .contact-cta {
        padding: 2.5rem;
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
    
    .contact-container {
        grid-template-columns: 1fr;
        max-width: 700px;
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
    
    .contact-info h2,
    .contact-form h2,
    .contact-cta h2 {
        font-size: 1.875rem;
    }
    
    .contact-info,
    .contact-form,
    .contact-cta {
        padding: 2rem;
    }
    
    .contact-cta {
        padding: 2.5rem 2rem;
    }
    
    .contact-cta h2 {
        font-size: 1.75rem;
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
    
    .contact-info,
    .contact-form {
        padding: 1.75rem 1.25rem;
    }
    
    .contact-cta {
        padding: 2rem 1.25rem;
    }
    
    .form-group input,
    .form-group textarea {
        padding: 0.875rem 1rem;
    }
    
    .submit-btn,
    .cta-btn {
        padding: 1rem 2rem;
    }
}

@media (max-width: 360px) {
    .page-header h1 {
        font-size: 1.75rem;
    }
    
    .contact-info h2,
    .contact-form h2,
    .contact-cta h2 {
        font-size: 1.5rem;
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

/* Print Styles */
@media print {
    body {
        background: white;
        color: black;
    }
    
    .desktop-sidebar {
        display: none;
    }
    
    .desktop-container {
        grid-template-columns: 1fr;
        min-width: 100%;
    }
    
    .contact-info,
    .contact-form,
    .contact-cta {
        border: 1px solid #000;
        box-shadow: none;
    }
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
                        <div class="text-2xl font-display">PROWORLDZ</div>
                        <div class="text-xs uppercase text-muted-foreground">Education Platform</div>
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
                            <a href="assignment.php" class="nav-item disabled">
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
                            <a href="#" class="nav-item">
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
                            <a href="#" class="nav-item">
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
                            <a href="#" class="nav-item">
                                <svg class="nav-icon" viewBox="0 0 640 512" fill="currentColor">
                                    <!-- Font Awesome Dragon (simpler) -->
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
            <h1>Contact ProWorldz</h1>
            <p>Let's connect and build your future in technology</p>
        </section>

        <!-- CONTACT CONTAINER -->
        <div class="contact-container">
            <!-- CONTACT INFO -->
            <div class="contact-info animate-fadeIn delay-1">
                <h2>Get in Touch</h2>
                <p>Have questions about our courses or platform? Send us a message and our team will reach out to you.</p>

                <div class="info-box animate-fadeIn delay-2">
                    <i class="fa-solid fa-envelope"></i>
                    <p>proworldz0311@gmail.com</p>
                </div>

                <div class="info-box animate-fadeIn delay-3">
                    <i class="fa-solid fa-phone"></i>
                    <p>+91 98765 43210</p>
                </div>

                <div class="info-box animate-fadeIn delay-4">
                    <i class="fa-solid fa-map-marker-alt"></i>
                    <p>India</p>
                </div>
            </div>

            <!-- CONTACT FORM -->
            <form class="contact-form animate-fadeIn delay-2" id="contactForm">
                <h2>Send Message</h2>
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" required placeholder="Enter your message here..."></textarea>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send Message
                </button>
            </form>
        </div>


        <!-- FOOTER -->
        <footer class="footer animate-fadeIn delay-4">
            <p>&copy; 2026 ProWorldz. All rights reserved.</p>
        </footer>
    </div>
</div>

<script>
// DOM Elements
const contactForm = document.getElementById('contactForm');
const submitBtn = document.getElementById('submitBtn');

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

// Add hover effects to info boxes
document.querySelectorAll('.info-box').forEach(box => {
    box.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(8px)';
    });
    
    box.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
    });
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
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
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
        
        // Add success animation
        submitBtn.style.animation = 'none';
        setTimeout(() => {
            submitBtn.style.animation = 'pulse 2s infinite';
        }, 10);
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

// Add hover effects to form inputs
document.querySelectorAll('.form-group input, .form-group textarea').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
        const label = this.parentElement.querySelector('label');
        if (label) {
            label.style.color = 'var(--primary)';
        }
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
        if (!this.value) {
            const label = this.parentElement.querySelector('label');
            if (label) {
                label.style.color = '';
            }
        }
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
});
</script>
</body>
</html>