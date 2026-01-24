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
echo $allUsersJSON;
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
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
            grid-template-columns: 280px 1fr 380px;
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

        .desktop-right-sidebar {
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

        .nav-section {
            margin-bottom: 1.5rem;
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

        .flex { display: flex; }
        .grid { display: grid; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .z-10 { z-index: 10; }
        .z-20 { z-index: 20; }
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .size-full { width: 100%; height: 100%; }
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
        .bg-accent\/30 { background-color: rgba(248, 250, 252, 0.05); opacity: 0.3; }
        .bg-card\/90 { background-color: rgba(26, 29, 36, 0.9); }
        .bg-card\/80 { background-color: rgba(26, 29, 36, 0.8); }
        .bg-background\/50 { background-color: rgba(13, 16, 21, 0.5); }
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
            opacity: 0.3;
            pointer-events: none;
            z-index: 10;
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
                            <div class="text-2xl font-display" id="username"><?= $user?></div>
                            <!-- <div class="text-xs uppercase text-muted-foreground">paranthe aagurom</div> -->
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
                            <a href="lab.php" class="nav-item disabled">
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
                            <a href="contactus.php" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 20 20" fill="none">
                                    <path fill="currentColor" d="M17.5 4.167h.833v-.834H17.5v.834Zm0 11.666v.834h.833v-.834H17.5Zm-15 0h-.833v.834H2.5v-.834Zm0-11.666v-.834h-.833v.834H2.5Zm7.5 6.666-.528.645.528.432.528-.432-.528-.645Zm7.5-6.666h-.833v11.666h1.666V4.167H17.5Zm0 11.666V15h-15V16.667h15v-.834Zm-15 0h.833V4.167H1.667v11.666H2.5Zm0-11.666V5h15V3.333h-15v.834Zm7.5 6.666.528-.645-7.084-5.795-.527.645-.528.645 7.083 5.795.528-.645Zm7.083-5.795-.527-.645-7.084 5.795.528.645.528.645 7.083-5.795-.528-.645Z"/>
                                </svg>
                                <span class="nav-label">Contact support</span>
                            </a>
                            <a href="#" class="nav-item disabled">
                                <svg class="nav-icon" viewBox="0 0 640 512" fill="currentColor">
                                    <!-- Font Awesome Dragon (simpler) -->
                                    <path d="M18.32 255.78L192 223.96l-91.28 68.69c-10.08 10.08-2.94 27.31 11.31 27.31h222.7c.94 0 1.78-.23 2.65-.29l-79.21 88.62c-9.85 11.03-2.16 28.11 12.58 28.11 6.34 0 12.27-3.59 15.99-9.26l79.21-88.62c.39.04.78.07 1.18.07h78.65c14.26 0 21.39-17.22 11.32-27.31l-79.2-88.62c.39-.04.78-.07 1.18-.07h78.65c14.26 0 21.39-17.22 11.32-27.31L307.33 9.37c-6.01-6.76-17.64-6.76-23.65 0l-265.38 246.4c-10.08 10.08-2.94 27.31 11.31 27.31h79.21c.39 0 .78-.03 1.17-.07L18.32 255.78z"/>
                                </svg>
                                <span class="nav-label">Dragon Tool</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="desktop-main">
            <div class="card">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded bg-primary flex items-center justify-center">
                            <svg class="size-5 text-primary-foreground" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M5.833 3.333h-2.5v13.334h2.5m8.333-13.334h2.5v13.334h-2.5"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-display">Leaderboard</h1>
                            <div class="text-sm text-muted-foreground">Current Ranking System</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="card animate-fadeIn">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">YOUR CURRENT RANK</span>
                        </div>
                    </div>
                    <div class="bg-accent p-4 relative overflow-hidden">
                        <div class="flex items-center">
                            <span class="text-5xl font-display text-destructive" id="user-rank">#10</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">IN THE GLOBAL RANKING</p>
                        </div>
                    </div>
                </div>

                <div class="card animate-fadeIn" style="animation-delay: 0.1s">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <!-- <div class="bullet"></div> -->
                            <span class="text-sm font-medium uppercase">EAGLE COINS</span>
                        </div>
                        <!-- <svg class="size-4 text-muted-foreground" viewBox="0 0 20 20" fill="none">
                            <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 4.164V2.497m3.333 1.67V2.5M6.667 4.167v-1.67M10 17.5v-1.667m3.333 1.667v-1.667M6.667 17.5v-1.667m9.166-2.5H17.5m-1.667-6.667H17.5M15.833 10H17.5m-15 0h1.667M2.5 13.334h1.667M2.5 6.666h1.667M12.5 10a2.501 2.501 0 1 1-5.002 0 2.501 2.501 0 0 1 5.002 0ZM4.167 4.167h11.666v11.666H4.167V4.167Z"/>
                        </svg> -->
                    </div>
                    <div class="bg-accent p-4 relative overflow-hidden">
                        <div class="flex items-center">
                            <span class="text-5xl font-display text-success" id="user-coins"><?= $_SESSION['e-coins']; ?></span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">TOTAL EARNED POINTS</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card animate-slideUp" style="animation-delay: 0.3s">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="bullet"></div>
                        <span class="text-sm font-medium uppercase">GLOBAL LEADERBOARD</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge badge-outline-warning">LIVE</span>
                        <span class="text-sm text-muted-foreground">Updated every 5 minutes</span>
                    </div>
                </div>
                <div class="bg-accent p-6 space-y-4">
                    <!-- Top 3 will be populated by JavaScript -->
                    <div class="grid grid-cols-3 gap-4 mb-6" id="top-3-container">
                        <!-- Top 3 will be dynamically inserted here -->
                    </div>

                    <!-- Other Rankings will be populated by JavaScript -->
                    <div class="space-y-3" id="rankings-container">
                        <!-- Rankings 4-10 will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <div class="desktop-right-sidebar">
            <div class="card">
                <div class="tv-noise"></div>
                <div class="bg-accent/30 flex flex-col justify-between p-4 relative z-20">
                    <div class="flex justify-between items-center text-sm font-medium uppercase">
                        <span class="opacity-50" id="day-of-week">Wednesday</span>
                        <br>
                        <span id="full-date">July 10th, 2025</span>
                    </div>
                    <br>
                    <div class="text-center my-6">
                        <div id="current-time" class="text-5xl font-display">15:42</div>
                    </div>
                    <br>
                </div>
            </div>

            <div class="card">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm font-medium uppercase">
                        <span>Notifications</span><br><br>
                        <span class="badge badge-destructive">3</span>
                    </div>
                    <!-- <button class="button button-ghost button-sm opacity-50 hover:opacity-100 uppercase">Clear All</button> -->
                </div>
                <div class="bg-accent p-3 space-y-2">
                    
                    <div class="group p-3 rounded-lg border border-border bg-background cursor-pointer">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 bg-success"></div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <div class="flex items-center gap-2 flex-1">
                                        <h4 class="text-sm font-semibold">PAYMENT RECEIVED</h4>
                                        <span class="badge badge-secondary text-xs">MED</span>
                                    </div>
                                    <button class="button button-ghost button-sm opacity-0 group-hover:opacity-100 transition-opacity text-xs h-6 px-2">clear</button>
                                </div>
                                <p class="text-xs text-muted-foreground line-clamp-2">
                                    Your payment to Rampant Studio has been processed successfully.
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-muted-foreground">39m ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                 
                    <div class="group p-3 rounded-lg border border-border bg-background cursor-pointer">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 bg-primary"></div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <div class="flex items-center gap-2 flex-1">
                                        <h4 class="text-sm font-semibold">INTRO: JOYCO STUDIO AND V0</h4>
                                        <span class="badge badge-secondary text-xs">LOW</span>
                                    </div>
                                    <button class="button button-ghost button-sm opacity-0 group-hover:opacity-100 transition-opacity text-xs h-6 px-2">clear</button>
                                </div>
                                <p class="text-xs text-muted-foreground line-clamp-2">
                                    About us - We're a healthcare company focused on accessibility and innovation.
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-muted-foreground">45m ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <div class="group p-3 rounded-lg border border-border/30 bg-background/50">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 bg-primary"></div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <div class="flex items-center gap-2 flex-1">
                                        <h4 class="text-sm font-medium">SYSTEM UPDATE</h4>
                                        <span class="badge badge-secondary text-xs">MED</span>
                                    </div>
                                    <button class="button button-ghost button-sm opacity-0 group-hover:opacity-100 transition-opacity text-xs h-6 px-2">clear</button>
                                </div>
                                <p class="text-xs text-muted-foreground line-clamp-2">
                                    Security patches have been applied to all guard bots.
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-muted-foreground">2h ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group p-3 rounded-lg border border-border/30 bg-background/50">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 bg-primary"></div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <div class="flex items-center gap-2 flex-1">
                                        <h4 class="text-sm font-medium">SYSTEM UPDATE</h4>
                                        <span class="badge badge-secondary text-xs">MED</span>
                                    </div>
                                    <button class="button button-ghost button-sm opacity-0 group-hover:opacity-100 transition-opacity text-xs h-6 px-2">clear</button>
                                </div>
                                <p class="text-xs text-muted-foreground line-clamp-2">
                                    Security patches have been applied to all guard bots.
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-muted-foreground">2h ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- <button class="button button-ghost button-sm w-full mt-2">Show All (4)</button> -->
                </div>
            </div>
        </div>
    </div>
    <script>
// Pass PHP data to JavaScript
const allUsersData = <?php echo $allUsersJSON; ?>;
const YOUR_USER_ID = <?php echo $currentUserId; ?>;
const userCoins = <?php echo $userCoins; ?>;
const userName = "<?php echo addslashes($userName ?? 'User'); ?>";

document.addEventListener('DOMContentLoaded', function() {
    
    // Update all UI elements
    function updateUI() {
        // Update your stats
        document.getElementById('user-rank').innerText = `#<?php echo $userRank; ?>`;
        document.getElementById('user-coins').textContent = userCoins;
        document.getElementById('username').textContent = userName;
        
        // Show top 3
        showTop3(allUsersData.slice(0, 3));
        
        // Show rankings 4-10
        showRankings(allUsersData.slice(3, 10));
        
        // Update time
        updateLastUpdatedTime();
    }
    
    // Show top 3 users
    function showTop3(topUsers) {
        const container = document.getElementById('top-3-container');
        
        if (topUsers.length === 0) {
            container.innerHTML = '<div class="col-span-3 text-center py-10 text-muted-foreground">No data available</div>';
            return;
        }
        
        container.innerHTML = '';
        
        // Create positions array (2nd, 1st, 3rd)
        const positions = [
            { rank: 2, index: 1 },
            { rank: 1, index: 0 },
            { rank: 3, index: 2 }
        ];
        
        positions.forEach(pos => {
            const user = topUsers[pos.index];
            
            if (user) {
                const isFirstPlace = pos.rank === 1;
                const coins = user.eagle_coins || 0;
                const borderClass = isFirstPlace ? 'border-primary' : 'border-secondary';
                
                const card = document.createElement('div');
                card.className = `relative bg-card rounded-lg p-4 border-2 ${borderClass} ${isFirstPlace ? 'shadow-lg' : ''}`;
                card.innerHTML = `
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <div class="${isFirstPlace ? 'size-12' : 'size-10'} rounded-full ${isFirstPlace ? 'bg-primary text-primary-foreground' : 'bg-secondary text-secondary-foreground'} flex items-center justify-center font-bold ${isFirstPlace ? 'text-xl' : 'text-lg'} shadow-lg">
                            ${pos.rank}
                        </div>
                    </div>
                    <div class="text-center ${isFirstPlace ? 'pt-6' : 'pt-4'}">
                        <div class="${isFirstPlace ? 'size-20' : 'size-16'} rounded-full overflow-hidden mx-auto ${isFirstPlace ? 'mb-4' : 'mb-3'} border-2 ${borderClass}">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(user.name)}" alt="${user.name}" class="size-full object-cover">
                        </div>
                        <h3 class="${isFirstPlace ? 'text-2xl' : 'text-xl'} font-display mb-2">${user.name}</h3>
                        <div class="flex items-center justify-center gap-1">
                            <span class="${isFirstPlace ? 'text-3xl' : 'text-2xl'} font-bold ${isFirstPlace ? 'text-primary' : 'text-secondary'}">${coins}</span>
                            <span class="text-sm text-muted-foreground">🦅</span>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            } else {
                // Empty spot if no user for this position
                container.appendChild(document.createElement('div'));
            }
        });
    }
    
    // Show rankings 4-10
    function showRankings(users) {
        const container = document.getElementById('rankings-container');
        
        if (users.length === 0) {
            container.innerHTML = '<div class="text-center py-6 text-muted-foreground">No more users to show</div>';
            return;
        }
        
        container.innerHTML = '';
        
        users.forEach((user, index) => {
            const rank = index + 4; // Starting from rank 4
            const isCurrentUser = user.id == YOUR_USER_ID;
            const coins = user.eagle_coins || 0;
            
            const card = document.createElement('div');
            card.className = `flex items-center gap-4 p-3 rounded-lg border ${isCurrentUser ? 'border-2 border-primary bg-card/90' : 'border-border bg-card hover:bg-card/80'} transition-colors`;
            card.innerHTML = `
                <div class="size-10 rounded ${isCurrentUser ? 'bg-primary text-primary-foreground' : 'bg-secondary text-secondary-foreground'} flex items-center justify-center font-bold text-lg">
                    ${rank}
                </div>
                <div class="size-12 rounded-lg overflow-hidden">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=${encodeURIComponent(user.name)}" alt="${user.name}" class="size-full object-cover">
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-display">${user.name}</h3>
                </div>
                <div class="flex items-center gap-1">
                    <span class="badge ${isCurrentUser ? 'badge-default' : 'badge-secondary'}">${coins}</span>
                    <div class="size-6">
                        <img src="images/coin.png" alt="Coin" class="size-full object-contain" style="height:80px;">
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }
    
    // Update last updated time
    function updateLastUpdatedTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const updateText = document.querySelector('.text-sm.text-muted-foreground');
        if (updateText) {
            updateText.textContent = `Last updated ${timeString}`;
        }
    }
    
    // Date/Time display
    function updateDateTime() {
        const now = new Date();
        document.getElementById('current-time').textContent = 
            now.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
        
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        const dayName = days[now.getDay()];
        const month = months[now.getMonth()];
        const day = now.getDate();
        const year = now.getFullYear();
        
        document.getElementById('day-of-week').textContent = dayName.toUpperCase();
        document.getElementById('full-date').textContent = `${month} ${day}, ${year}`;
    }
    
    // Load data immediately
    updateUI();
    
    // Update date/time
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Clear notifications
    document.querySelectorAll('.button-ghost.button-sm').forEach(button => {
        if (button.textContent.trim().toLowerCase() === 'clear') {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const notification = this.closest('.group');
                if (notification) {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
            });
        }
    });
});
</script>
</body>
</html>