<?php
session_start();
require_once 'api/dbconf.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

$userId = $_SESSION['id'];
$db = new DBconfig();

if (!$db->check_con()) {
    die("Database connection failed");
}

// Get user info
$userInfo = $db->getUserInfo($userId, ['name', 'assignments', 'eagle_coins', 'course', 'assigns_complete']);
$userName = isset($userInfo['name']) ? $userInfo['name'] : 'User';
$assignments = isset($userInfo['assignments']) ? $userInfo['assignments'] : 0;
$eagleCoins = isset($userInfo['eagle_coins']) ? $userInfo['eagle_coins'] : 0;
$course = isset($userInfo['course']) ? $userInfo['course'] : 'Not enrolled';
$_SESSION['c-user'] = $userName;
$_SESSION['c-course'] = $course;

$assignmentsArray = !empty($assignments) ? explode(',', $assignments) : [];
$assignmentsCount = count(array_filter($assignmentsArray));
$completed_assigns = $userInfo['assigns_complete'];

// Get all users for rank calculation
$allUsers = $db->getAllUsersData(['id', 'eagle_coins']);
usort($allUsers, function($a, $b) {
    return $b['eagle_coins'] - $a['eagle_coins'];
});

$rank = 1;
foreach ($allUsers as $user) {
    if ($user['id'] == $userId) {
        break;
    }
    $rank++;
}

$totalUsers = count($allUsers);

// ===== TRACK CHANGES FOR NOTIFICATIONS =====
// Store previous values in session to detect changes
$prevCoins = isset($_SESSION['prev_eagle_coins']) ? $_SESSION['prev_eagle_coins'] : $eagleCoins;
$prevRank = isset($_SESSION['prev_rank']) ? $_SESSION['prev_rank'] : $rank;
$prevAssignments = isset($_SESSION['prev_assignments_count']) ? $_SESSION['prev_assignments_count'] : $assignmentsCount;

// Calculate changes
$coinsChange = $eagleCoins - $prevCoins;
$rankChange = $prevRank - $rank; // Positive = rank improved
$assignmentsChange = $assignmentsCount - $prevAssignments;

// Update session with current values for next time
$_SESSION['prev_eagle_coins'] = $eagleCoins;
$_SESSION['prev_rank'] = $rank;
$_SESSION['prev_assignments_count'] = $assignmentsCount;

// ===== NOTIFICATION DATA TO PASS TO JAVASCRIPT =====
$notificationData = [
    'userName' => htmlspecialchars($userName),
    'showWelcome' => !isset($_SESSION['welcome_shown']), // Show welcome only once
    'coinsChange' => $coinsChange,
    'rankChange' => $rankChange,
    'assignmentsChange' => $assignmentsChange,
    'currentRank' => $rank,
    'currentCoins' => $eagleCoins,
    'currentAssignments' => $assignmentsCount
];

// Mark welcome as shown for this session
$_SESSION['welcome_shown'] = true;

