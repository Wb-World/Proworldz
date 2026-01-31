<?php
session_start();
require_once 'api/dbconf.php';

// Debug: Check if file exists
if (!file_exists('api/dbconf.php')) {
    die("Error: dbconf.php not found at: " . realpath('api/dbconf.php'));
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['id'];

// Create database connection with error handling
try {
    $db = new DBconfig();
    $connection = $db->check_con();
    
    if ($connection === "connection error") {
        die("Database connection failed. Please check your database credentials.");
    }
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_assignment'])) {
    $assignmentTitle = $_POST['assignmentTitle'] ?? '';
    $projectLink = $_POST['projectLink'] ?? '';
    $coins = $_POST['coins'] ?? 0;
    
    if (!empty($assignmentTitle) && !empty($projectLink)) {
        // 1. Add to waiting assignments in database
        $db->upload_waiting_assign($userId, $assignmentTitle);
        
        // 2. Send to Discord - FIXED METHOD
        $discordWebhook = 'https://discord.com/api/webhooks/1466008772072702098/tgU1oW1SkiqZZ9FD3-s9dR4gdzjBN7n839_RICXRlv0_XMBCnjb_jI1h8oyeUwr1NaqC';
        
        // Simple text message that always works
        $message = "**New Assignment Submission**\n\n" .
                   "**Assignment:** " . htmlspecialchars($assignmentTitle) . "\n" .
                   "**User:** <@hathim0012169>\n" .
                   "**Project Link:** " . htmlspecialchars($projectLink) . "\n" .
                   "**Coins Earned:** " . htmlspecialchars($coins) . "\n\n" .
                   "Submitted at: " . date('Y-m-d H:i:s');
        
        // Send using POST - most reliable method
        $data = ['content' => $message];
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => true // Don't fail on HTTP errors
            ]
        ];
        
        $context = stream_context_create($options);
        
        // Try to send to Discord (ignore if it fails)
        try {
            @file_get_contents($discordWebhook, false, $context);
        } catch (Exception $e) {
            // Silent fail - don't break the user experience
        }
        
        // 3. Reload page to show updated status
        header("Location: assignment.php?success=1");
        exit();
    }
}

// Get user information
$userInfo = $db->getUserInfo($userId, ['name', 'course', 'assignments', 'eagle_coins']);
$userName = isset($userInfo['name']) ? $userInfo['name'] : 'User';
$course = isset($userInfo['course']) ? $userInfo['course'] : 'Not enrolled';
$assignmentsData = isset($userInfo['assignments']) ? $userInfo['assignments'] : '';

// Parse assignments
$assignmentsArray = !empty($assignmentsData) ? explode(',', $assignmentsData) : [];
$assignmentsArray = array_filter($assignmentsArray); // Remove empty values
$hasAssignments = !empty($assignmentsArray);

// Get waiting assignments - SAFE VERSION
try {
    $waitingAssignments = $db->get_waiting_assign($userId);
    $waitingAssignments = is_array($waitingAssignments) ? $waitingAssignments : [];
} catch (Exception $e) {
    // If there's an error (like missing column), use empty array
    $waitingAssignments = [];
}

// Get assignment titles based on course
$assignmentTitles = [];
if ($course !== "Not enrolled") {
    // Course-specific assignments
    if ($course === "Secure X") {
        $assignmentTitles = ["Network Security Audit Report", "Penetration Testing Lab", "Firewall Configuration"];
    } else if ($course === "AI Verse Web Labs") {
        $assignmentTitles = ["AI-Powered Web Application", "Machine Learning Model Deployment", "Neural Network Implementation"];
    } else if ($course === "Code Foundry") {
        $assignmentTitles = ["Multi-language Coding Project", "Algorithm Optimization", "Data Structures Implementation"];
    } else if ($course === "CLI++ Systems") {
        $assignmentTitles = ["C++ Command Line Tool", "System Utility Development", "Memory Management Project"];
    } else if ($course === "APMan") {
        $assignmentTitles = ["REST API Development", "GraphQL Implementation", "API Security Audit"];
    } else {
        $assignmentTitles = ["Make portfolio website for you", "Project Documentation", "Final Project Submission"];
    }
}

