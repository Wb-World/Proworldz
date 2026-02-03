<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programming Tasks | Proworldz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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

        @font-face {
            font-family: "Rebels";
            src: url("https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2") format("woff2");
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

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

        .desktop-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: var(--gap);
            min-height: 100vh;
            padding: var(--sides);
            background-color: var(--background);
        }

        .desktop-sidebar {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        .desktop-main {
            display: flex;
            flex-direction: column;
            gap: var(--gap);
        }

        .font-display {
            font-family: 'Rebels', 'Roboto Mono', monospace;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .hidden { display: none !important; }
        .block { display: block; }
        .flex { display: flex; }
        .grid { display: grid; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .overflow-hidden { overflow: hidden; }
        .overflow-y-auto { overflow-y: auto; }
        .rounded-lg { border-radius: var(--radius); }
        .rounded-md { border-radius: calc(var(--radius) - 2px); }
        .rounded-sm { border-radius: calc(var(--radius) - 4px); }
        .rounded-full { border-radius: 9999px; }
        .border { border-width: 1px; }
        .border-2 { border-width: 2px; }
        .border-b { border-bottom-width: 1px; }
        .border-t { border-top-width: 1px; }

        .bg-background { background-color: var(--background); }
        .bg-foreground { background-color: var(--foreground); }
        .bg-primary { background-color: var(--primary); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-muted { background-color: var(--muted); }
        .bg-accent { background-color: var(--accent); }
        .bg-card { background-color: var(--card); }
        .bg-success { background-color: var(--success); }
        .bg-warning { background-color: var(--warning); }
        .bg-destructive { background-color: var(--destructive); }
        .bg-sidebar { background-color: var(--sidebar); }
        .bg-sidebar-primary { background-color: var(--sidebar-primary); }
        .bg-sidebar-accent { background-color: var(--sidebar-accent); }

        .text-foreground { color: var(--foreground); }
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-secondary { color: var(--secondary); }
        .text-secondary-foreground { color: var(--secondary-foreground); }
        .text-muted { color: var(--muted); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .text-success { color: var(--success); }
        .text-warning { color: var(--warning); }
        .text-destructive { color: var(--destructive); }
        .text-sidebar-foreground { color: var(--sidebar-foreground); }
        .text-sidebar-primary { color: var(--sidebar-primary); }
        .text-sidebar-primary-foreground { color: var(--sidebar-primary-foreground); }

        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-base { font-size: 1rem; line-height: 1.5rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .text-5xl { font-size: 3rem; line-height: 1; }

        .font-normal { font-weight: 400; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }

        .uppercase { text-transform: uppercase; }
        .italic { font-style: italic; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .opacity-0 { opacity: 0; }
        .opacity-50 { opacity: 0.5; }
        .opacity-100 { opacity: 1; }

        .cursor-pointer { cursor: pointer; }
        .select-none { user-select: none; }

        .transition-all { transition: all 0.3s ease; }
        .transition-colors { transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease; }
        .transition-opacity { transition: opacity 0.3s ease; }
        .transition-transform { transition: transform 0.3s ease; }

        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-gap { gap: var(--gap); }

        .p-0 { padding: 0; }
        .p-1 { padding: 0.25rem; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }

        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-auto { margin-top: auto; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .ml-auto { margin-left: auto; }
        .mr-1 { margin-right: 0.25rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }

        .space-y-1 > * + * { margin-top: 0.25rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }

        .flex-1 { flex: 1 1 0%; }
        .flex-col { flex-direction: column; }
        .flex-row { flex-direction: row; }
        .items-start { align-items: flex-start; }
        .items-center { align-items: center; }
        .items-baseline { align-items: baseline; }
        .items-stretch { align-items: stretch; }
        .justify-start { justify-content: flex-start; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }

        .min-w-0 { min-width: 0; }
        .max-w-xs { max-width: 20rem; }
        .max-w-sm { max-width: 24rem; }
        .max-w-md { max-width: 28rem; }
        .max-w-max { max-width: max-content; }

        .w-14 { width: 3.5rem; }
        .w-16 { width: 4rem; }
        .w-56 { width: 14rem; }
        .w-80 { width: 20rem; }

        .h-5 { height: 1.25rem; }
        .h-6 { height: 1.5rem; }
        .h-7 { height: 1.75rem; }
        .h-8 { height: 2rem; }
        .h-10 { height: 2.5rem; }
        .h-12 { height: 3rem; }
        .h-14 { height: 3.5rem; }
        .h-32 { height: 8rem; }

        .size-3 { width: 0.75rem; height: 0.75rem; }
        .size-4 { width: 1rem; height: 1rem; }
        .size-5 { width: 1.25rem; height: 1.25rem; }
        .size-6 { width: 1.5rem; height: 1.5rem; }
        .size-7 { width: 1.75rem; height: 1.75rem; }
        .size-9 { width: 2.25rem; height: 2.25rem; }
        .size-10 { width: 2.5rem; height: 2.5rem; }
        .size-12 { width: 3rem; height: 3rem; }
        .size-14 { width: 3.5rem; height: 3.5rem; }
        .size-16 { width: 4rem; height: 4rem; }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card {
            background-color: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
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

        .badge-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
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

        .badge-outline-warning {
            background-color: transparent;
            color: var(--warning);
            border-color: var(--warning);
        }

        .badge-destructive {
            background-color: var(--destructive);
            color: white;
            border-color: var(--destructive);
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

        .button-outline {
            background-color: transparent;
            color: currentColor;
            border-color: currentColor;
        }

        .button-outline:hover:not(:disabled) {
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

        .button-icon {
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
        }

        .nav-section {
            margin-bottom: 1.5rem;
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

        .bullet {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background-color: var(--muted-foreground);
        }

        .bullet-success {
            background-color: var(--success);
        }

        .bullet-sm {
            width: 0.375rem;
            height: 0.375rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

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

        .task-card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            height: 20cap;
        }

        .task-card:hover {
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
        }

        .task-difficulty-easy {
            background-color: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .task-difficulty-medium {
            background-color: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .task-difficulty-hard {
            background-color: rgba(239, 68, 68, 0.15);
            color: var(--destructive);
        }

        .task-points {
            background: linear-gradient(45deg, var(--primary), var(--chart-2));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .task-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto;
        }

        .task-actions .button {
            flex: 1;
        }

        .completed-badge {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            padding: 0.75rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
        }
        
        .eagle-coins {
            /* background: linear-gradient(45deg, #f59e0b, #d97706); */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
        }
    </style>
</head>
<body>
    <div class="desktop-container">
        <div class="desktop-sidebar">
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
                    <div class="nav-section">
                        <div class="space-y-1" style="height: 45cap;">
                            <a href="dashboard.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M5.833 3.333h-2.5v13.334h2.5m8.333-13.334h2.5v13.334h-2.5"/>
                                </svg>
                                <span class="nav-label">Overview</span>
                            </a>
                            <a href="lab.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-width="1.667" d="M16.228 3.772c1.31 1.31-.416 5.16-3.856 8.6-3.44 3.44-7.29 5.167-8.6 3.856-1.31-1.31.415-5.16 3.855-8.6 3.44-3.44 7.29-5.167 8.6-3.856Z"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M16.228 16.228c-1.31 1.31-5.161-.416-8.601-3.855-3.44-3.44-5.166-7.29-3.856-8.601 1.31-1.31 5.162.416 8.601 3.855 3.44 3.44 5.166 7.29 3.856 8.601Z"/>
                                </svg>
                                <span class="nav-label">Laboratory</span>
                            </a>
                            <a href="ourcourse.php" class="nav-item">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                    <path stroke-width="1.5" d="M16.667 15V5.833a2.5 2.5 0 0 0-2.5-2.5H5.833a2.5 2.5 0 0 0-2.5 2.5v10a2.5 2.5 0 0 0 2.5 2.5h10"/>
                                    <path stroke-width="1.5" d="M6.667 3.333v13.334"/>
                                    <path stroke-width="1.5" d="M10 6.667h3.333"/>
                                    <path stroke-width="1.5" d="M10 10h3.333"/>
                                </svg>
                                <span class="nav-label">Courses</span>
                            </a>
                            <a href="assignment.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                    <path stroke-width="1.5" d="M16.667 16.667V5a2.5 2.5 0 0 0-2.5-2.5H6.667a2.5 2.5 0 0 0-2.5 2.5v11.667"/>
                                    <path stroke-width="1.5" d="M6.667 2.5v15"/>
                                    <path stroke-width="1.5" d="M11.667 4.167l4.166 4.166" stroke-linecap="round"/>
                                    <path stroke-width="1.5" d="M13.333 8.333l-2.5 2.5-2.5-2.5 2.5-2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="nav-label">Assignments</span>
                            </a>
                            <a href="tasks.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path stroke-width="1.5" d="M5 3.333h8.333a2.5 2.5 0 0 1 2.5 2.5v10a2.5 2.5 0 0 1-2.5 2.5H5V3.333z"/>
                                <path stroke-width="1.5" d="M13.333 3.333v13.334"/>
                                
                                <!-- Pen -->
                                <path stroke-width="1.5" d="M3.333 14.167l1.667-1.667" stroke-linecap="round"/>
                                <path stroke-width="1.5" d="M8.333 10l-3.333 3.333" stroke-linecap="round"/>
                                
                                <!-- Text lines -->
                                <path stroke-width="1.2" d="M8.333 7.5h3.334" stroke-linecap="round"/>
                                <path stroke-width="1.2" d="M8.333 9.167h5" stroke-linecap="round"/>
                                <path stroke-width="1.2" d="M8.333 10.833h4.167" stroke-linecap="round"/>
                            </svg>
                                <span class="nav-label">Tasks</span>
                            </a>
                            <a href="maintanance.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 4.164V2.497m3.333 1.67V2.5M6.667 4.167v-1.67M10 17.5v-1.667m3.333 1.667v-1.667M6.667 17.5v-1.667m9.166-2.5H17.5m-1.667-6.667H17.5M15.833 10H17.5m-15 0h1.667M2.5 13.334h1.667M2.5 6.666h1.667M12.5 10a2.501 2.501 0 1 1-5.002 0 2.501 2.501 0 0 1 5.002 0ZM4.167 4.167h11.666v11.666H4.167V4.167Z"/>
                                </svg>
                                <span class="nav-label">Devices</span>
                            </a>
                            <a href="leaderboard.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-width="1.667" d="M10 2.5l3.333 6.667H6.667L10 2.5z"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M3.333 10.833h13.334"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M5.833 13.333h8.334"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M7.5 15.833h5"/>
                                </svg>
                                <span class="nav-label">Leaderboard</span>
                            </a>
                            <a href="maintanance.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 3.333H4.166v7.5h11.667v-7.5H10Zm0 0V1.667m-6.667 12.5 1.25-1.25m12.083 1.25-1.25-1.25M7.5 6.667V7.5m5-.833V7.5M5 10.833V12.5a5 5 0 0 0 10 0v-1.667"/>
                                </svg>
                                <span class="nav-label">Security status</span>
                            </a>
                            <a href="contactus.php" class="nav-item disabled">
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
                                    <path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/>
                                </svg>
                                <span class="nav-label">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="desktop-main">
            <div class="card animate-fadeIn">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded bg-primary flex items-center justify-center">
                            <svg class="size-5 text-primary-foreground" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path stroke-width="1.5" d="M16.667 16.667V5a2.5 2.5 0 0 0-2.5-2.5H6.667a2.5 2.5 0 0 0-2.5 2.5v11.667"/>
                                <path stroke-width="1.5" d="M6.667 2.5v15"/>
                                <path stroke-width="1.5" d="M11.667 4.167l4.166 4.166" stroke-linecap="round"/>
                                <path stroke-width="1.5" d="M13.333 8.333l-2.5 2.5-2.5-2.5 2.5-2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-display">Programming Tasks</h1>
                            <div class="text-sm text-muted-foreground">Complete challenges to earn Eagle Points</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="card animate-fadeIn">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">Total Tasks</span>
                        </div>
                    </div>
                    <div class="bg-accent p-4">
                        <div class="flex items-center">
                            <span id="total-tasks" class="text-5xl font-display text-primary">0</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">AVAILABLE TASKS</p>
                        </div>
                    </div>
                </div>

                <div class="card animate-fadeIn" style="animation-delay: 0.1s">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet bullet-success"></div>
                            <span class="text-sm font-medium uppercase">Completed</span>
                        </div>
                    </div>
                    <div class="bg-accent p-4">
                        <div class="flex items-center">
                            <span id="completed-tasks" class="text-5xl font-display text-success">0</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">TASKS SOLVED</p>
                        </div>
                    </div>
                </div>

                <div class="card animate-fadeIn" style="animation-delay: 0.2s">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">Pendings</span>
                        </div>
                    </div>
                    <div class="bg-accent p-4">
                        <div class="flex items-center">
                            <span id="pendings" class="text-5xl font-display text-warning">0</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">Pending tasks</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="showall">

            </div>
        </div>
    </div>

<script>

function render_tasks(title, e_coins, description) {
    return `<div class="task-card animate-slideUp" style="animation-delay:0.2s">
        <div class="task-header">
            <div class="flex-1">
                <h3 class="text-lg font-semibold mb-2">${title}</h3>
            </div>
            <div style="display:inline-flex;align-items:center;gap:8px;background-color:#8B4513;color:white;padding:4px 12px;border-radius:20px;">
                <img src="images/coin.png" alt="coin" style="width:16px;height:16px;">
                <span style="font-weight:600;">${e_coins}</span>
            </div>
        </div>
        <p class="text-sm text-muted-foreground line-clamp-2">${description}</p>
        <div class="task-actions">
            <button class="button button-default button-md solve-btn" 
                    data-task="${encodeURIComponent(title)}"
                    data-coins="${e_coins}">
                Solve
            </button>
        </div>
    </div>`;
}

fetch('https://proworldz.page.gd/api/tasks.php',{method:'POST',headers:{'Content-Type':'application/json'}})
.then(info=>info.json())
.then(data=>{
    console.log(data.status)
    infos=data.status;
    let tasksArray=JSON.parse(infos['tasks']);
    let description=infos['description'];
    let completed=0;
    if(infos['completed']&&infos['completed']!=='null'){
        try{completed=JSON.parse(infos['completed']).length;}catch(e){completed=0;}
    }
    document.getElementById('total-tasks').textContent=parseInt(infos['total']);
    document.getElementById('completed-tasks').textContent=completed;
    document.getElementById('pendings').textContent=parseInt(infos['total'])-completed;
    const showallDiv=document.getElementById('showall');
    showallDiv.innerHTML='';
    showallDiv.style.display='grid';
    showallDiv.style.gridTemplateColumns='repeat(3,1fr)';
    showallDiv.style.gap='20px';
    showallDiv.style.justifyItems='center';
    tasksArray.forEach(taskTitle=>{
        const reward_ecoins = Math.floor(Math.random() * 6) + 1;
        showallDiv.innerHTML+=render_tasks(taskTitle,reward_ecoins,description);
    });
}).catch(err=>console.log(err));

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('solve-btn')) {
        const taskTitle = event.target.getAttribute('data-task');
        const taskCoins = event.target.getAttribute('data-coins');
        
        console.log("Task Name:", decodeURIComponent(taskTitle));
        console.log("Eagle Coins:", taskCoins);

        localStorage.setItem('tasksinfo',[decodeURIComponent(taskTitle),taskCoins])
        
        window.open('lab/pythoni.php','_blank');
    }
});
</script>
</body>
</html>