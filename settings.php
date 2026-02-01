<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - M.O.N.K.Y OS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            min-width: 1280px;
            overflow-x: auto;
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
            --primary-foreground: #ffffff;
            --secondary: #2d3748;
            --secondary-foreground: #f8fafc;
            --muted: #2d3748;
            --muted-foreground: #94a3b8;
            --accent: rgba(248, 250, 252, 0.05);
            --accent-foreground: #f8fafc;
            --border: rgba(255, 255, 255, 0.1);
            --pop: rgba(255, 255, 255, 0.025);
            --input: rgba(255, 255, 255, 0.15);
            --ring: rgba(148, 163, 184, 0.5);
            
            --success: #10b981;
            --destructive: #ef4444;
            --warning: #f59e0b;
            
            --chart-1: #6366f1;
            --chart-2: #10b981;
            --chart-3: #f59e0b;
            --chart-4: #8b5cf6;
            --chart-5: #ec4899;
            
            --sidebar: #1a1d24;
            --sidebar-foreground: #f8fafc;
            --sidebar-primary: #6366f1;
            --sidebar-primary-foreground: #ffffff;
            --sidebar-accent: rgba(248, 250, 252, 0.05);
            --sidebar-accent-foreground: #f8fafc;
            --sidebar-border: rgba(255, 255, 255, 0.1);
            --sidebar-ring: rgba(148, 163, 184, 0.5);
            
            --gap: 1.5rem;
            --sides: 1.5rem;
            --header-mobile: 3.8rem;
        }

        /* ===== DESKTOP-ONLY LAYOUT ===== */
        .desktop-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: var(--gap);
            min-height: 100vh;
            padding: var(--sides);
            background-color: var(--background);
        }

        /* Left Sidebar - Navigation */
        .desktop-sidebar {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        /* Main Content Area */
        .desktop-main {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        /* ===== TYPOGRAPHY ===== */
        .font-display {
            font-family: 'Rebels', 'Roboto Mono', monospace;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* ===== UTILITY CLASSES ===== */
        .hidden {
            display: none !important;
        }

        .flex {
            display: flex;
        }

        .grid {
            display: grid;
        }

        .relative {
            position: relative;
        }

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        .rounded-lg {
            border-radius: var(--radius);
        }

        .border {
            border-width: 1px;
        }

        .bg-background {
            background-color: var(--background);
        }

        .bg-card {
            background-color: var(--card);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        .text-foreground {
            color: var(--foreground);
        }

        .text-primary {
            color: var(--primary);
        }

        .text-muted-foreground {
            color: var(--muted-foreground);
        }

        .text-success {
            color: var(--success);
        }

        .text-destructive {
            color: var(--destructive);
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-base {
            font-size: 1rem;
            line-height: 1.5rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .transition-colors {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* ===== LAYOUT ===== */
        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .gap-gap {
            gap: var(--gap);
        }

        .p-2 {
            padding: 0.5rem;
        }

        .p-3 {
            padding: 0.75rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .p-6 {
            padding: 1.5rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-2 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .space-y-2 > * + * {
            margin-top: 0.5rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        .flex-1 {
            flex: 1 1 0%;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-start {
            align-items: flex-start;
        }

        .items-center {
            align-items: center;
        }

        .items-stretch {
            align-items: stretch;
        }

        .justify-start {
            justify-content: flex-start;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .h-10 {
            height: 2.5rem;
        }

        .h-12 {
            height: 3rem;
        }

        .h-14 {
            height: 3.5rem;
        }

        .h-32 {
            height: 8rem;
        }

        .size-12 {
            width: 3rem;
            height: 3rem;
        }

        .size-14 {
            width: 3.5rem;
            height: 3.5rem;
        }

        .size-32 {
            width: 8rem;
            height: 8rem;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .object-cover {
            object-fit: cover;
        }

        .object-contain {
            object-fit: contain;
        }

        /* ===== CUSTOM COMPONENT STYLES ===== */
        .card {
            background-color: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: calc(var(--radius) - 2px);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
            cursor: pointer;
            border: 1px solid transparent;
            user-select: none;
            white-space: nowrap;
        }

        .button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .button-default {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .button-default:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--primary) 90%, black);
        }

        .button-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
        }

        .button-secondary:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--secondary) 90%, black);
        }

        .button-ghost {
            background-color: transparent;
            color: currentColor;
        }

        .button-ghost:hover:not(:disabled) {
            background-color: var(--accent);
        }

        .button-sm {
            height: 2rem;
            padding: 0 0.75rem;
            font-size: 0.875rem;
        }

        .button-md {
            height: 2.5rem;
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        .button-lg {
            height: 3rem;
            padding: 0 1.5rem;
            font-size: 1rem;
        }

        .input {
            width: 100%;
            height: 2.5rem;
            padding: 0 0.75rem;
            background-color: var(--input);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            color: var(--foreground);
            font-family: inherit;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .input:focus {
            outline: none;
            border-color: var(--ring);
        }

        .input:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .input::placeholder {
            color: var(--muted-foreground);
            opacity: 0.7;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border: 1px solid transparent;
        }

        .badge-default {
            background-color: var(--primary);
            color: var(--primary-foreground);
            border-color: var(--primary);
        }

        .badge-outline {
            background-color: transparent;
            color: currentColor;
            border-color: currentColor;
        }

        .badge-outline-success {
            background-color: transparent;
            color: var(--success);
            border-color: var(--success);
        }

        .separator {
            width: 100%;
            height: 1px;
            background-color: var(--border);
        }

        .bullet {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background-color: var(--muted-foreground);
        }

        /* ===== SIDEBAR NAVIGATION STYLES ===== */
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

        .nav-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
        }

        .nav-title span {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--muted-foreground);
        }

        /* ===== PROFILE IMAGE UPLOAD ===== */
        .profile-image-upload {
            position: relative;
            width: 8rem;
            height: 8rem;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--primary);
            background-color: var(--secondary);
        }

        .profile-image-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-image-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .profile-image-upload:hover .profile-image-overlay {
            opacity: 1;
        }

        .profile-image-overlay span {
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        /* ===== LOADING STATES ===== */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--border);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== TOAST NOTIFICATIONS ===== */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 100;
            transform: translateY(100%);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success {
            border-left: 4px solid var(--success);
        }

        .toast.error {
            border-left: 4px solid var(--destructive);
        }

        .toast.warning {
            border-left: 4px solid var(--warning);
        }

        .toast-icon {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--muted);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--muted-foreground);
        }
    </style>
</head>
<body>
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
                            <div class="text-2xl font-display" id="sidebar-name">Loading...</div>
                            <div class="text-xs uppercase text-muted-foreground">Settings Dashboard</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Sections -->
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
                            <a href="#" class="nav-item disabled">
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
                            <a href="#" class="nav-item disabled">
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
                            <a href="#" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 640 512" fill="currentColor">
                                    <path d="M18.32 255.78L192 223.96l-91.28 68.69c-10.08 10.08-2.94 27.31 11.31 27.31h222.7c.94 0 1.78-.23 2.65-.29l-79.21 88.62c-9.85 11.03-2.16 28.11 12.58 28.11 6.34 0 12.27-3.59 15.99-9.26l79.21-88.62c.39.04.78.07 1.18.07h78.65c14.26 0 21.39-17.22 11.32-27.31l-79.2-88.62c.39-.04.78-.07 1.18-.07h78.65c14.26 0 21.39-17.22 11.32-27.31L307.33 9.37c-6.01-6.76-17.64-6.76-23.65 0l-265.38 246.4c-10.08 10.08-2.94 27.31 11.31 27.31h79.21c.39 0 .78-.03 1.17-.07L18.32 255.78z"/>
                                </svg>
                                <span class="nav-label">Dragon Tool</span>
                            </a>
                            <a href="settings.php" class="nav-item active">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 10.833a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M15.833 6.667v-.834a2.5 2.5 0 0 0-2.5-2.5h-6.666a2.5 2.5 0 0 0-2.5 2.5v.834m-2.5 0h18.332v7.5H2.5v-7.5Zm.833 9.166a2.5 2.5 0 0 0 2.5 2.5h10a2.5 2.5 0 0 0 2.5-2.5V14.167"/>
                                </svg>
                                <span class="nav-label">Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="desktop-main">
            <!-- Settings Header -->
            <div class="card animate-fadeIn">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded bg-primary flex items-center justify-center">
                            <svg class="size-5 text-primary-foreground" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 10.833a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M15.833 6.667v-.834a2.5 2.5 0 0 0-2.5-2.5h-6.666a2.5 2.5 0 0 0-2.5 2.5v.834m-2.5 0h18.332v7.5H2.5v-7.5Zm.833 9.166a2.5 2.5 0 0 0 2.5 2.5h10a2.5 2.5 0 0 0 2.5-2.5V14.167"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-display">Settings</h1>
                            <div class="text-sm text-muted-foreground">Manage your profile and preferences</div>
                        </div>
                    </div>
                    <button id="save-button" class="button button-default button-lg hidden">
                        <span id="save-text">Save Changes</span>
                        <span id="save-loader" class="hidden">Saving...</span>
                    </button>
                </div>
            </div>

            <!-- Profile Settings -->
            <div class="card animate-slideUp" style="animation-delay: 0.1s">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bullet"></div>
                        <span class="text-sm font-medium uppercase">PROFILE INFORMATION</span>
                    </div>
                    <span class="badge badge-outline-success" id="status-badge">ACTIVE</span>
                </div>
                <div class="bg-accent p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Form Fields -->
                        <div class="space-y-6">
                            <!-- ID Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium uppercase text-muted-foreground">ID</label>
                                <input type="text" id="user-id" class="input" disabled>
                                <div class="flex items-center gap-2">
                                    <div class="size-3 rounded-full bg-muted-foreground"></div>
                                    <p class="text-xs text-muted-foreground">Immutable identifier</p>
                                </div>
                            </div>

                            <!-- Name Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium uppercase text-muted-foreground">NAME</label>
                                <input type="text" id="user-name" class="input" placeholder="Enter your full name">
                                <div class="flex items-center gap-2">
                                    <div class="size-3 rounded-full bg-primary"></div>
                                    <p class="text-xs text-muted-foreground">Editable field - Changes will be saved</p>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium uppercase text-muted-foreground">EMAIL</label>
                                <input type="email" id="user-email" class="input" disabled>
                                <div class="flex items-center gap-2">
                                    <div class="size-3 rounded-full bg-muted-foreground"></div>
                                    <p class="text-xs text-muted-foreground">Contact support to change email</p>
                                </div>
                            </div>

                            <!-- Gender Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium uppercase text-muted-foreground">GENDER</label>
                                <input type="text" id="user-gender" class="input" disabled>
                                <div class="flex items-center gap-2">
                                    <div class="size-3 rounded-full bg-muted-foreground"></div>
                                    <p class="text-xs text-muted-foreground">System-defined parameter</p>
                                </div>
                            </div>

                            <!-- Phone Field -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium uppercase text-muted-foreground">PHONE</label>
                                <input type="tel" id="user-phone" class="input" disabled>
                                <div class="flex items-center gap-2">
                                    <div class="size-3 rounded-full bg-muted-foreground"></div>
                                    <p class="text-xs text-muted-foreground">Administrator modification required</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Info -->
            <div class="card animate-slideUp" style="animation-delay: 0.2s">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bullet"></div>
                        <span class="text-sm font-medium uppercase">SESSION INFORMATION</span>
                    </div>
                    <span class="badge badge-outline">LIVE</span>
                </div>
                <div class="bg-accent p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- IP Address -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase text-muted-foreground">IP ADDRESS</label>
                            <input type="text" id="user-ip" class="input" disabled>
                            <p class="text-xs text-muted-foreground">Current session IP</p>
                        </div>

                        <!-- Last Active -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase text-muted-foreground">LAST ACTIVE</label>
                            <input type="text" id="last-active" class="input" value="Just now" disabled>
                            <p class="text-xs text-muted-foreground">Real-time tracking</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card animate-slideUp" style="animation-delay: 0.3s">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bullet"></div>
                        <span class="text-sm font-medium uppercase">SYSTEM STATUS</span>
                    </div>
                    <span class="badge badge-outline-success">OPERATIONAL</span>
                </div>
                <div class="bg-accent p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm">API Connection</span>
                            <span class="badge badge-outline-success" id="api-status">CONNECTED</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Database Status</span>
                            <span class="badge badge-outline-success" id="db-status">ONLINE</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm">Profile Sync</span>
                            <span class="badge badge-outline-success" id="sync-status">SYNCED</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <svg class="toast-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span id="toast-message"></span>
    </div>

    <script>
        class SettingsManager {
            constructor() {
                this.userId = null;
                this.originalData = {};
                this.hasChanges = false;
                this.isSaving = false;
                this.sessionInterval = null;
                this.init();
            }

            async init() {
                // Get user ID from session or default
                this.userId = this.getUserId();
                
                // Show loading state
                this.showLoading(true);
                
                // Load user data
                await this.loadUserData();
                
                // Setup event listeners
                this.setupEventListeners();
                
                // Setup session timer
                this.setupSessionTimer();
                
                // Check for changes periodically
                this.setupChangeDetection();
                
                // Hide loading
                this.showLoading(false);
            }

            getUserId() {
                // Try to get from URL parameter
                const urlParams = new URLSearchParams(window.location.search);
                const urlId = urlParams.get('id');
                
                // Try to get from localStorage
                const localStorageId = localStorage.getItem('user_id');
                
                // Try to get from sessionStorage
                const sessionId = sessionStorage.getItem('user_id');
                
                // Use in order of priority: URL > localStorage > sessionStorage > default
                return urlId || localStorageId || sessionId || 'STUDENT001';
            }

            showLoading(isLoading) {
                const saveButton = document.getElementById('save-button');
                const saveText = document.getElementById('save-text');
                const saveLoader = document.getElementById('save-loader');
                
                if (isLoading) {
                    saveButton.disabled = true;
                    saveText.classList.add('hidden');
                    saveLoader.classList.remove('hidden');
                } else {
                    saveButton.disabled = false;
                    saveText.classList.remove('hidden');
                    saveLoader.classList.add('hidden');
                }
            }

            async loadUserData() {
                try {
                    const response = await fetch(`api/settings.php?action=get&id=${this.userId}`, {
                        headers: {
                            'Cache-Control': 'no-cache',
                            'Pragma': 'no-cache'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        this.populateForm(data.user);
                        this.originalData = { ...data.user };
                        this.updateSystemStatus('success', 'Data loaded successfully');
                        this.updateSidebarName(data.user.name);
                    } else {
                        this.showToast(data.message || 'Failed to load user data', 'error');
                        this.updateSystemStatus('error', 'Data load failed');
                        // Fallback to demo data
                        this.useDemoData();
                    }
                } catch (error) {
                    // console.error('Error loading user data:', error);
                    this.showToast('Connection error. Using offline data.', 'warning');
                    this.updateSystemStatus('warning', 'Offline mode');
                    // Use demo data as fallback
                    this.useDemoData();
                }
            }

            useDemoData() {
                const demoData = {
                    id: this.userId,
                    name: 'Mohamed Paranthe',
                    email: 'mohamed@example.com',
                    gender: 'Male',
                    phone: '+1 (555) 123-4567',
                    IPADDR: '192.168.1.' + Math.floor(Math.random() * 255),
                    eagle_coins: '1250',
                    assignments: '49',
                    course: 'Computer Science'
                };
                
                this.populateForm(demoData);
                this.originalData = { ...demoData };
                this.updateSidebarName(demoData.name);
            }

            populateForm(userData) {
                // Populate form fields
                document.getElementById('user-id').value = userData.id || '';
                document.getElementById('user-name').value = userData.name || '';
                document.getElementById('user-email').value = userData.email || '';
                document.getElementById('user-gender').value = userData.gender || '';
                document.getElementById('user-phone').value = userData.phone || '';
                document.getElementById('user-ip').value = userData.IPADDR || '';
                
                // Update sidebar name
                this.updateSidebarName(userData.name);
            }

            updateSidebarName(name) {
                const sidebarName = document.getElementById('sidebar-name');
                if (sidebarName && name) {
                    sidebarName.textContent = name.split(' ')[0] || 'User';
                }
            }

            setupEventListeners() {
                // Name input change detection
                const nameInput = document.getElementById('user-name');
                nameInput.addEventListener('input', () => {
                    this.checkForChanges();
                });

                // Save button
                const saveButton = document.getElementById('save-button');
                saveButton.addEventListener('click', () => {
                    this.saveChanges();
                });

                // Auto-save on Enter key in name field
                nameInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && this.hasChanges) {
                        this.saveChanges();
                    }
                });
            }

            setupSessionTimer() {
                // Update last active time
                this.updateLastActive();
                
                // Update every minute
                this.sessionInterval = setInterval(() => {
                    this.updateLastActive();
                }, 60000);
            }

            updateLastActive() {
                const lastActive = document.getElementById('last-active');
                if (lastActive) {
                    lastActive.value = 'Just now';
                }
            }

            setupChangeDetection() {
                // Check for changes every second
                setInterval(() => {
                    this.checkForChanges();
                }, 1000);
            }

            checkForChanges() {
                if (this.isSaving) return;
                
                const currentName = document.getElementById('user-name').value;
                const hasNameChanged = currentName !== this.originalData.name;
                
                const saveButton = document.getElementById('save-button');
                
                if (hasNameChanged && currentName.trim() !== '') {
                    this.hasChanges = true;
                    saveButton.classList.remove('hidden');
                } else {
                    this.hasChanges = false;
                    saveButton.classList.add('hidden');
                }
            }

            async saveChanges() {
                if (this.isSaving || !this.hasChanges) return;
                
                const name = document.getElementById('user-name').value.trim();
                
                if (!name) {
                    this.showToast('Name cannot be empty', 'error');
                    return;
                }
                
                this.isSaving = true;
                this.showLoading(true);
                
                try {
                    const response = await fetch('api/settings.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'update',
                            id: this.userId,
                            name: name
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        // Update original data
                        this.originalData.name = name;
                        
                        // Update sidebar name
                        this.updateSidebarName(name);
                        
                        // Hide save button
                        document.getElementById('save-button').classList.add('hidden');
                        this.hasChanges = false;
                        
                        this.showToast('Profile updated successfully', 'success');
                        this.updateSystemStatus('success', 'Changes saved');
                    } else {
                        this.showToast(data.message || 'Failed to update profile', 'error');
                        this.updateSystemStatus('error', 'Save failed');
                    }
                } catch (error) {
                    // console.error('Error saving changes:', error);
                    this.showToast('Network error. Changes saved locally.', 'warning');
                    this.updateSystemStatus('warning', 'Local save only');
                    
                    // Still update locally for better UX
                    this.originalData.name = name;
                    this.updateSidebarName(name);
                    document.getElementById('save-button').classList.add('hidden');
                    this.hasChanges = false;
                } finally {
                    this.isSaving = false;
                    this.showLoading(false);
                }
            }

            updateSystemStatus(type, message) {
                const apiStatus = document.getElementById('api-status');
                const dbStatus = document.getElementById('db-status');
                const syncStatus = document.getElementById('sync-status');
                
                if (type === 'success') {
                    apiStatus.textContent = 'CONNECTED';
                    apiStatus.className = 'badge badge-outline-success';
                    dbStatus.textContent = 'ONLINE';
                    dbStatus.className = 'badge badge-outline-success';
                    syncStatus.textContent = 'SYNCED';
                    syncStatus.className = 'badge badge-outline-success';
                } else if (type === 'error') {
                    apiStatus.textContent = 'DISCONNECTED';
                    apiStatus.className = 'badge badge-outline';
                    dbStatus.textContent = 'OFFLINE';
                    dbStatus.className = 'badge badge-outline';
                    syncStatus.textContent = 'UNSYNCED';
                    syncStatus.className = 'badge badge-outline';
                } else if (type === 'warning') {
                    apiStatus.textContent = 'LIMITED';
                    apiStatus.className = 'badge badge-outline-warning';
                    dbStatus.textContent = 'LIMITED';
                    dbStatus.className = 'badge badge-outline-warning';
                    syncStatus.textContent = 'PENDING';
                    syncStatus.className = 'badge badge-outline-warning';
                }
                
                // console.log(`System Status: ${message}`);
            }

            showToast(message, type = 'success') {
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toast-message');
                const toastIcon = toast.querySelector('.toast-icon');
                
                // Set message
                toastMessage.textContent = message;
                
                // Set type and icon
                toast.className = `toast ${type}`;
                
                if (type === 'success') {
                    toastIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
                } else if (type === 'error') {
                    toastIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                } else if (type === 'warning') {
                    toastIcon.innerHTML = '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>';
                }
                
                // Show toast
                toast.classList.add('show');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        // Initialize settings manager when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            // Add some visual effects on load
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
                window.settingsManager = new SettingsManager();
            }, 100);
            
            // Handle beforeunload to warn about unsaved changes
            window.addEventListener('beforeunload', (e) => {
                if (window.settingsManager && window.settingsManager.hasChanges) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                    return e.returnValue;
                }
            });
        });
    </script>
</body>
</html>