// Check for success message
$successMessage = isset($_GET['success']) ? "Assignment submitted successfully!" : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Assignments | ProWorldz</title>
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

/* ===== CUSTOM PROPERTIES ===== */
:root {
    --radius: 0.625rem;
    --background: #0d1015;
    --foreground: #f8fafc;
    --card: #1a1d24;
    --border: rgba(255, 255, 255, 0.1);
    --primary: #6366f1;
    --primary-light: #8183f4;
    --primary-foreground: #ffffff;
    --muted-foreground: #94a3b8;
    --success: #10b981;
    --warning: #f59e0b;
    
    --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    --gradient-subtle: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(129, 131, 244, 0.1) 100%);
    
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
    color: var(--foreground);
    transition: all 0.2s;
    margin-bottom: 0.25rem;
    cursor: pointer;
}

.nav-item:hover {
    background-color: rgba(248, 250, 252, 0.05);
}

.nav-item.active {
    background-color: var(--primary);
    color: var(--primary-foreground);
}

.nav-item.disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    gap: 2rem;
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
    font-size: 3rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.page-header p {
    color: var(--muted-foreground);
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Success Message */
.success-message {
    background-color: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.3);
    padding: 1rem;
    border-radius: var(--radius);
    text-align: center;
    margin-bottom: 1rem;
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== ASSIGNMENT LIST ===== */
.assignment-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.assignment-card {
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.9) 100%);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.assignment-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.assignment-card:hover::before {
    opacity: 1;
}

.assignment-card:hover {
    transform: translateY(-6px);
    border-color: var(--primary);
    box-shadow: var(--shadow-xl);
}

/* Assignment Left Content */
.assignment-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex: 1;
}

.assignment-icon {
    width: 56px;
    height: 56px;
    border-radius: calc(var(--radius) - 2px);
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.assignment-icon i {
    font-size: 1.5rem;
    color: var(--primary-foreground);
}

.assignment-details {
    flex: 1;
}

.assignment-details h3 {
    font-family: 'Rebels', monospace;
    font-size: 1.5rem;
    color: var(--foreground);
    margin-bottom: 0.5rem;
}

.assignment-details p {
    color: var(--muted-foreground);
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

/* Coin Reward Styles */
.coin-reward {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.coin-reward .coin-amount {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--warning);
}

.coin-reward img {
    width: 20px;
    height: 20px;
    object-fit: contain;
}

/* Assignment Right Content */
.assignment-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1rem;
    min-width: 180px;
}

/* ===== BUTTONS ===== */
.submit-btn {
    padding: 0.875rem 2rem;
    background: var(--gradient-primary);
    color: var(--primary-foreground);
    border: none;
    border-radius: calc(var(--radius) - 4px);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    width: 100%;
    text-align: center;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-xl);
}

.submit-btn.completed {
    background: var(--success);
    cursor: default;
    opacity: 0.7;
}

.submit-btn.completed:hover {
    transform: none;
    box-shadow: none;
}

/* Status Badge */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: center;
    width: 100%;
}

.status-badge.pending {
    background-color: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-badge.completed {
    background-color: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.3);
}

/* ===== NO ASSIGNMENT PAGE ===== */
.no-assignment-container {
    text-align: center;
    padding: 4rem 2rem;
    position: relative;
    overflow: hidden;
    margin-top: 2rem;
}

.assignment-image {
    width: 300px;
    height: 300px;
    margin: 0 auto 2rem;
    object-fit: contain;
    filter: drop-shadow(0 0 20px rgba(99, 102, 241, 0.3));
}