$maxCoins = 0;
foreach ($allUsers as $user) {
    if ($user['eagle_coins'] > $maxCoins) {
        $maxCoins = $user['eagle_coins'];
    }
}
if ($maxCoins === 0) {
    $maxCoins = $eagleCoins ?: 1;
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proworldz Dashboard</title>
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
            grid-template-columns: 280px 1fr 380px;
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

        /* Right Sidebar - Widgets */
        .desktop-right-sidebar {
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

        .font-mono {
            font-family: 'Roboto Mono', monospace;
        }

        /* ===== UTILITY CLASSES ===== */
        .hidden {
            display: none !important;
        }

        .block {
            display: block;
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

        .absolute {
            position: absolute;
        }

        .sticky {
            position: sticky;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .inset-x-0 {
            left: 0;
            right: 0;
        }

        .top-0 {
            top: 0;
        }

        .bottom-0 {
            bottom: 0;
        }

        .right-0 {
            right: 0;
        }

        .left-0 {
            left: 0;
        }

        .z-10 {
            z-index: 10;
        }

        .z-20 {
            z-index: 20;
        }

        .z-30 {
            z-index: 30;
        }

        .z-40 {
            z-index: 40;
        }

        .z-50 {
            z-index: 50;
        }

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        .h-screen {
            height: 100vh;
        }

        .min-h-screen {
            min-height: 100vh;
        }

        .size-full {
            width: 100%;
            height: 100%;
        }

        .aspect-square {
            aspect-ratio: 1 / 1;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .overflow-y-auto {
            overflow-y: auto;
        }

        .overflow-clip {
            overflow: clip;
        }

        .object-contain {
            object-fit: contain;
        }

        .object-cover {
            object-fit: cover;
        }

        .rounded {
            border-radius: 0.375rem;
        }

        .rounded-lg {
            border-radius: var(--radius);
        }

        .rounded-md {
            border-radius: calc(var(--radius) - 2px);
        }

        .rounded-sm {
            border-radius: calc(var(--radius) - 4px);
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .border {
            border-width: 1px;
        }

        .border-2 {
            border-width: 2px;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-t {
            border-top-width: 1px;
        }

        .ring-2 {
            box-shadow: 0 0 0 2px var(--ring);
        }

        .ring-pop {
            box-shadow: 0 0 0 2px var(--pop);
        }

        .bg-background {
            background-color: var(--background);
        }

        .bg-foreground {
            background-color: var(--foreground);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-secondary {
            background-color: var(--secondary);
        }

        .bg-muted {
            background-color: var(--muted);
        }

        .bg-accent {
            background-color: var(--accent);
        }

        .bg-card {
            background-color: var(--card);
        }

        .bg-success {
            background-color: var(--success);
        }

        .bg-warning {
            background-color: var(--warning);
        }

        .bg-destructive {
            background-color: var(--destructive);
        }

        .bg-sidebar {
            background-color: var(--sidebar);
        }

        .bg-sidebar-primary {
            background-color: var(--sidebar-primary);
        }

        .bg-sidebar-accent {
            background-color: var(--sidebar-accent);
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

        .text-secondary {
            color: var(--secondary);
        }

        .text-secondary-foreground {
            color: var(--secondary-foreground);
        }

        .text-muted {
            color: var(--muted);
        }

        .text-muted-foreground {
            color: var(--muted-foreground);
        }

        .text-success {
            color: var(--success);
        }

        .text-warning {
            color: var(--warning);
        }

        .text-destructive {
            color: var(--destructive);
        }

        .text-sidebar-foreground {
            color: var(--sidebar-foreground);
        }

        .text-sidebar-primary {
            color: var(--sidebar-primary);
        }

        .text-sidebar-primary-foreground {
            color: var(--sidebar-primary-foreground);
        }

        .text-sidebar-accent-foreground {
            color: var(--sidebar-accent-foreground);
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

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .text-5xl {
            font-size: 3rem;
            line-height: 1;
        }

        .font-normal {
            font-weight: 400;
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

        .italic {
            font-style: italic;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .opacity-0 {
            opacity: 0;
        }

        .opacity-10 {
            opacity: 0.1;
        }

        .opacity-20 {
            opacity: 0.2;
        }

        .opacity-30 {
            opacity: 0.3;
        }

        .opacity-40 {
            opacity: 0.4;
        }

        .opacity-50 {
            opacity: 0.5;
        }

        .opacity-60 {
            opacity: 0.6;
        }

        .opacity-70 {
            opacity: 0.7;
        }

        .opacity-80 {
            opacity: 0.8;
        }

        .opacity-90 {
            opacity: 0.9;
        }

        .opacity-100 {
            opacity: 1;
        }

        .grayscale {
            filter: grayscale(100%);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-grab {
            cursor: grab;
        }

        .cursor-grabbing {
            cursor: grabbing;
        }

        .select-none {
            user-select: none;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .transition-colors {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        .transition-opacity {
            transition: opacity 0.3s ease;
        }

        .transition-transform {
            transition: transform 0.3s ease;
        }

        .duration-200 {
            transition-duration: 0.2s;
        }

        .duration-300 {
            transition-duration: 0.3s;
        }

        .duration-500 {
            transition-duration: 0.5s;
        }

        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1 !important;
        }

        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        .group:hover .group-hover\:brightness-110 {
            filter: brightness(1.1);
        }

        /* ===== LAYOUT GRID ===== */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .grid-cols-12 {
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .col-span-1 {
            grid-column: span 1 / span 1;
        }

        .col-span-2 {
            grid-column: span 2 / span 2;
        }

        .col-span-3 {
            grid-column: span 3 / span 3;
        }

        .col-span-7 {
            grid-column: span 7 / span 7;
        }

        .gap-1 {
            gap: 0.25rem;
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

        .gap-10 {
            gap: 2.5rem;
        }

        .gap-gap {
            gap: var(--gap);
        }

        .p-0 {
            padding: 0;
        }

        .p-1 {
            padding: 0.25rem;
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

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
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

        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .py-10 {
            padding-top: 2.5rem;
            padding-bottom: 2.5rem;
        }

        .py-sides {
            padding-top: var(--sides);
            padding-bottom: var(--sides);
        }

        .px-sides {
            padding-left: var(--sides);
            padding-right: var(--sides);
        }

        .pt-1 {
            padding-top: 0.25rem;
        }

        .pt-2 {
            padding-top: 0.5rem;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .pb-1 {
            padding-bottom: 0.25rem;
        }

        .pb-4 {
            padding-bottom: 1rem;
        }

        .pl-2 {
            padding-left: 0.5rem;
        }

        .pl-3 {
            padding-left: 0.75rem;
        }

        .pl-4 {
            padding-left: 1rem;
        }

        .pr-1 {
            padding-right: 0.25rem;
        }

        .pr-2 {
            padding-right: 0.5rem;
        }

        .pr-3 {
            padding-right: 0.75rem;
        }

        .pr-4 {
            padding-right: 1rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-auto {
            margin-top: auto;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
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

        .ml-auto {
            margin-left: auto;
        }

        .mr-1 {
            margin-right: 0.25rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .mr-3 {
            margin-right: 0.75rem;
        }

        .space-y-1 > * + * {
            margin-top: 0.25rem;
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

        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        .flex-1 {
            flex: 1 1 0%;
        }

        .flex-col {
            flex-direction: column;
        }

        .flex-row {
            flex-direction: row;
        }

        .items-start {
            align-items: flex-start;
        }

        .items-center {
            align-items: center;
        }

        .items-baseline {
            align-items: baseline;
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

        .min-w-0 {
            min-width: 0;
        }

        .max-w-xs {
            max-width: 20rem;
        }

        .max-w-sm {
            max-width: 24rem;
        }

        .max-w-md {
            max-width: 28rem;
        }

        .max-w-max {
            max-width: max-content;
        }

        .w-1\/4 {
            width: 25%;
        }

        .w-14 {
            width: 3.5rem;
        }

        .w-16 {
            width: 4rem;
        }

        .w-56 {
            width: 14rem;
        }

        .w-80 {
            width: 20rem;
        }

        .h-5 {
            height: 1.25rem;
        }

        .h-6 {
            height: 1.5rem;
        }

        .h-7 {
            height: 1.75rem;
        }

        .h-8 {
            height: 2rem;
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

        .h-header-mobile {
            height: var(--header-mobile);
        }

        .size-3 {
            width: 0.75rem;
            height: 0.75rem;
        }

        .size-4 {
            width: 1rem;
            height: 1rem;
        }

        .size-5 {
            width: 1.25rem;
            height: 1.25rem;
        }

        .size-6 {
            width: 1.5rem;
            height: 1.5rem;
        }

        .size-7 {
            width: 1.75rem;
            height: 1.75rem;
        }

        .size-9 {
            width: 2.25rem;
            height: 2.25rem;
        }

        .size-10 {
            width: 2.5rem;
            height: 2.5rem;
        }

        .size-12 {
            width: 3rem;
            height: 3rem;
        }

        .size-14 {
            width: 3.5rem;
            height: 3.5rem;
        }

        .size-16 {
            width: 4rem;
            height: 4rem;
        }

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

        .button-xl {
            height: 3.5rem;
            padding: 0 2rem;
            font-size: 1rem;
        }

        .button-icon {
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
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

        .input::placeholder {
            color: var(--muted-foreground);
            opacity: 0.7;
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

        .bullet-success {
            background-color: var(--success);
        }

        .bullet-warning {
            background-color: var(--warning);
        }

        .bullet-destructive {
            background-color: var(--destructive);
        }

        .bullet-sm {
            width: 0.375rem;
            height: 0.375rem;
        }

        .sheet {
            position: fixed;
            z-index: 50;
            background-color: var(--background);
            transition: transform 0.3s ease;
        }

        .sheet-bottom {
            bottom: 0;
            left: 0;
            right: 0;
            transform: translateY(100%);
        }

        .sheet-bottom.open {
            transform: translateY(0);
        }

        .sheet-right {
            top: 0;
            right: 0;
            bottom: 0;
            transform: translateX(100%);
        }

        .sheet-right.open {
            transform: translateX(0);
        }

        .tooltip {
            position: relative;
        }

        .tooltip-content {
            position: absolute;
            z-index: 50;
            padding: 0.5rem 0.75rem;
            background-color: var(--popover);
            color: var(--popover-foreground);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .tooltip:hover .tooltip-content {
            opacity: 1;
        }

        .tabs-list {
            display: flex;
            gap: 0.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.5rem;
        }

        .tabs-trigger {
            padding: 0.5rem 1rem;
            background: transparent;
            border: none;
            color: var(--muted-foreground);
            font-family: inherit;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: color 0.2s;
            position: relative;
        }

        .tabs-trigger:hover {
            color: var(--foreground);
        }

        .tabs-trigger.active {
            color: var(--foreground);
        }

        .tabs-trigger.active::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--primary);
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

        .nav-title .bullet {
            width: 0.375rem;
            height: 0.375rem;
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
        @keyframes marquee-up {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(0, -50%, 0);
            }
        }

        @keyframes marquee-down {
            0% {
                transform: translate3d(0, -50%, 0);
            }
            100% {
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes marquee-pulse {
            0%, 100% {
                opacity: 0.15;
                transform: scale(1) translateY(0);
            }
            25% {
                opacity: 0.4;
                transform: scale(1.02) translateY(-1px);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05) translateY(-2px);
            }
            75% {
                opacity: 0.6;
                transform: scale(1.02) translateY(-1px);
            }
        }

        .animate-marquee-up {
            animation: marquee-up 6s ease-in-out infinite;
        }

        .animate-marquee-down {
            animation: marquee-down 6s ease-in-out infinite;
        }

        .animate-marquee-pulse {
            animation: marquee-pulse 3s ease-in-out infinite;
        }

        .group:hover .animate-marquee-pulse {
            animation-play-state: paused;
        }

        .group:hover .animate-marquee-up,
        .group:hover .animate-marquee-down {
            animation-play-state: paused;
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

        /* ===== CHART STYLES ===== */
        .chart-container {
            position: relative;
            width: 100%;
        }

        .chart-grid {
            stroke: var(--muted-foreground);
            stroke-opacity: 0.3;
            stroke-width: 2;
            stroke-dasharray: 8 8;
        }

        .chart-axis {
            stroke: var(--muted-foreground);
            stroke-width: 1.5;
        }

        .chart-area {
            fill-opacity: 0.4;
            stroke-width: 2;
        }

        .chart-tooltip {
            position: absolute;
            background-color: var(--popover);
            border: 1px solid var(--border);
            border-radius: calc(var(--radius) - 2px);
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            pointer-events: none;
            z-index: 50;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .chart-tooltip::before {
            content: '';
            position: absolute;
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 8px;
            height: 8px;
            background-color: var(--popover);
            border-left: 1px solid var(--border);
            border-top: 1px solid var(--border);
            transform: rotate(45deg);
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
        /* Notification specific styles */
#notification-list {
    max-height: 400px;
    overflow-y: auto;
}

.notification-item {
    transition: all 0.3s ease;
    animation: fadeIn 0.3s ease-out;
}

.notification-item:hover {
    background-color: var(--accent);
    transform: translateX(2px);
}

#view-all-container {
    border-top: 1px solid var(--border);
    padding-top: 1rem;
}

#view-all-notifications:hover, 
#show-less-notifications:hover {
    background-color: var(--accent);
}

/* Animation for new notifications */
@keyframes pulse {
    0% { opacity: 0.5; }
    50% { opacity: 1; }
    100% { opacity: 0.5; }
}

.new-notification {
    animation: pulse 2s infinite;
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
                            <div class="text-2xl font-display"><?php echo htmlspecialchars($userName); ?></div>
                            <div class="text-xs uppercase text-muted-foreground"><?php echo htmlspecialchars($course); ?></div>
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
            <!-- Dashboard Header -->
            <div class="card">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="size-9 rounded bg-primary flex items-center justify-center">
                            <svg class="size-5 text-primary-foreground" viewBox="0 0 20 20" fill="none">
                                <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M5.833 3.333h-2.5v13.334h2.5m8.333-13.334h2.5v13.334h-2.5"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-display">Overview</h1>
                            <!-- <div class="text-sm text-muted-foreground">Last updated 12:05</div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-4">
                <!-- Stat 1: Issues Completed -->
                <div class="card animate-fadeIn">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">ASSIGNMENTS COMPLETED</span>
                        </div>
                        <!-- <svg class="size-4 text-muted-foreground" viewBox="0 0 20 20" fill="none">
                            <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="m10 2.5 6.666 3.75v7.5L10 17.5l-6.667-3.75v-7.5L10 2.5Z"/>
                            <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M12.5 10a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg> -->
                    </div>
                    <div class="bg-accent p-4 relative overflow-hidden">
                        <div class="flex items-center">
                            <span class="text-5xl font-display text-success"><?php echo htmlspecialchars($completed_assigns); ?></span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">
                                TOTAL ASSIGNMENTS COMPLETED
                            </p>
                        </div>
                        <!-- Marquee Arrows -->
                    </div>
                </div>

                <!-- Stat 2: Rank -->
                <div class="card animate-fadeIn" style="animation-delay: 0.1s">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">RANK</span>
                        </div>
                        <svg class="size-4 text-muted-foreground" viewBox="0 0 20 20" fill="none">
                            <path stroke="currentColor" stroke-linecap="square" stroke-width="1.667" d="M10 4.164V2.497m3.333 1.67V2.5M6.667 4.167v-1.67M10 17.5v-1.667m3.333 1.667v-1.667M6.667 17.5v-1.667m9.166-2.5H17.5m-1.667-6.667H17.5M15.833 10H17.5m-15 0h1.667M2.5 13.334h1.667M2.5 6.666h1.667M12.5 10a2.501 2.501 0 1 1-5.002 0 2.501 2.501 0 0 1 5.002 0ZM4.167 4.167h11.666v11.666H4.167V4.167Z"/>
                        </svg>
                    </div>
                    <div class="bg-accent p-4 relative overflow-hidden">
                        <div class="flex items-center">
                            <span class="text-5xl font-display text-destructive">#<?php echo htmlspecialchars($rank); ?></span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">
                                OUT OF <?php echo htmlspecialchars($totalUsers); ?> STUDENTS
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Eagle Coins -->
                <div class="card animate-fadeIn" style="animation-delay: 0.2s">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">EAGLE COINS</span>
                        </div>
                        <svg class="size-4 text-muted-foreground" viewBox="0 0 20 20" fill="none">
                            <path stroke="currentColor" stroke-width="1.667" d="m10 2.5 1.722 3.343 3.581-1.146-1.146 3.58L17.5 10l-3.342 1.722 2.553 4.989-4.989-2.553L10 17.5l-1.722-3.342-3.581 1.145 1.146-3.58L2.5 10l3.343-1.722-2.554-4.989 4.989 2.554L10 2.5Z"/>
                        </svg>
                    </div>
                    <div class="bg-accent p-4 relative overflow-hidden">
                        <div class="flex items-center">
                            <span class="text-5xl font-display"><?php echo htmlspecialchars($eagleCoins); ?></span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm font-medium text-muted-foreground tracking-wide">
                                TOTAL EAGLE COINS EARNED
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <!-- Chart Section -->
<div class="card animate-slideUp" style="animation-delay: 0.3s">
    <div class="p-4">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="bullet"></div>
                <span class="text-sm font-medium uppercase">PERFORMANCE WAVE</span>
            </div>
            <div class="text-sm text-muted-foreground">
                Based on Eagle Coins
            </div>
        </div>
    </div>
    <div class="bg-accent p-4">
        <div class="chart-container" style="height: 250px;">
            <svg id="performanceWave" class="w-full h-full" viewBox="0 0 800 250">
                <!-- Grid Lines (matching your existing style) -->
                <line x1="0" y1="40" x2="800" y2="40" class="chart-grid" />
                <line x1="0" y1="90" x2="800" y2="90" class="chart-grid" />
                <line x1="0" y1="140" x2="800" y2="140" class="chart-grid" />
                <line x1="0" y1="190" x2="800" y2="190" class="chart-grid" />
                
                <!-- Wave Background Area -->
                <defs>
                    <linearGradient id="waveGradient" x1="0" x2="0" y1="0" y2="1">
                        <stop offset="5%" stop-color="var(--chart-2)" stop-opacity="0.1"/>
                        <stop offset="95%" stop-color="var(--chart-2)" stop-opacity="0.05"/>
                    </linearGradient>
                    
                    <clipPath id="waveClip">
                        <path id="wavePath" d="M0,190 Q100,190 200,180 Q300,170 400,160 Q500,150 600,140 Q700,130 800,120 L800,250 L0,250 Z"></path>
                    </clipPath>
                    
                    <!-- Pulsing effect filter -->
                    <filter id="pulseEffect" x="-50%" y="-50%" width="200%" height="200%">
                        <feGaussianBlur in="SourceGraphic" stdDeviation="2" result="blur"/>
                        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="pulse"/>
                    </filter>
                </defs>
                
                <!-- Pulsing Background Glow -->
                <circle id="pulseGlow" cx="400" cy="160" r="0" fill="var(--chart-2)" opacity="0.1" filter="url(#pulseEffect)">
                    <animate attributeName="r" values="0;80;0" dur="3s" repeatCount="indefinite"/>
                    <animate attributeName="opacity" values="0.1;0.3;0.1" dur="3s" repeatCount="indefinite"/>
                </circle>
                
                <!-- Animated Wave Pattern with pulse -->
                <g clip-path="url(#waveClip)">
                    <!-- Main Wave Pattern with pulse animation -->
                    <path id="wavePattern" d="M-200,150 Q-100,140 0,150 Q100,160 200,150 Q300,140 400,150 Q500,160 600,150 Q700,140 800,150 Q900,160 1000,150" 
                          fill="none" stroke="var(--chart-2)" stroke-width="2" stroke-opacity="0.3">
                        <animate attributeName="stroke-width" values="2;3;2" dur="2s" repeatCount="indefinite"/>
                        <animate attributeName="stroke-opacity" values="0.3;0.5;0.3" dur="2s" repeatCount="indefinite"/>
                    </path>
                    
                    <!-- Second Wave with offset pulse -->
                    <path id="wavePattern2" d="M-200,160 Q-100,170 0,160 Q100,150 200,160 Q300,170 400,160 Q500,150 600,160 Q700,170 800,160 Q900,150 1000,160" 
                          fill="none" stroke="var(--chart-2)" stroke-width="2" stroke-opacity="0.2">
                        <animate attributeName="stroke-width" values="2;2.5;2" dur="2.5s" repeatCount="indefinite" begin="0.3s"/>
                        <animate attributeName="stroke-opacity" values="0.2;0.4;0.2" dur="2.5s" repeatCount="indefinite" begin="0.3s"/>
                    </path>
                    
                    <!-- Third Wave with different pulse -->
                    <path id="wavePattern3" d="M-200,140 Q-100,130 0,140 Q100,150 200,140 Q300,130 400,140 Q500,150 600,140 Q700,130 800,140 Q900,150 1000,140" 
                          fill="none" stroke="var(--chart-2)" stroke-width="2" stroke-opacity="0.15">
                        <animate attributeName="stroke-width" values="2;2.3;2" dur="3s" repeatCount="indefinite" begin="0.6s"/>
                        <animate attributeName="stroke-opacity" values="0.15;0.3;0.15" dur="3s" repeatCount="indefinite" begin="0.6s"/>
                    </path>
                </g>
                
                <!-- Wave Fill Area with gentle pulse -->
                <path id="waveFill" d="M0,190 Q100,190 200,180 Q300,170 400,160 Q500,150 600,140 Q700,130 800,120 L800,250 L0,250 Z" 
                      fill="url(#waveGradient)" stroke="none">
                    <animate attributeName="opacity" values="0.8;1;0.8" dur="4s" repeatCount="indefinite"/>
                </path>
                
                <!-- Performance Level Indicator with dynamic pulse -->
                <g id="performanceIndicator">
                    <!-- Pulsing outer ring -->
                    <circle id="pulseRing" cx="400" cy="160" r="15" fill="none" stroke="var(--chart-2)" stroke-width="1" stroke-opacity="0.3">
                        <animate attributeName="r" values="15;20;15" dur="2s" repeatCount="indefinite"/>
                        <animate attributeName="stroke-opacity" values="0.3;0.6;0.3" dur="2s" repeatCount="indefinite"/>
                    </circle>
                    
                    <!-- Main indicator -->
                    <circle cx="400" cy="160" r="8" fill="var(--chart-2)" stroke="white" stroke-width="2">
                        <animate attributeName="r" values="8;10;8" dur="1.5s" repeatCount="indefinite"/>
                        <animate attributeName="fill" values="var(--chart-2);#4ade80;var(--chart-2)" dur="1.5s" repeatCount="indefinite"/>
                    </circle>
                    
                    <!-- Center dot -->
                    <circle cx="400" cy="160" r="3" fill="white">
                        <animate attributeName="r" values="3;4;3" dur="1s" repeatCount="indefinite"/>
                    </circle>
                </g>
                
                <!-- Performance Line with flow animation -->
                <path id="performanceLine" d="M0,190 Q100,190 200,180 Q300,170 400,160 Q500,150 600,140 Q700,130 800,120" 
                      fill="none" stroke="var(--chart-2)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                      stroke-dasharray="1000" stroke-dashoffset="1000">
                    <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.5s" fill="freeze" begin="0.5s"/>
                    <animate attributeName="stroke-width" values="3;3.5;3" dur="2s" repeatCount="indefinite" begin="2s"/>
                </path>
                
                <!-- Data Points with pulsing effect -->
                <circle cx="0" cy="190" r="4" fill="var(--chart-2)" stroke="white" stroke-width="2" opacity="0" id="point1">
                    <animate attributeName="opacity" from="0" to="1" dur="0.3s" fill="freeze" begin="0.5s"/>
                    <animate attributeName="r" values="4;5;4" dur="2s" repeatCount="indefinite" begin="2s"/>
                </circle>
                <circle cx="200" cy="180" r="4" fill="var(--chart-2)" stroke="white" stroke-width="2" opacity="0" id="point2">
                    <animate attributeName="opacity" from="0" to="1" dur="0.3s" fill="freeze" begin="0.8s"/>
                    <animate attributeName="r" values="4;5;4" dur="2s" repeatCount="indefinite" begin="2.3s"/>
                </circle>
                <circle cx="400" cy="160" r="6" fill="var(--chart-2)" stroke="white" stroke-width="2" opacity="0" id="point3">
                    <animate attributeName="opacity" from="0" to="1" dur="0.3s" fill="freeze" begin="1.1s"/>
                    <animate attributeName="r" values="6;8;6" dur="1.5s" repeatCount="indefinite" begin="2.6s"/>
                </circle>
                <circle cx="600" cy="140" r="4" fill="var(--chart-2)" stroke="white" stroke-width="2" opacity="0" id="point4">
                    <animate attributeName="opacity" from="0" to="1" dur="0.3s" fill="freeze" begin="1.4s"/>
                    <animate attributeName="r" values="4;5;4" dur="2s" repeatCount="indefinite" begin="2.9s"/>
                </circle>
                <circle cx="800" cy="120" r="4" fill="var(--chart-2)" stroke="white" stroke-width="2" opacity="0" id="point5">
                    <animate attributeName="opacity" from="0" to="1" dur="0.3s" fill="freeze" begin="1.7s"/>
                    <animate attributeName="r" values="4;5;4" dur="2s" repeatCount="indefinite" begin="3.2s"/>
                </circle>
                
                <!-- Current Value Display with pulse -->
                <g transform="translate(400, 100)">
                    <rect x="-50" y="-25" width="100" height="50" rx="8" fill="var(--card)" stroke="var(--chart-2)" stroke-width="1">
                        <animate attributeName="stroke-width" values="1;2;1" dur="2s" repeatCount="indefinite" begin="2s"/>
                    </rect>
                    <text id="coinValue" text-anchor="middle" dy="5" class="text-xl font-bold fill-foreground">0</text>
                    <text text-anchor="middle" y="20" class="text-xs fill-muted-foreground">COINS</text>
                </g>
                
                <!-- Performance Labels -->
                <text x="100" y="70" class="text-xs fill-muted-foreground">BEGINNER</text>
                <text x="350" y="50" class="text-xs fill-muted-foreground">INTERMEDIATE</text>
                <text x="600" y="70" class="text-xs fill-muted-foreground">ADVANCED</text>
                
                <!-- Energy particles with pulse -->
                <circle cx="100" cy="100" r="1.5" fill="var(--chart-2)" opacity="0.5">
                    <animate attributeName="r" values="1.5;2.5;1.5" dur="1.8s" repeatCount="indefinite"/>
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="1.8s" repeatCount="indefinite"/>
                </circle>
                <circle cx="700" cy="80" r="1.5" fill="var(--chart-2)" opacity="0.5">
                    <animate attributeName="r" values="1.5;2.5;1.5" dur="2.2s" repeatCount="indefinite" begin="0.5s"/>
                    <animate attributeName="opacity" values="0.5;0.8;0.5" dur="2.2s" repeatCount="indefinite" begin="0.5s"/>
                </circle>
                <circle cx="300" cy="120" r="1" fill="var(--chart-2)" opacity="0.4">
                    <animate attributeName="r" values="1;2;1" dur="2.5s" repeatCount="indefinite" begin="1s"/>
                </circle>
                <circle cx="500" cy="90" r="1" fill="var(--chart-2)" opacity="0.4">
                    <animate attributeName="r" values="1;2;1" dur="3s" repeatCount="indefinite" begin="1.5s"/>
                </circle>
            </svg>
        </div>
    </div>
</div>
            <!-- Security Status -->
            <div class="grid grid-cols-1">
                <div class="card animate-slideUp" style="animation-delay: 0.5s; min-height: 300px;">
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="bullet"></div>
                            <span class="text-sm font-medium uppercase">SECURITY STATUS</span>
                        </div>
                        <span class="badge badge-outline-success">ONLINE</span>
                    </div>
                    <div class="bg-accent p-4 relative h-full">
                        <div class="flex h-full">
                            <!-- Left Side - Security Items -->
                            <div class="flex-1 pr-8">
                                <div class="space-y-4 h-full">
                                    <!-- Guard Bots -->
                                    <div class="border rounded-md ring-4 border-success bg-success/5 text-success ring-success/3">
                                        <div class="flex items-center gap-2 p-3 border-b border-current">
                                            <div class="bullet bullet-success bullet-sm"></div>
                                            <span class="text-sm font-medium uppercase">GUARD</span>
                                        </div>
                                        <div class="p-3">
                                            <div class="text-2xl font-bold">124/124</div>
                                            <div class="text-xs opacity-50 uppercase">[RUNNING...]</div>
                                        </div>
                                    </div>

                                    <!-- Firewall -->
                                    <div class="border rounded-md ring-4 border-success bg-success/5 text-success ring-success/3">
                                        <div class="flex items-center gap-2 p-3 border-b border-current">
                                            <div class="bullet bullet-success bullet-sm"></div>
                                            <span class="text-sm font-medium uppercase">FIREWALL</span>
                                        </div>
                                        <div class="p-3">
                                            <div class="text-2xl font-bold">99.9%</div>
                                            <div class="text-xs opacity-50 uppercase">[BLOCKED]</div>
                                        </div>
                                    </div>

                                    <!-- HTML Warnings -->
                                    <div class="border rounded-md ring-4 border-warning bg-warning/5 text-warning ring-warning/3">
                                        <div class="flex items-center gap-2 p-3 border-b border-current">
                                            <div class="bullet bullet-warning bullet-sm"></div>
                                            <span class="text-sm font-medium uppercase">HTML WARNINGS</span>
                                        </div>
                                        <div class="p-3">
                                            <div class="text-2xl font-bold">12042</div>
                                            <div class="text-xs opacity-50 uppercase">[ACCESSIBILITY]</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Eagle Image -->
                            <div style="
                                position: absolute;
                                right: 20px;
                                top: 0;
                                bottom: 0;
                                left: 60%;
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                z-index: 1;
                            ">
                                <!-- Eagle Image -->
                                <div style="
                                    width: 280px;
                                    height: 280px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                ">
                                    <img src="images/image-new.png" alt="Eagle Protector" 
                                        style="
                                            max-height: 35cap;margin-bottom: 6cap;
                                            margin-right: 70cap;
                                        ">
                                </div>
                                
                                <!-- Eagle Text -->
                                <div style="
                                    position: absolute;
                                    border-radius: 8px;
                                    margin-bottom: 20cap;
                                    min-width: 180px;
                                    text-align: center;
                                    font-size: 20px;
                                    color: white;
                                    line-height: 1.4;
                                    font-family: monospace;
                                    z-index: 2;
                                ">
                                    Hi, I'm Eaglone<br>Your academic guardian
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="desktop-right-sidebar">
            <!-- Date/Time Widget -->
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

            <!-- Notifications -->
            <div class="card">
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm font-medium uppercase">
                        <span>Notifications</span>
                        <span class="badge badge-destructive" id="notify-count">0</span>
                    </div>
                </div>
                <!-- Add notification container here -->
                <div id="notification-container" class="p-4 pt-0">
                    <div id="notification-list" class="space-y-3 max-h-96 overflow-y-auto"></div>
                    <div id="view-all-container" class="hidden mt-3 text-center border-t border-border pt-3">
                        <button id="view-all-notifications" class="button button-ghost button-sm text-xs">
                            View All (4+)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
                // ===== NOTIFICATION SYSTEM =====
class NotificationSystem {
    constructor() {
        this.notifications = [];
        this.shownNotificationIds = new Set(); // Track shown notification IDs
        this.loadNotifications();
        this.setupEventListeners();
        
        // Load already shown notifications from localStorage
        const shownIds = localStorage.getItem('shown_notification_ids');
        if (shownIds) {
            this.shownNotificationIds = new Set(JSON.parse(shownIds));
        }
    }
    
    loadNotifications() {
        const saved = localStorage.getItem('user_notifications');
        if (saved) {
            this.notifications = JSON.parse(saved);
        } else {
            // Initial welcome notification
            const welcomeId = this.generateNotificationId('welcome');
            this.notifications = [{
                id: welcomeId,
                uniqueId: welcomeId,
                title: 'WELCOME TO PROWORLDZ',
                message: 'Your academic journey begins now!',
                type: 'info',
                time: 'Just now',
                read: false
            }];
            this.shownNotificationIds.add(welcomeId);
            this.saveShownIds();
        }
        this.renderNotifications();
        this.updateCount();
    }
    
    // Generate a unique ID for each notification type
    generateNotificationId(type, data = '') {
        return `${type}_${data}_${new Date().toDateString()}`; // Daily unique ID
    }
    
    saveShownIds() {
        localStorage.setItem('shown_notification_ids', JSON.stringify(Array.from(this.shownNotificationIds)));
    }
    
    addNotification(title, message, type = 'info', uniqueId = null) {
        // Generate unique ID if not provided
        const notificationId = uniqueId || this.generateNotificationId(type, title + message);
        
        // Check if this notification was already shown today
        if (this.shownNotificationIds.has(notificationId)) {
            console.log('Notification already shown:', notificationId);
            return false; // Don't add duplicate
        }
        
        const notification = {
            id: Date.now(),
            uniqueId: notificationId, // Add unique identifier
            title: title,
            message: message,
            type: type,
            time: 'Just now',
            read: false
        };
        
        this.notifications.unshift(notification);
        if (this.notifications.length > 50) {
            this.notifications.pop();
        }
        
        // Mark this notification ID as shown
        this.shownNotificationIds.add(notificationId);
        this.saveShownIds();
        this.saveNotifications();
        this.renderNotifications();
        this.updateCount();
        this.showNotificationToast(notification);
        
        return true;
    }
    
    saveNotifications() {
        localStorage.setItem('user_notifications', JSON.stringify(this.notifications));
    }
    
    addNotification(title, message, type = 'info') {
        const notification = {
            id: Date.now(),
            title: title,
            message: message,
            type: type,
            time: 'Just now',
            read: false
        };
        
        this.notifications.unshift(notification); // Add to beginning
        if (this.notifications.length > 50) {
            this.notifications.pop(); // Keep only last 50
        }
        
        this.saveNotifications();
        this.renderNotifications();
        this.updateCount();
        this.showNotificationToast(notification);
    }
    // Add this method to NotificationSystem class
cleanupOldNotificationIds() {
    const oneWeekAgo = new Date();
    oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
    
    // Filter out IDs older than 7 days
    const currentIds = Array.from(this.shownNotificationIds);
    const recentIds = currentIds.filter(id => {
        // Extract date from ID if possible, or keep if can't parse
        const parts = id.split('_');
        const datePart = parts[parts.length - 1];
        try {
            const idDate = new Date(datePart);
            return idDate >= oneWeekAgo;
        } catch {
            return true; // Keep if can't parse date
        }
    });
    
    this.shownNotificationIds = new Set(recentIds);
    this.saveShownIds();
}
    
    showNotificationToast(notification) {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 z-50 bg-card border border-border rounded-lg p-4 shadow-lg animate-slideDown';
        toast.style.minWidth = '300px';
        toast.style.maxWidth = '350px';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0" style="background-color: ${notification.type === 'info' ? 'var(--primary)' : notification.type === 'success' ? 'var(--success)' : 'var(--warning)'}"></div>
                <div class="flex-1">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <h4 class="text-sm font-semibold">${notification.title}</h4>
                        <span class="badge badge-secondary text-xs">${notification.type.toUpperCase()}</span>
                    </div>
                    <p class="text-xs text-muted-foreground">${notification.message}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-muted-foreground">${notification.time}</span>
                    </div>
                </div>
                <button class="button button-ghost button-sm text-xs h-6 px-2 close-toast">&times;</button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Close button
        toast.querySelector('.close-toast').addEventListener('click', () => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            setTimeout(() => toast.remove(), 300);
        });
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }

    showAllNotifications() {
    const container = document.getElementById('notification-list');
    const viewAllContainer = document.getElementById('view-all-container');
    
    if (!container || !viewAllContainer) return;
    
    // Clear container
    container.innerHTML = '';
    
    // Add all notifications
    this.notifications.forEach(notification => {
        const notice = document.createElement('div');
        notice.className = 'group p-3 rounded-lg border border-border bg-background cursor-pointer notification-item';
        notice.setAttribute('data-notification-id', notification.id);
        
        // Determine color based on type
        let dotColor = 'bg-primary';
        let badgeType = 'badge-secondary';
        
        switch(notification.type) {
            case 'success':
                dotColor = 'bg-success';
                badgeType = 'badge-outline-success';
                break;
            case 'warning':
                dotColor = 'bg-warning';
                badgeType = 'badge-outline-warning';
                break;
            case 'error':
                dotColor = 'bg-destructive';
                badgeType = 'badge-destructive';
                break;
        }
        
        notice.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 ${dotColor}"></div>
                <div class="flex-1">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <div class="flex items-center gap-2 flex-1">
                            <h4 class="text-sm font-semibold">${notification.title}</h4>
                            <span class="badge ${badgeType} text-xs">${notification.type.toUpperCase()}</span>
                        </div>
                        <button class="button button-ghost button-sm opacity-0 group-hover:opacity-100 transition-opacity text-xs h-6 px-2 clear-notify">clear</button>
                    </div>
                    <p class="text-xs text-muted-foreground line-clamp-2">${notification.message}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-muted-foreground">${notification.time}</span>
                        ${!notification.read ? '<span class="text-xs text-primary">NEW</span>' : ''}
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(notice);
    });
    
    // Change button to "Show Less"
    viewAllContainer.innerHTML = `
        <button id="show-less-notifications" class="button button-ghost button-sm text-xs">
            Show Less
        </button>
    `;
    
    // Handle "Show Less" click
    document.getElementById('show-less-notifications').onclick = () => {
        this.renderNotifications();
    };
}
    
    markAsRead(id) {
        const notification = this.notifications.find(n => n.id === id);
        if (notification && !notification.read) {
            notification.read = true;
            this.saveNotifications();
            this.updateCount();
        }
    }
    
    removeNotification(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
        this.saveNotifications();
        this.renderNotifications();
        this.updateCount();
    }
    
    clearAll() {
        this.notifications = [];
        this.saveNotifications();
        this.renderNotifications();
        this.updateCount();
    }
    
    renderNotifications() {
    const container = document.getElementById('notification-list');
    const viewAllContainer = document.getElementById('view-all-container');
    const viewAllBtn = document.getElementById('view-all-notifications');
    
    if (!container || !viewAllContainer) return;
    
    // Clear all content
    container.innerHTML = '';
    
    // Check if we have more than 4 notifications
    const hasMoreThanFour = this.notifications.length > 4;
    const notificationsToShow = hasMoreThanFour ? 
        this.notifications.slice(0, 4) : this.notifications;
    
    // Add notifications (limited to 4 if there are more)
    notificationsToShow.forEach(notification => {
        const notice = document.createElement('div');
        notice.className = 'group p-3 rounded-lg border border-border bg-background cursor-pointer notification-item';
        notice.setAttribute('data-notification-id', notification.id);
        
        // Determine color based on type
        let dotColor = 'bg-primary';
        let badgeType = 'badge-secondary';
        
        switch(notification.type) {
            case 'success':
                dotColor = 'bg-success';
                badgeType = 'badge-outline-success';
                break;
            case 'warning':
                dotColor = 'bg-warning';
                badgeType = 'badge-outline-warning';
                break;
            case 'error':
                dotColor = 'bg-destructive';
                badgeType = 'badge-destructive';
                break;
        }
        
        notice.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0 ${dotColor}"></div>
                <div class="flex-1">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <div class="flex items-center gap-2 flex-1">
                            <h4 class="text-sm font-semibold">${notification.title}</h4>
                            <span class="badge ${badgeType} text-xs">${notification.type.toUpperCase()}</span>
                        </div>
                        <button class="button button-ghost button-sm opacity-0 group-hover:opacity-100 transition-opacity text-xs h-6 px-2 clear-notify">clear</button>
                    </div>
                    <p class="text-xs text-muted-foreground line-clamp-2">${notification.message}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-muted-foreground">${notification.time}</span>
                        ${!notification.read ? '<span class="text-xs text-primary">NEW</span>' : ''}
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(notice);
    });
    
    // Show/Hide "View All" button with dynamic count
    if (hasMoreThanFour) {
        viewAllContainer.classList.remove('hidden');
        const hiddenCount = this.notifications.length - 4;
        viewAllBtn.textContent = `View All (${hiddenCount}+)`;
        viewAllBtn.setAttribute('data-hidden-count', hiddenCount);
    } else {
        viewAllContainer.classList.add('hidden');
    }
    
    // Handle "View All" click
    if (viewAllBtn) {
        viewAllBtn.onclick = () => this.showAllNotifications();
    }
}
    
    updateCount() {
        const unreadCount = this.notifications.filter(n => !n.read).length;
        const countElement = document.getElementById('notify-count');
        if (countElement) {
            countElement.textContent = unreadCount;
            countElement.style.display = unreadCount > 0 ? 'inline-flex' : 'none';
        }
    }
    
    setupEventListeners() {
        // Delegate clear button clicks
        document.addEventListener('click', (e) => {
            if (e.target.closest('.clear-notify')) {
                const notice = e.target.closest('.group');
                const id = notice?.getAttribute('data-notification-id');
                if (id) {
                    this.removeNotification(parseInt(id));
                }
                e.stopPropagation();
            }
            
            if (e.target.id === 'clear-all-notify') {
                this.clearAll();
            }
        });
    }
}

// ===== UTILITY FUNCTIONS =====

/// ===== PERFORMANCE WAVE =====
function initializePerformanceWave() {
    const eagleCoins = <?php echo $eagleCoins; ?>;
    const maxCoins = <?php echo $maxCoins; ?>;
    
    // Calculate performance level
    let performancePercent;
    
    if (maxCoins === 0) {
        performancePercent = 50;
    } else {
        // Use logarithmic scale for better distribution
        const logCoins = Math.log10(eagleCoins + 1);
        const logMax = Math.log10(maxCoins + 1);
        performancePercent = (logCoins / logMax) * 100;
    }
    
    performancePercent = Math.min(Math.max(performancePercent, 0), 100);
    
    // Calculate pulse intensity based on performance (0.5 to 2)
    const pulseIntensity = 0.5 + (performancePercent / 100) * 1.5;
    
    // Calculate wave height based on performance
    const waveHeight = 190 - (performancePercent * 70 / 100);
    
    setTimeout(() => {
        // Update coin counter with pulse effect
        const coinValue = document.getElementById('coinValue');
        if (coinValue) {
            let current = 0;
            const duration = 2000;
            const steps = 100;
            const increment = eagleCoins / steps;
            
            const countUp = () => {
                for (let i = 0; i <= steps; i++) {
                    setTimeout(() => {
                        current += increment;
                        if (current >= eagleCoins) {
                            current = eagleCoins;
                        }
                        coinValue.textContent = Math.floor(current).toLocaleString();
                        
                        // Add subtle pulse to the number as it counts up
                        if (i % 10 === 0) {
                            coinValue.style.transform = `scale(${1 + (pulseIntensity * 0.1)})`;
                            setTimeout(() => {
                                coinValue.style.transform = 'scale(1)';
                            }, 100);
                        }
                    }, i * (duration / steps));
                }
            };
            
            setTimeout(countUp, 1000);
        }
        
        // Adjust animations based on pulse intensity
        const adjustAnimation = (elementId, attribute, baseValues) => {
            const element = document.getElementById(elementId);
            if (element) {
                // Scale animation values based on pulse intensity
                const values = baseValues.split(';').map(val => {
                    if (attribute === 'r' || attribute === 'stroke-width') {
                        // For numeric values, scale by pulse intensity
                        const num = parseFloat(val);
                        return `${num * pulseIntensity}`;
                    } else if (attribute === 'stroke-opacity' || attribute === 'opacity') {
                        // For opacity, increase contrast
                        const num = parseFloat(val);
                        return Math.min(num * (1 + (pulseIntensity - 1) * 0.3), 1);
                    }
                    return val;
                }).join(';');
                
                // Update the animation
                element.querySelector('animate').setAttribute('values', values);
            }
        };
        
        // Update pulse glow based on performance
        const pulseGlow = document.getElementById('pulseGlow');
        if (pulseGlow) {
            const maxRadius = 80 * pulseIntensity;
            pulseGlow.querySelector('animate').setAttribute('values', `0;${maxRadius};0`);
        }
        
        // Update wave patterns
        adjustAnimation('wavePattern', 'stroke-width', '2;3;2');
        adjustAnimation('wavePattern', 'stroke-opacity', '0.3;0.5;0.3');
        
        adjustAnimation('wavePattern2', 'stroke-width', '2;2.5;2');
        adjustAnimation('wavePattern2', 'stroke-opacity', '0.2;0.4;0.2');
        
        adjustAnimation('wavePattern3', 'stroke-width', '2;2.3;2');
        adjustAnimation('wavePattern3', 'stroke-opacity', '0.15;0.3;0.15');
        
        // Update performance indicator pulse
        const pulseRing = document.getElementById('pulseRing');
        if (pulseRing) {
            const maxRadius = 20 * pulseIntensity;
            pulseRing.querySelector('animate').setAttribute('values', `15;${maxRadius};15`);
        }
        
        // Update wave position based on performance
        const wavePath = document.getElementById('wavePath');
        const waveFill = document.getElementById('waveFill');
        const performanceLine = document.getElementById('performanceLine');
        const performanceIndicator = document.getElementById('performanceIndicator');
        
        if (wavePath && waveFill && performanceLine && performanceIndicator) {
            // Create dynamic wave curve based on performance
            const cp1Y = 190 - (performancePercent * 60 / 100);
            const cp2Y = 190 - (performancePercent * 40 / 100);
            
            const waveD = `M0,190 Q100,${cp1Y} 200,${waveHeight-10} Q300,${waveHeight} 400,${waveHeight} Q500,${waveHeight} 600,${waveHeight+10} Q700,${cp2Y} 800,120 L800,250 L0,250 Z`;
            const lineD = `M0,190 Q100,${cp1Y} 200,${waveHeight-10} Q300,${waveHeight} 400,${waveHeight} Q500,${waveHeight} 600,${waveHeight+10} Q700,${cp2Y} 800,120`;
            
            wavePath.setAttribute('d', waveD);
            waveFill.setAttribute('d', waveD);
            performanceLine.setAttribute('d', lineD);
            
            // Update indicator position
            const circles = performanceIndicator.querySelectorAll('circle');
            circles.forEach(circle => {
                circle.setAttribute('cy', waveHeight);
            });
        }
        
        // Update data points position
        const points = ['point1', 'point2', 'point3', 'point4', 'point5'];
        const pointYValues = [190, waveHeight-10, waveHeight, waveHeight+10, 120];
        
        points.forEach((pointId, index) => {
            const point = document.getElementById(pointId);
            if (point) {
                point.setAttribute('cy', pointYValues[index]);
            }



        });
        
        // Add wave movement animation
        const wavePatterns = ['wavePattern', 'wavePattern2', 'wavePattern3'];
        wavePatterns.forEach((id, index) => {
            const wave = document.getElementById(id);
            if (wave) {
                const speed = 3 + index + (pulseIntensity * 0.5);
                wave.style.animation = `waveMove ${speed}s linear infinite`;
            }
        });
        
        // Add CSS for wave movement
        if (!document.querySelector('#waveAnimationStyle')) {
            const style = document.createElement('style');
            style.id = 'waveAnimationStyle';
            style.textContent = `
                @keyframes waveMove {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(200px); }
                }
            `;
            document.head.appendChild(style);
        }
        
    }, 500);
}
function formatTime(date) {
    return date.toLocaleTimeString('en-US', {
        hour12: true,
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatDate(date) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
    const dayName = days[date.getDay()];
    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();
    
    // Add ordinal suffix to day
    const dayWithSuffix = day + (day % 10 === 1 && day !== 11 ? 'st' : 
                               day % 10 === 2 && day !== 12 ? 'nd' : 
                               day % 10 === 3 && day !== 13 ? 'rd' : 'th');
    
    return {
        dayOfWeek: dayName.toUpperCase(),
        fullDate: `${month} ${dayWithSuffix}, ${year}`
    };
}

// ===== INITIALIZE ON DOM LOAD =====
// ===== INITIALIZE ON DOM LOAD =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize notification system
    window.notificationSystem = new NotificationSystem();
    
    // Get PHP notification data
    const notificationData = <?php echo json_encode($notificationData); ?>;
    
    // Show notifications based on changes
    setTimeout(() => {
        // 1. Welcome back message (only once per session)
        if (notificationData.showWelcome) {
            const welcomeId = window.notificationSystem.generateNotificationId(
                'welcome_back', 
                notificationData.userName
            );
            window.notificationSystem.addNotification(
                'WELCOME BACK',
                `Welcome back, ${notificationData.userName}!`,
                'info',
                welcomeId
            );
        }
        
        // 2. Rank improvement notification (only if rank actually improved)
        if (notificationData.rankChange > 0) {
            const rankId = window.notificationSystem.generateNotificationId(
                'rank_improvement',
                `${notificationData.prevRank}_to_${notificationData.currentRank}`
            );
            window.notificationSystem.addNotification(
                'RANK IMPROVED!',
                `You moved up ${notificationData.rankChange} position(s)! Now ranked #${notificationData.currentRank}.`,
                'success',
                rankId
            );
        }
        
        // 3. New coins earned notification
        if (notificationData.coinsChange > 0) {
            const coinsId = window.notificationSystem.generateNotificationId(
                'coins_earned',
                `+${notificationData.coinsChange}_${new Date().toDateString()}`
            );
            window.notificationSystem.addNotification(
                'COINS EARNED',
                `You earned ${notificationData.coinsChange} new Eagle Coins! Total: ${notificationData.currentCoins}.`,
                'success',
                coinsId
            );
        }
        
        // 4. New assignments completed
        if (notificationData.assignmentsChange > 0) {
            const assignmentsId = window.notificationSystem.generateNotificationId(
                'assignments_completed',
                `+${notificationData.assignmentsChange}`
            );
            window.notificationSystem.addNotification(
                'ASSIGNMENTS COMPLETED',
                `You completed ${notificationData.assignmentsChange} new assignment(s)! Total: ${notificationData.currentAssignments}.`,
                'success',
                assignmentsId
            );
        }
        
        // 5. Current status notifications (show only once per day)
        const dailyStatusId = window.notificationSystem.generateNotificationId('daily_status');
        window.notificationSystem.addNotification(
            'CURRENT STATUS',
            `Rank: #${notificationData.currentRank} | Coins: ${notificationData.currentCoins} | Assignments: ${notificationData.currentAssignments}`,
            'info',
            dailyStatusId
        );
        
    }, 1000);
    
    // Initialize performance wave
    initializePerformanceWave();
    
    // Update date/time
    function updateDateTime() {
        const now = new Date();
        const indiaTime = new Intl.DateTimeFormat('en-IN', {
            timeZone: 'Asia/Kolkata',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        }).format(now);
        
        document.getElementById('current-time').textContent = indiaTime;
        
        const dateInfo = formatDate(now);
        document.getElementById('day-of-week').textContent = dateInfo.dayOfWeek;
        document.getElementById('full-date').textContent = dateInfo.fullDate;
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Remove the demo notification from setTimeout
    // (commented out or removed)
    // setTimeout(() => {
    //     window.notificationSystem.addNotification('SYSTEM ONLINE', 'All systems are running optimally.', 'info');
    // }, 3000);
});

// Make addNotification globally available
function addNotification(title, message, type = 'info') {
    if (window.notificationSystem) {
        window.notificationSystem.addNotification(title, message, type);
    }
}
    </script>
</body>
</html>