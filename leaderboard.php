<?php
session_start();
if(!isset($_SESSION['id'])) header("Location: login.php");

require_once 'api/dbconf.php'; // Include the DBconfig class

$userId = $_SESSION['id'];
$db = new DBconfig();

// Fetch current user details
$userName = $db->getNamebyId($userId);
$userCoins = $db->getEagleCoinsbyId($userId) ?? 0;

// Fetch all users with their eagle coins
$allUsersData = $db->getAllUsersData(['id', 'name', 'eagle_coins']);

// Sort users by eagle coins (descending)
usort($allUsersData, function($a, $b) {
    return ($b['eagle_coins'] ?? 0) - ($a['eagle_coins'] ?? 0);
});

// Find current user's rank
$userRank = 0;
foreach ($allUsersData as $index => $user) {
    if ($user['id'] == $userId) {
        $userRank = $index + 1;
        break;
    }
}

// Store data in JavaScript accessible format
$allUsersJSON = json_encode($allUsersData);
$currentUserId = $userId;
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard | Proworldz</title>
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

        /* Utility Classes */
        .flex { display: flex; }
        .grid { display: grid; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .size-12 { width: 3rem; height: 3rem; }
        .size-16 { width: 4rem; height: 4rem; }
        .size-20 { width: 5rem; height: 5rem; }
        .size-8 { width: 2rem; height: 2rem; }
        .size-9 { width: 2.25rem; height: 2.25rem; }
        .size-10 { width: 2.5rem; height: 2.5rem; }
        .size-5 { width: 1.25rem; height: 1.25rem; }
        .size-4 { width: 1rem; height: 1rem; }
        .object-cover { object-fit: cover; }
        .object-contain { object-fit: contain; }
        .rounded-lg { border-radius: var(--radius); }
        .rounded-full { border-radius: 9999px; }
        .rounded { border-radius: 0.375rem; }
        .overflow-hidden { overflow: hidden; }
        .bg-primary { background-color: var(--primary); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-card { background-color: var(--card); }
        .bg-accent { background-color: var(--accent); }
        .bg-background { background-color: var(--background); }
        .text-primary { color: var(--primary); }
        .text-secondary { color: var(--secondary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-secondary-foreground { color: var(--secondary-foreground); }
        .text-success { color: var(--success); }
        .text-destructive { color: var(--destructive); }
        .text-foreground { color: var(--foreground); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-base { font-size: 1rem; line-height: 1.5rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .text-5xl { font-size: 3rem; line-height: 1; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .uppercase { text-transform: uppercase; }
        .opacity-50 { opacity: 0.5; }
        .opacity-0 { opacity: 0; }
        .border { border-width: 1px; border-style: solid; border-color: var(--border); }
        .border-2 { border-width: 2px; border-style: solid; }
        .border-border { border-color: var(--border); }
        .border-primary { border-color: var(--primary); }
        .border-secondary { border-color: var(--secondary); }
        .border-current { border-color: currentColor; }
        .border-b { border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: var(--border); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-gap { gap: var(--gap); }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .pt-4 { padding-top: 1rem; }
        .pt-6 { padding-top: 1.5rem; }
        .pl-2 { padding-left: 0.5rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .ml-auto { margin-left: auto; }
        .mr-2 { margin-right: 0.5rem; }
        .space-y-1 > * + * { margin-top: 0.25rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .flex-1 { flex: 1 1 0%; }
        .flex-col { flex-direction: column; }
        .items-start { align-items: flex-start; }
        .items-center { align-items: center; }
        .items-baseline { align-items: baseline; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .text-center { text-align: center; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .top-0 { top: 0; }
        .bottom-4 { bottom: 1rem; }
        .right-4 { right: 1rem; }
        .left-1\/2 { left: 50%; }
        .-top-3 { top: -0.75rem; }
        .transform { transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
        .-translate-x-1\/2 { --tw-translate-x: -50%; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
        .transition-colors { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
        .transition-opacity { transition-property: opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
        .group:hover .group-hover\:opacity-100 { opacity: 1 !important; }
        .cursor-pointer { cursor: pointer; }
        .select-none { user-select: none; }
        .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Leaderboard specific styles */
        .rank-badge {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
        }

        .rank-badge.gold {
            background: linear-gradient(45deg, #FFD700, #FFA500);
            color: #000;
        }

        .rank-badge.silver {
            background: linear-gradient(45deg, #C0C0C0, #A0A0A0);
            color: #000;
        }

        .rank-badge.bronze {
            background: linear-gradient(45deg, #CD7F32, #8B4513);
            color: #fff;
        }

        .rank-badge.other {
            background-color: var(--secondary);
            color: var(--secondary-foreground);
        }

        .user-avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--border);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .coins-badge {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 9999px;
            font-weight: 600;
            color: var(--success);
        }

        .coins-badge img {
            width: 1rem;
            height: 1rem;
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
        }

        .leaderboard-table th {
            text-align: left;
            padding: 1rem;
            color: var(--muted-foreground);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .leaderboard-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .leaderboard-table tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .leaderboard-table tr.current-user {
            background-color: rgba(99, 102, 241, 0.1);
            border-left: 3px solid var(--primary);
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
                            <div class="text-2xl font-display" id="username"><?php echo htmlspecialchars($userName ?? 'User'); ?></div>
                            <div class="text-xs uppercase text-muted-foreground">Rank #<?php echo $userRank; ?></div>
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
                        <a href="ourcourse.php" class="nav-item disabled">
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
                        class="nav-item disabled"
                        target="_blank"
                        rel="noopener noreferrer">
                            <svg class="nav-icon" viewBox="0 0 640 512" fill="currentColor">
                                <path d="M18.32 255.78L192 223.96l-91.28 68.69c-10.08 10.08-2.94 27.31 11.31 27.31h222.7c.94 0 1.78-.23 2.65-.29l-79.21 88.62c-9.85 11.03-2.16 28.11 12.58 28.11 6.34 0 12.27-3.59 15.99-9.26l79.21-88.62c.39.04.78.07 1.18.07h78.65c14.26 0 21.39-17.22 11.32-27.31l-79.2-88.62c.39-.04.78-.07 1.18-.07h78.65c14.26 0 21.39-17.22 11.32-27.31L307.33 9.37c-6.01-6.76-17.64-6.76-23.65 0l-265.38 246.4c-10.08 10.08-2.94 27.31 11.31 27.31h79.21c.39 0 .78-.03 1.17-.07L18.32 255.78z"/>
                            </svg>
                            <span class="nav-label">Drago Tool</span>
                        </a>

                        <a href="logout.php" class="nav-item disabled">
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
            <!-- Header -->
            <div class="card">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded bg-primary flex items-center justify-center">
                            <svg class="size-5 text-primary-foreground" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-width="1.667" d="M10 2.5l3.333 6.667H6.667L10 2.5z"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M3.333 10.833h13.334"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M5.833 13.333h8.334"/>
                                <path stroke="currentColor" stroke-width="1.667" d="M7.5 15.833h5"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-display">Leaderboard</h1>
                            <div class="text-sm text-muted-foreground">Global ranking based on Eagle Coins</div>
                        </div>
                    </div>
                    <div class="badge badge-outline-warning">LIVE</div>
                </div>
            </div>

            <!-- Your Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="card animate-fadeIn">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">YOUR RANK</span>
                        </div>
                    </div>
                    <div class="bg-accent p-4">
                        <div class="flex items-center">
                            <span class="text-5xl font-display text-destructive" id="user-rank">#<?php echo $userRank; ?></span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">
                                OUT OF <?php echo count($allUsersData); ?> USERS
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card animate-fadeIn" style="animation-delay: 0.1s">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet bullet-success"></div>
                            <span class="text-sm font-medium uppercase">YOUR COINS</span>
                        </div>
                    </div>
                    <div class="bg-accent p-4">
                        <div class="flex items-center">
                            <span class="text-5xl font-display text-success" id="user-coins"><?php echo $userCoins; ?></span>
                            <span class="ml-3">
                                <img src="images/coin.png" alt="Eagle Coin" style="width: 40px; height: 40px;">
                            </span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">
                                TOTAL EAGLE COINS
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Table -->
            <div class="card animate-slideUp" style="animation-delay: 0.3s">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bullet"></div>
                        <span class="text-sm font-medium uppercase">GLOBAL LEADERBOARD</span>
                    </div>
                    <div class="text-sm text-muted-foreground">
                        <span id="last-updated">Updated just now</span>
                    </div>
                </div>
                <div class="bg-accent p-6">
                    <?php if (empty($allUsersData)): ?>
                        <div class="text-center py-10 text-muted-foreground">
                            No users found
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="leaderboard-table">
                                <thead>
                                    <tr>
                                        <th class="pl-4">RANK</th>
                                        <th>USER</th>
                                        <th class="text-right pr-4">EAGLE COINS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allUsersData as $index => $user): ?>
                                        <?php 
                                        $rank = $index + 1;
                                        $isCurrentUser = $user['id'] == $userId;
                                        $coins = $user['eagle_coins'] ?? 0;
                                        
                                        // Determine rank badge class
                                        $badgeClass = 'other';
                                        if ($rank === 1) $badgeClass = 'gold';
                                        elseif ($rank === 2) $badgeClass = 'silver';
                                        elseif ($rank === 3) $badgeClass = 'bronze';
                                        ?>
                                        <tr class="<?php echo $isCurrentUser ? 'current-user' : ''; ?>">
                                            <td class="pl-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="rank-badge <?php echo $badgeClass; ?>">
                                                        <?php echo $rank; ?>
                                                    </div>
                                                    <?php if ($rank <= 3): ?>
                                                        <div class="text-sm font-medium">
                                                            <?php 
                                                            if ($rank === 1) echo '🥇';
                                                            elseif ($rank === 2) echo '🥈';
                                                            elseif ($rank === 3) echo '🥉';
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="user-avatar">
                                                        <img src="https://media.istockphoto.com/id/1288129985/vector/missing-image-of-a-person-placeholder.jpg?s=612x612&w=0&k=20&c=9kE777krx5mrFHsxx02v60ideRWvIgI1RWzR1X4MG2Y=" alt="<?php echo htmlspecialchars($user['name']); ?>">
                                                    </div>
                                                    <div>
                                                        <div class="font-medium"><?php echo htmlspecialchars($user['name']); ?></div>
                                                        <?php if ($isCurrentUser): ?>
                                                            <div class="text-xs text-primary">(You)</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right pr-4">
                                                <div class="flex items-center justify-end gap-2">
                                                    <span class="font-bold text-lg"><?php echo $coins; ?></span>
                                                    <img src="images/coin.png" alt="Coin" style="width: 20px; height: 20px;">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card animate-fadeIn" style="animation-delay: 0.5s">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bullet"></div>
                        <span class="text-sm font-medium uppercase">HOW IT WORKS</span>
                    </div>
                </div>
                <div class="bg-accent p-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 border border-border rounded-lg">
                            <div class="text-2xl font-bold text-primary mb-2">Complete Assignments</div>
                            <div class="text-sm text-muted-foreground">Earn coins by completing lab assignments</div>
                        </div>
                        <div class="text-center p-4 border border-border rounded-lg">
                            <div class="text-2xl font-bold text-primary mb-2">Participate in Labs</div>
                            <div class="text-sm text-muted-foreground">Active participation earns bonus coins</div>
                        </div>
                        <div class="text-center p-4 border border-border rounded-lg">
                            <div class="text-2xl font-bold text-primary mb-2">Weekly Challenges</div>
                            <div class="text-sm text-muted-foreground">Complete challenges for extra rewards</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update last updated time
            function updateLastUpdatedTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                const updateElement = document.getElementById('last-updated');
                if (updateElement) {
                    updateElement.textContent = `Updated ${timeString}`;
                }
            }
            
            // Update time initially and every minute
            updateLastUpdatedTime();
            setInterval(updateLastUpdatedTime, 60000);
            
            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.leaderboard-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(255, 255, 255, 0.03)';
                });
                
                row.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('current-user')) {
                        this.style.backgroundColor = '';
                    }
                });
            });
            
            // Animate elements on load
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (!entry.target.classList.contains('animate-fadeIn') && 
                            !entry.target.classList.contains('animate-slideUp')) {
                            entry.target.classList.add('animate-fadeIn');
                        }
                    }
                });
            }, observerOptions);

            // Observe all cards for animation
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => observer.observe(card));
            
            // Navigation active states
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (!this.classList.contains('disabled')) {
                        // Remove active class from all items
                        navItems.forEach(i => i.classList.remove('active'));
                        // Add active class to clicked item
                        this.classList.add('active');
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