.no-assignment-container h2 {
    font-family: 'Rebels', monospace;
    font-size: 2.5rem;
    color: var(--foreground);
    margin-bottom: 1rem;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.no-assignment-container p {
    color: var(--muted-foreground);
    font-size: 1.125rem;
    max-width: 500px;
    margin: 0 auto 2rem;
    line-height: 1.6;
}

/* ===== MODAL STYLES ===== */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-overlay.active {
    display: flex;
}

.modal-content {
    background: linear-gradient(145deg, var(--card) 0%, rgba(26, 29, 36, 0.95) 100%);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    padding: 2rem;
    width: 90%;
    max-width: 400px;
    box-shadow: var(--shadow-2xl);
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.github-logo {
    width: 48px;
    height: 48px;
    color: var(--foreground);
    filter: drop-shadow(0 0 10px rgba(99, 102, 241, 0.2));
}

.modal-body {
    margin-bottom: 1.5rem;
}

.project-input {
    width: 100%;
    padding: 0.875rem 1rem;
    background-color: rgba(248, 250, 252, 0.05);
    border: 1px solid var(--border);
    border-radius: calc(var(--radius) - 2px);
    color: var(--foreground);
    font-family: 'Roboto Mono', monospace;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.project-input::placeholder {
    color: var(--muted-foreground);
}

.project-input:focus {
    outline: none;
    background-color: rgba(248, 250, 252, 0.08);
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.modal-footer {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.modal-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: calc(var(--radius) - 4px);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: 'Roboto Mono', monospace;
}

.modal-btn-cancel {
    background-color: rgba(248, 250, 252, 0.05);
    color: var(--foreground);
    border: 1px solid var(--border);
}

.modal-btn-cancel:hover {
    background-color: rgba(248, 250, 252, 0.1);
}

.modal-btn-submit {
    background: var(--gradient-primary);
    color: var(--primary-foreground);
}

.modal-btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-xl);
}

.modal-btn-submit:active {
    transform: translateY(0);
}

/* Hidden form for submission */
.hidden-form {
    display: none;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .desktop-container {
        grid-template-columns: 1fr;
        padding: 1rem;
    }
    
    .desktop-sidebar {
        display: none;
    }
    
    .page-header h1 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .page-header p {
        font-size: 1rem;
        padding: 0 1rem;
    }
    
    .assignment-card {
        flex-direction: column;
        gap: 1.5rem;
        align-items: stretch;
    }
    
    .assignment-left {
        width: 100%;
    }
    
    .assignment-right {
        width: 100%;
        align-items: stretch;
    }
    
    .submit-btn {
        width: 100%;
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
        font-size: 1.75rem;
    }
    
    .assignment-card {
        padding: 1.5rem;
    }
    
    .submit-btn {
        padding: 0.75rem 1.5rem;
    }
    
    .assignment-image {
        width: 200px;
        height: 200px;
    }
    
    .assignment-details h3 {
        font-size: 1.25rem;
    }

    .modal-content {
        width: 95%;
        padding: 1.5rem;
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .modal-btn {
        width: 100%;
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
    background: var(--muted-foreground);
    border-radius: 3px;
}

/* Utility Classes */
.gap-2 { gap: 0.5rem; }
.mt-2 { margin-top: 0.5rem; }
.font-bold { font-weight: 700; }
.text-lg { font-size: 1.125rem; }
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
                            <a href="assignment.php" class="nav-item active">
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
                            <a href="maintanance.php" class="nav-item">
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
                            <a href="maintanance.php" class="nav-item">
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
    <main class="desktop-main">
        <div class="page-header">
            <h1>Assignments - <?php echo htmlspecialchars($course); ?></h1>
            <p>Track and submit your course assignments</p>
        </div>


        <?php if (!$hasAssignments || empty($assignmentTitles)): ?>
            <!-- NO ASSIGNMENTS FOUND -->
            <div class="no-assignment-container">
                <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" alt="No Assignments" class="assignment-image">
                <h2>No Assignments Found</h2>
                <p>
                    You haven't enrolled in any course yet. Please enroll in a course to access assignments.
                </p>
            </div>
        <?php else: ?>
            <!-- ASSIGNMENT LIST -->
            <div class="assignment-list">
                <?php 
                // Define coin values for each assignment (12, 15, 7 coins)
                $coinValues = [12, 15, 7];
                
                foreach ($assignmentTitles as $index => $assignmentTitle): 
                    $isSubmitted = in_array($assignmentTitle, $assignmentsArray);
                    $isWaiting = in_array($assignmentTitle, $waitingAssignments);
                    $coins = isset($coinValues[$index]) ? $coinValues[$index] : 10; // Default to 10 if not set
                ?>
                    <div class="assignment-card" id="assignment-card-<?php echo $index + 1; ?>">
                        <div class="assignment-left">
                            <div class="assignment-icon">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div class="assignment-details">
                                <h3><?php echo htmlspecialchars($assignmentTitle); ?></h3>
                                <p><?php echo htmlspecialchars($course); ?></p>
                                
                                <!-- Coin Reward Display -->
                                <div class="coin-reward">
                                    <span class="coin-amount"><?php echo $coins; ?></span>
                                    <img src="images/coin.png" alt="Coin" style="width: 20px; height: 20px;">
                                    <span class="text-muted-foreground" style="font-size: 0.875rem;">Eagle Coins Reward</span>
                                </div>
                            </div>
                        </div>
                        <div class="assignment-right">
                            <?php if ($isSubmitted || $isWaiting): ?>
                                <div class="status-badge completed">
                                    <i class="fa-solid fa-circle-check mr-2"></i>Submitted
                                </div>
                                <button class="submit-btn completed" disabled>
                                    Submitted
                                </button>
                            <?php else: ?>
                                <button class="submit-btn" onclick="openSubmitModal('<?php echo addslashes($assignmentTitle); ?>', <?php echo $coins; ?>)">
                                    Submit Assignment
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<!-- Submit Modal -->
<div id="submitModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <svg class="github-logo" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v 3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
        </div>
        <div class="modal-body">
            <input 
                type="text" 
                id="projectLink" 
                class="project-input" 
                placeholder="paste your project link"
                required
            >
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-cancel" type="button" onclick="closeSubmitModal()">Cancel</button>
            <button class="modal-btn modal-btn-submit" type="button" onclick="submitAssignment()">Submit</button>
        </div>
    </div>
</div>

<!-- Hidden form for submission -->
<form method="POST" id="hiddenForm" class="hidden-form">
    <input type="hidden" name="submit_assignment" value="1">
    <input type="hidden" name="assignmentTitle" id="formAssignmentTitle">
    <input type="hidden" name="coins" id="formCoins">
    <input type="hidden" name="projectLink" id="formProjectLink">
</form>

<script>
let currentAssignmentData = { title: '', coins: 0 };

function openSubmitModal(assignmentTitle, coins) {
    currentAssignmentData = { title: assignmentTitle, coins: coins };
    document.getElementById('submitModal').classList.add('active');
    document.getElementById('projectLink').focus();
    document.getElementById('projectLink').value = '';
}

function closeSubmitModal() {
    document.getElementById('submitModal').classList.remove('active');
    document.getElementById('projectLink').value = '';
}

function submitAssignment() {
    const projectLink = document.getElementById('projectLink').value.trim();
    
    if (!projectLink) {
        alert('Please enter a project link');
        return;
    }
    
    // Validate URL format
    try {
        new URL(projectLink);
    } catch (e) {
        alert('Please enter a valid URL');
        return;
    }
    
    // Set form values and submit
    document.getElementById('formAssignmentTitle').value = currentAssignmentData.title;
    document.getElementById('formCoins').value = currentAssignmentData.coins;
    document.getElementById('formProjectLink').value = projectLink;
    document.getElementById('hiddenForm').submit();
}

// Close modal when pressing Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSubmitModal();
    }
});

// Close modal when clicking outside
document.getElementById('submitModal')?.addEventListener('click', function(event) {
    if (event.target === this) {
        closeSubmitModal();
    }
});
</script>
</body>
</html>