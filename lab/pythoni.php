<?php
session_start();
// if(!isset($_SESSION['current-student'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Interpreter - ProWorldz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/pyodide/v0.24.1/full/pyodide.js"></script>
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
            --input: rgba(255, 255, 255, 0.15);
            --ring: rgba(148, 163, 184, 0.5);
            
            --success: #10b981;
            --destructive: #ef4444;
            --warning: #f59e0b;
            
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
        .flex {
            display: flex;
        }

        .grid {
            display: grid;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
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

        .rounded-md {
            border-radius: calc(var(--radius) - 2px);
        }

        .border {
            border-width: 1px;
        }

        .border-2 {
            border-width: 2px;
        }

        .bg-card {
            background-color: var(--card);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-secondary {
            background-color: var(--secondary);
        }

        .text-foreground {
            color: var(--foreground);
        }

        .text-primary {
            color: var(--primary);
        }

        .text-primary-foreground {
            color: var(--primary-foreground);
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

        .text-center {
            text-align: center;
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

        /* ===== LAYOUT GRID ===== */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

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

        .gap-8 {
            gap: 2rem;
        }

        .gap-gap {
            gap: var(--gap);
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
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
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

        .pt-4 {
            padding-top: 1rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
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

        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .flex-1 {
            flex: 1 1 0%;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .items-start {
            align-items: flex-start;
        }

        .justify-center {
            justify-content: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .size-10 {
            width: 2.5rem;
            height: 2.5rem;
        }

        .size-12 {
            width: 3rem;
            height: 3rem;
        }

        .size-16 {
            width: 4rem;
            height: 4rem;
        }

        /* ===== CUSTOM COMPONENT STYLES ===== */
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

        .button-default {
            background-color: var(--primary);
            color: var(--primary-foreground);
        }

        .button-default:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--primary) 90%, black);
            transform: translateY(-2px);
        }

        .button-secondary {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
            border-color: var(--border);
        }

        .button-secondary:hover:not(:disabled) {
            background-color: color-mix(in srgb, var(--secondary) 90%, black);
            transform: translateY(-2px);
        }

        .button-ghost {
            background-color: transparent;
            color: currentColor;
        }

        .button-ghost:hover:not(:disabled) {
            background-color: var(--accent);
        }

        .button-lg {
            height: 3rem;
            padding: 0 1.5rem;
            font-size: 1rem;
        }

        .button-xl {
            height: 3.5rem;
            padding: 0 2rem;
            font-size: 1rem;
        }

        /* ===== SIDEBAR NAVIGATION STYLES ===== */
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

        /* ===== ANIMATIONS ===== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
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

        /* ===== PYTHON INTERPRETER SPECIFIC STYLES ===== */
        .interpreter-header {
            background: linear-gradient(135deg, var(--card) 0%, rgba(13, 16, 21, 0.9) 100%);
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .interpreter-hero {
            padding: 2rem;
        }

        .interpreter-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .interpreter-hero p {
            font-size: 1.1rem;
            color: var(--muted-foreground);
        }

        .interpreter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            height: 600px;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .interpreter-grid {
                grid-template-columns: 1fr;
                height: auto;
                min-height: 800px;
            }
        }

        .editor-section, .output-section {
            background: linear-gradient(135deg, var(--card) 0%, rgba(26, 29, 36, 0.8) 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .editor-section::before, .output-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary), #8b5cf6);
        }

        .editor-section:hover, .output-section:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.2);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .section-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--foreground);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header h3 i {
            color: var(--primary);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
        }

        .status-dot.loading {
            background: var(--warning);
            animation: pulse 1.5s infinite;
        }

        .status-dot.error {
            background: var(--destructive);
        }

        .code-editor-container {
            flex: 1;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            overflow: hidden;
            position: relative;
        }

        #code {
            width: 100%;
            height: 100%;
            padding: 1.5rem;
            font-family: 'Roboto Mono', monospace;
            font-size: 14px;
            line-height: 1.6;
            color: var(--foreground);
            background: transparent;
            border: none;
            outline: none;
            resize: none;
            white-space: pre;
            tab-size: 4;
        }

        #code::-webkit-scrollbar {
            width: 8px;
        }

        #code::-webkit-scrollbar-track {
            background: transparent;
        }

        #code::-webkit-scrollbar-thumb {
            background: var(--muted);
            border-radius: 4px;
        }

        #code::-webkit-scrollbar-thumb:hover {
            background: var(--muted-foreground);
        }

        .output-display {
            flex: 1;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            padding: 1.5rem;
            font-family: 'Roboto Mono', monospace;
            font-size: 14px;
            line-height: 1.6;
            color: var(--foreground);
            white-space: pre-wrap;
            word-break: break-word;
            overflow-y: auto;
        }

        .output-display::-webkit-scrollbar {
            width: 8px;
        }

        .output-display::-webkit-scrollbar-track {
            background: transparent;
        }

        .output-display::-webkit-scrollbar-thumb {
            background: var(--muted);
            border-radius: 4px;
        }

        .output-display::-webkit-scrollbar-thumb:hover {
            background: var(--muted-foreground);
        }

        .output-success {
            color: var(--success);
        }

        .output-error {
            color: var(--destructive);
        }

        .output-info {
            color: var(--primary);
        }

        .controls-section {
            background: linear-gradient(135deg, var(--card) 0%, rgba(26, 29, 36, 0.8) 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .controls-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, #8b5cf6, var(--primary));
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .shortcut-hint {
            margin-top: 1.5rem;
            padding: 1rem;
            background: rgba(99, 102, 241, 0.1);
            border-left: 4px solid var(--primary);
            border-radius: 0 calc(var(--radius) - 2px) calc(var(--radius) - 2px) 0;
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .shortcut-hint i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .shortcut-hint kbd {
            background: var(--secondary);
            padding: 0.25rem 0.5rem;
            border-radius: calc(var(--radius) - 4px);
            font-family: 'Roboto Mono', monospace;
            font-size: 0.875rem;
            border: 1px solid var(--border);
            color: var(--foreground);
        }

        .notification-btn {
            position: relative;
            width: 48px;
            height: 48px;
            border-radius: calc(var(--radius) - 2px);
            background: var(--accent);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .notification-btn:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--destructive);
            color: white;
            font-size: 0.75rem;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        .header-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .profile-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 1.1rem;
        }

        .profile-info h4 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
            color: var(--foreground);
        }

        .profile-info p {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--secondary);
            color: var(--secondary-foreground);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: color-mix(in srgb, var(--secondary) 90%, black);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .desktop-container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .desktop-sidebar {
                display: none;
            }

            .interpreter-hero h1 {
                font-size: 2rem;
            }

            .interpreter-hero p {
                font-size: 1rem;
            }

            .interpreter-grid {
                height: auto;
                min-height: 600px;
            }

            .editor-section, .output-section {
                padding: 1rem;
            }

            .controls-grid {
                grid-template-columns: 1fr;
            }
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
                            <div class="text-2xl font-display">ProWorldz</div>
                            <div class="text-xs uppercase text-muted-foreground">Python Interpreter</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Sections -->
            <div class="card">
                <div class="p-3">
                    <div class="nav-section">
                        <div class="space-y-2">
                            <a href="../dashboard.php" class="nav-item">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M5.833 3.333h-2.5v13.334h2.5m8.333-13.334h2.5v13.334h-2.5"/>
                                </svg>
                                <span class="nav-label">Dashboard</span>
                            </a>
                            <a href="../ourcourse.php" class="nav-item">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 4.164V2.497m3.333 1.67V2.5M6.667 4.167v-1.67M10 17.5v-1.667m3.333 1.667v-1.667M6.667 17.5v-1.667m9.166-2.5H17.5m-1.667-6.667H17.5M15.833 10H17.5m-15 0h1.667M2.5 13.334h1.667M2.5 6.666h1.667M12.5 10a2.501 2.501 0 1 1-5.002 0 2.501 2.501 0 0 1 5.002 0ZM4.167 4.167h11.666v11.666H4.167V4.167Z"/>
                                </svg>
                                <span class="nav-label">Courses</span>
                            </a>
                            <a href="../lab.php" class="nav-item">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 6.559 6.166 8.16l-.22 3.536 1.76 1.587.346 1.729L10 15.42l1.949-.408.345-1.729 1.76-1.587-.22-3.536L10 6.56Zm0-4.039 1.556 1.791 2.326-.691-.833 1.996 2.703 1.131A3.055 3.055 0 0 1 18.8 9.811c0 1.666-1.32 3.018-2.954 3.065l-1.681 1.461-.503 2.42L10 17.48l-3.661-.723-.503-2.42-1.682-1.461C2.52 12.829 1.2 11.477 1.2 9.81A3.055 3.055 0 0 1 4.25 6.747l2.703-1.131-.833-1.996 2.325.691L10 2.52Zm-.597 7.04c0 .754-.566 1.383-1.336 1.383-.785 0-1.367-.629-1.367-1.383h2.703Zm-.597 2.451h2.389L10 13.913 8.806 12.01ZM13.3 9.56c0 .754-.581 1.383-1.367 1.383-.77 0-1.336-.629-1.336-1.383H13.3Zm-10.198.251c0 .519.361.959.832 1.085l.173-2.2A1.111 1.111 0 0 0 3.102 9.81Zm12.964 1.085c.471-.126.833-.566.833-1.085 0-.581-.44-1.052-1.006-1.115l.173 2.2Z"/>
                                </svg>
                                <span class="nav-label">Laboratory</span>
                            </a>
                            <a href="../leaderboard.php" class="nav-item">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path stroke="currentColor" stroke-width="1.667" d="M10 2.5l3.333 6.667H6.667L10 2.5z"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M3.333 10.833h13.334"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M5.833 13.333h8.334"/>
                                    <path stroke="currentColor" stroke-width="1.667" d="M7.5 15.833h5"/>
                                </svg>
                                <span class="nav-label">Leaderboard</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="desktop-main">
            <!-- Python Interpreter Header -->
            <div class="card interpreter-header">
                <div class="interpreter-hero">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="font-display">Python Interpreter</h1>
                            <p>Write, run, and debug Python code in your browser</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="../lab.php" class="back-btn">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Lab</span>
                            </a>
                            <div class="header-profile">
                                <div class="profile-avatar">
                                    <?= isset($_SESSION['current-student']) ? htmlspecialchars(substr($_SESSION['current-student'], 0, 1)) : 'U' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Interpreter Grid -->
            <div class="interpreter-grid">
                <!-- Code Editor -->
                <div class="editor-section">
                    <div class="section-header">
                        <h3><i class="fas fa-code"></i> Code Editor</h3>
                        <div class="status-indicator">
                            <div class="status-dot" id="statusDot"></div>
                            <span id="statusText">Loading Python...</span>
                        </div>
                    </div>
                    <div class="code-editor-container">
                        <textarea id="code" placeholder="# Write Python code here...
# Press Ctrl+Enter to run
# Press Tab for indentation

print(&quot;Welcome to Python Interpreter!&quot;)

def greet(name):
    return f&quot;Hello, {name}!&quot;

# Example usage
result = greet(&quot;ProWorldz&quot;)
print(result)">print("hello bro")
print("Welcome to ProWorldz Python Interpreter")
import math

def calculate_circle_area(radius):
    return math.pi * radius * radius

if __name__ == "__main__":
    r = 5
    area = calculate_circle_area(r)
    print(f"Area of circle with radius {r} is {area:.2f}")</textarea>
                    </div>
                    <div class="shortcut-hint">
                        <i class="fas fa-keyboard"></i>
                        <strong>Pro Tip:</strong> Press <kbd>Ctrl</kbd> + <kbd>Enter</kbd> to run your code • <kbd>Tab</kbd> for indentation • <kbd>Shift</kbd> + <kbd>Tab</kbd> for outdent
                    </div>
                </div>

                <!-- Output Console -->
                <div class="output-section">
                    <div class="section-header">
                        <h3><i class="fas fa-terminal"></i> Output Console</h3>
                        <div class="status-indicator">
                            <span>Execution Results</span>
                        </div>
                    </div>
                    <pre id="output" class="output-display">Initializing Python interpreter...</pre>
                </div>
            </div>

            <!-- Controls Section -->
            <div class="controls-section">
                <div class="controls-grid">
                    <button onclick="runPython()" class="button button-lg button-default" id="runBtn">
                        <i class="fas fa-play"></i> Run Python Code
                    </button>
                    <button onclick="clearCode()" class="button button-lg button-secondary">
                        <i class="fas fa-eraser"></i> Clear Code
                    </button>
                    <button onclick="resetInterpreter()" class="button button-lg button-ghost">
                        <i class="fas fa-redo"></i> Reset Interpreter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pyodide = null;
        let isInitialized = false;
        let codeTextarea = null;

        async function initializePyodide() {
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            const runBtn = document.getElementById('runBtn');
            const output = document.getElementById('output');

            try {
                statusDot.className = 'status-dot loading';
                statusText.textContent = 'Loading Python...';
                runBtn.disabled = true;
                output.textContent = 'Loading Python interpreter (Pyodide v0.24.1)...';

                pyodide = await loadPyodide();
                isInitialized = true;
                
                statusDot.className = 'status-dot';
                statusText.textContent = 'Python Ready';
                runBtn.disabled = false;
                output.innerHTML = '<span class="output-success">✓ Python interpreter initialized successfully!</span>\n\n<span class="output-info">You can now write and execute Python code.</span>\n<span class="output-info">Try the example code or write your own.</span>';
                
            } catch (error) {
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Load Failed';
                output.innerHTML = '<span class="output-error">✗ Failed to load Python interpreter.</span>\n\nPlease check your internet connection and try refreshing the page.';
                console.error('Pyodide load error:', error);
            }
        }

        function setupEditor() {
            codeTextarea = document.getElementById('code');
            
            if (!codeTextarea) return;
            
            codeTextarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    
                    this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
                    this.selectionStart = this.selectionEnd = start + 4;
                }
                
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    runPython();
                }
                
                if (e.shiftKey && e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const before = this.value.substring(0, start);
                    
                    if (before.endsWith('    ')) {
                        this.value = this.value.substring(0, start - 4) + this.value.substring(start);
                        this.selectionStart = this.selectionEnd = start - 4;
                    }
                }
            });
        }

        async function runPython() {
            if (!pyodide || !isInitialized) {
                document.getElementById('output').innerHTML = '<span class="output-error">Python interpreter is still loading. Please wait...</span>';
                return;
            }

            const code = codeTextarea.value;
            const output = document.getElementById('output');
            const runBtn = document.getElementById('runBtn');
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');

            runBtn.disabled = true;
            runBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Running...';
            statusDot.className = 'status-dot loading';
            statusText.textContent = 'Executing Code';

            const wrappedCode = `
import sys
from io import StringIO
import traceback

_stdout = sys.stdout
sys.stdout = StringIO()

try:
${code.split("\n").map(l => "    " + l).join("\n")}
    result = sys.stdout.getvalue()
except Exception as e:
    result = f"Error: {str(e)}\\n\\nTraceback:\\n{''.join(traceback.format_exception(type(e), e, e.__traceback__))}"

sys.stdout = _stdout
result
`;

            try {
                const result = await pyodide.runPythonAsync(wrappedCode);
                
                if (result && result.startsWith('Error:')) {
                    output.innerHTML = `<span class="output-error">${escapeHtml(result)}</span>`;
                    statusDot.className = 'status-dot error';
                    statusText.textContent = 'Execution Error';
                } else if (result && result.trim() !== '') {
                    output.textContent = result;
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Execution Complete';
                } else {
                    output.innerHTML = '<span class="output-info">Code executed successfully (no output).</span>';
                    statusDot.className = 'status-dot';
                    statusText.textContent = 'Execution Complete';
                }
            } catch (err) {
                output.innerHTML = `<span class="output-error">Fatal Error: ${escapeHtml(err.toString())}</span>`;
                statusDot.className = 'status-dot error';
                statusText.textContent = 'Fatal Error';
            } finally {
                runBtn.disabled = false;
                runBtn.innerHTML = '<i class="fas fa-play"></i> Run Python Code';
            }
        }

        function clearCode() {
            if (codeTextarea) {
                codeTextarea.value = '';
            }
            document.getElementById('output').innerHTML = '<span class="output-info">Code editor cleared. Write your Python code above.</span>';
        }

        async function resetInterpreter() {
            const output = document.getElementById('output');
            output.innerHTML = '<span class="output-info">Resetting Python interpreter...</span>';
            isInitialized = false;
            await initializePyodide();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        const notificationBtn = document.getElementById('notificationBtn');
        notificationBtn.addEventListener('click', function() {
            const badge = this.querySelector('.notification-badge');
            badge.style.display = 'none';
            alert('You have 3 notifications:\n1. Assignment due tomorrow\n2. New grade posted\n3. Class schedule updated');
        });

        document.addEventListener('DOMContentLoaded', function() {
            setupEditor();
            initializePyodide();
        });
    </script>
</body>
</html>