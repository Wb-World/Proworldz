<?php
session_start();

// Database Configuration
$db_host = "sql204.infinityfree.com";
$db_user = "if0_40322633";
$db_pass = "HDm584vG4kZDnt";
$db_name = "if0_40322633_students";

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['admin_username']);
$current_admin = null;
$admin_role = null;

if ($is_logged_in) {
    $username = $_SESSION['admin_username'];
    $query = "SELECT * FROM admins WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $current_admin = $result->fetch_assoc();
            $admin_role = $current_admin['role'] ?? null;
        } else {
            session_destroy();
            $is_logged_in = false;
        }
        $stmt->close();
    }
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    header('Content-Type: application/json');
    
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required']);
        exit;
    }
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM admins WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if ($password == $admin['password']) {
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['role'] = $admin['role'];
                
                echo json_encode(['success' => true, 'role' => $admin['role']]);
                $stmt->close();
                exit;
            }
        }
        $stmt->close();
    }
    
    echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    exit;
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Add Student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_student') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in || !in_array($admin_role, ['root', 'admin'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $mother_phone = trim($_POST['mother_phone'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $father_phone = trim($_POST['father_phone'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $password = password_hash('12345678', PASSWORD_BCRYPT);
    $eagle_coins = isset($_POST['eagle_coins']) ? intval($_POST['eagle_coins']) : 0;
    $assignments = $_POST['assignments'] ?? '';
    $assigns_complete = isset($_POST['assigns_complete']) ? intval($_POST['assigns_complete']) : 0;
    $waiting_assigns = $_POST['waiting_assigns'] ?? '';
    
    if (empty($id) || empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'ID, name, and email are required']);
        exit;
    }
    
    $check_query = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $check_stmt = $conn->prepare($check_query);
    if ($check_stmt) {
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            $check_stmt->close();
            exit;
        }
        $check_stmt->close();
    }
    
    $query = "INSERT INTO users (id, name, email, dob, gender, phone, address, mother_name, mother_phone, father_name, father_phone, course, passw, eagle_coins, assignments, assigns_complete, waiting_assigns) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssssssssssssisis", $id, $name, $email, $dob, $gender, $phone, $address, $mother_name, $mother_phone, $father_name, $father_phone, $course, $password, $eagle_coins, $assignments, $assigns_complete, $waiting_assigns);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add student']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

// Handle Get Students
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_students') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $query = "SELECT id, name, email, phone, gender, address, mother_name, mother_phone, father_name, father_phone, dob, course, eagle_coins, assignments, assigns_complete, waiting_assigns, IPADDR FROM users ORDER BY id DESC";
    $result = $conn->query($query);
    
    $students = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    
    echo json_encode(['success' => true, 'data' => $students]);
    exit;
}

// Handle Get Single Student
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_student') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $student_id = $_GET['id'] ?? '';
    if (empty($student_id)) {
        echo json_encode(['success' => false, 'message' => 'Student ID is required']);
        exit;
    }
    
    $query = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            echo json_encode(['success' => true, 'data' => $student]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

// Handle Update Student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_student') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in || $admin_role !== 'root') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $student_id = $_POST['id'] ?? '';
    if (empty($student_id)) {
        echo json_encode(['success' => false, 'message' => 'Student ID is required']);
        exit;
    }
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $mother_phone = trim($_POST['mother_phone'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $father_phone = trim($_POST['father_phone'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $eagle_coins = isset($_POST['eagle_coins']) ? intval($_POST['eagle_coins']) : 0;
    $assignments = $_POST['assignments'] ?? '';
    $assigns_complete = isset($_POST['assigns_complete']) ? intval($_POST['assigns_complete']) : 0;
    $waiting_assigns = $_POST['waiting_assigns'] ?? '';
    
    $query = "UPDATE users SET name=?, email=?, dob=?, gender=?, phone=?, address=?, mother_name=?, mother_phone=?, father_name=?, father_phone=?, course=?, eagle_coins=?, assignments=?, assigns_complete=?, waiting_assigns=? WHERE id=?";
    
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssssssssssisiss", $name, $email, $dob, $gender, $phone, $address, $mother_name, $mother_phone, $father_name, $father_phone, $course, $eagle_coins, $assignments, $assigns_complete, $waiting_assigns, $student_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update student']);
        }
        $stmt->close();
    }
    exit;
}

// Handle Delete Student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_student') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in || $admin_role !== 'root') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $student_id = $_POST['id'] ?? '';
    if (empty($student_id)) {
        echo json_encode(['success' => false, 'message' => 'Student ID is required']);
        exit;
    }
    
    $query = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $student_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Student deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete student']);
        }
        $stmt->close();
    }
    exit;
}

// Handle Get All Admins (Root Only)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_admins') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in || $admin_role !== 'root') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $query = "SELECT username, role FROM admins ORDER BY username";
    $result = $conn->query($query);
    
    $admins = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
    }
    
    echo json_encode(['success' => true, 'data' => $admins]);
    exit;
}

// Handle Add Admin (Root Only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_admin') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in || $admin_role !== 'root') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = isset($_POST['role']) ? $_POST['role'] : 'admin';
    
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required']);
        exit;
    }
    
    $check_query = "SELECT username FROM admins WHERE username = ? LIMIT 1";
    $check_stmt = $conn->prepare($check_query);
    if ($check_stmt) {
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Username already exists']);
            $check_stmt->close();
            exit;
        }
        $check_stmt->close();
    }
    
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    $query = "INSERT INTO admins (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sss", $username, $hashed_password, $role);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Admin created successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create admin']);
        }
        $stmt->close();
    }
    exit;
}

// Handle Delete Admin (Root Only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_admin') {
    header('Content-Type: application/json');
    
    if (!$is_logged_in || $admin_role !== 'root') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $username = trim($_POST['username'] ?? '');
    if (empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Username is required']);
        exit;
    }
    
    $query = "DELETE FROM admins WHERE username=? AND role='admin'";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Admin deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete admin']);
        }
        $stmt->close();
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProWorldz - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #000000;
            --secondary: #ffffff;
            --accent: #0a0a0a;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --success: #10b981;
            --danger: #ef4444;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.15);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.2);
            --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            --font-body: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #000000 0%, #0f0f0f 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            font-family: var(--font-body);
            overflow-x: hidden;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            animation: slideUpFade 0.6s ease 0.1s both;
        }

        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            padding: 40px 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .login-logo {
            font-size: 48px;
            margin-bottom: 20px;
            display: inline-block;
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--text-secondary);
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--text-primary);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            color: var(--text-primary);
            font-family: var(--font-body);
            font-size: 14px;
            transition: var(--transition);
            outline: none;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.05);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            outline: none;
            text-decoration: none;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #d0d0d0 100%);
            color: #000000;
            border: none;
        }

        .btn-primary:hover:not(:disabled) {
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
            width: auto;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.5);
        }

        .btn-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.5);
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-top-color: #000000;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            animation: slideDownAlert 0.3s ease;
        }

        @keyframes slideDownAlert {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #86efac;
        }

        .hidden {
            display: none !important;
        }

        /* DASHBOARD STYLES */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: rgba(0, 0, 0, 0.6);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            padding: 30px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-logo {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo-icon {
            font-size: 28px;
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-logo-text h2 {
            font-size: 16px;
            font-weight: 700;
        }

        .sidebar-logo-text p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .nav-section {
            margin-bottom: 30px;
            padding: 0 15px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            padding: 0 10px;
            margin-bottom: 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
            position: relative;
            margin-bottom: 6px;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-link.active {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
            border-radius: 0 2px 2px 0;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 40px;
            overflow-y: auto;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .top-bar-title h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .top-bar-title p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
        }

        .user-role {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--text-primary);
        }

        .form-container {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group-full {
            margin-bottom: 20px;
        }

        .form-group-full textarea {
            min-height: 100px;
            font-family: var(--font-body);
            padding: 12px 16px;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .data-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 14px;
        }

        .data-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: rgba(0, 0, 0, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header h2 {
            font-size: 22px;
            font-weight: 700;
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 24px;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-btn:hover {
            color: var(--danger);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .info-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .info-value {
            font-size: 15px;
            color: var(--text-primary);
            font-weight: 500;
            word-break: break-word;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.5);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar {
                width: 250px;
                transform: translateX(-100%);
                transition: var(--transition);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<?php if (!$is_logged_in): ?>
<!-- LOGIN PAGE -->
<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1>ProWorldz Admin</h1>
            <p>Student Management System</p>
        </div>
        <div class="login-body">
            <div id="login-error" class="alert alert-danger hidden">
                <i class="fas fa-circle-exclamation"></i>
                <span id="error-text">Invalid credentials</span>
            </div>

            <div id="login-success" class="alert alert-success hidden">
                <i class="fas fa-check-circle"></i>
                <span id="success-text">Login successful!</span>
            </div>

            <form id="login-form" onsubmit="handleLogin(event)">
                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-input" placeholder="Enter username" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter password" required>
                </div>

                <button type="submit" class="btn btn-primary" id="login-button">
                    <span id="button-text">Login</span>
                    <div id="spinner" class="spinner hidden"></div>
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    function handleLogin(event) {
        event.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const button = document.getElementById('login-button');
        const spinner = document.getElementById('spinner');
        const errorDiv = document.getElementById('login-error');
        const successDiv = document.getElementById('login-success');
        const buttonText = document.getElementById('button-text');

        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');

        if (!username || !password) {
            errorDiv.classList.remove('hidden');
            document.getElementById('error-text').textContent = 'Username and password are required';
            return;
        }

        button.disabled = true;
        spinner.classList.remove('hidden');
        buttonText.textContent = 'Logging in...';

        const formData = new FormData();
        formData.append('action', 'login');
        formData.append('username', username);
        formData.append('password', password);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successDiv.classList.remove('hidden');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                errorDiv.classList.remove('hidden');
                document.getElementById('error-text').textContent = data.message || 'Invalid credentials';
                button.disabled = false;
                spinner.classList.add('hidden');
                buttonText.textContent = 'Login';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorDiv.classList.remove('hidden');
            button.disabled = false;
            spinner.classList.add('hidden');
            buttonText.textContent = 'Login';
        });
    }
</script>

<?php else: ?>
<!-- DASHBOARD -->
<div class="dashboard-wrapper">
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="sidebar-logo-text">
                <h2>ProWorldz</h2>
                <p>Admin Panel</p>
            </div>
        </div>

        <nav class="nav-section">
            <div class="nav-section-title">Menu</div>
            
            <?php if ($admin_role === 'root'): ?>
                <button class="nav-link active" onclick="showSection('student-entry')">
                    <i class="fas fa-user-plus"></i>
                    Student Entry
                </button>
                <button class="nav-link" onclick="showSection('student-management')">
                    <i class="fas fa-users"></i>
                    Student Management
                </button>
                <button class="nav-link" onclick="showSection('admin-management')">
                    <i class="fas fa-shield-alt"></i>
                    Admin Management
                </button>
            <?php else: ?>
                <button class="nav-link active" onclick="showSection('student-entry')">
                    <i class="fas fa-user-plus"></i>
                    Student Entry
                </button>
                <button class="nav-link" onclick="showSection('student-management')">
                    <i class="fas fa-users"></i>
                    Student Management
                </button>
            <?php endif; ?>

            <div class="nav-section-title" style="margin-top: 30px;">Account</div>
            <a href="?logout=true" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-title">
                <h1 id="page-title">Dashboard</h1>
                <p id="page-subtitle">Manage your system</p>
            </div>
            <div class="user-menu">
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($current_admin['username']); ?></div>
                    <div class="user-role"><?php echo strtoupper($admin_role); ?></div>
                </div>
                <div class="user-avatar"><?php echo strtoupper(substr($current_admin['username'], 0, 1)); ?></div>
            </div>
        </div>

        <!-- STUDENT ENTRY SECTION -->
        <div id="student-entry" class="content-section active">
            <h2 class="section-title">Add New Student</h2>
            <div class="form-container">
                <form id="student-form" onsubmit="addStudent(event)">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Student ID</label>
                            <input type="text" name="id" class="form-input" placeholder="Enter student ID" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-input" placeholder="Enter student name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-input" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-input" placeholder="Enter phone number">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-input">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <input type="text" name="course" class="form-input" placeholder="Enter course name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Eagle Coins</label>
                            <input type="number" name="eagle_coins" class="form-input" placeholder="0" value="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Mother Name</label>
                            <input type="text" name="mother_name" class="form-input" placeholder="Enter mother's name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mother Phone</label>
                            <input type="text" name="mother_phone" class="form-input" placeholder="Enter mother's phone">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Father Name</label>
                            <input type="text" name="father_name" class="form-input" placeholder="Enter father's name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Father Phone</label>
                            <input type="text" name="father_phone" class="form-input" placeholder="Enter father's phone">
                        </div>
                    </div>

                    <div class="form-group-full">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-input" placeholder="Enter student address"></textarea>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Student
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- STUDENT MANAGEMENT SECTION -->
        <div id="student-management" class="content-section">
            <h2 class="section-title">Student Management</h2>
            <div id="students-alert"></div>
            <div class="table-container">
                <table class="data-table" id="students-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Eagle Coins</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="students-tbody">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ADMIN MANAGEMENT SECTION (ROOT ONLY) -->
        <?php if ($admin_role === 'root'): ?>
        <div id="admin-management" class="content-section">
            <h2 class="section-title">Admin Management</h2>
            
            <div class="form-container">
                <h3 style="margin-bottom: 20px; font-size: 18px;">Add New Admin</h3>
                <form id="admin-form" onsubmit="addAdmin(event)">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-input" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-input" placeholder="Enter password" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-input" style="background-color: #000000;">
                                <option value="admin" style="color: white;">Admin</option>
                                <option value="root" style="color: white;">Root</option>
                            </select>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Admin
                        </button>
                    </div>
                </form>
            </div>

            <div id="admins-alert"></div>
            <div class="table-container">
                <table class="data-table" id="admins-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="admins-tbody">
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 40px;">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- STUDENT INFO MODAL -->
<div id="student-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Student Information</h2>
            <button class="close-btn" onclick="closeModal('student-modal')">×</button>
        </div>
        <div id="modal-body"></div>
        <div class="action-buttons" style="margin-top: 30px;">
            <?php if ($admin_role === 'root'): ?>
                <button class="btn btn-danger btn-sm" id="delete-btn" onclick="deleteStudent()">
                    <i class="fas fa-trash"></i> Delete Student
                </button>
                <button class="btn btn-success btn-sm" id="edit-btn" onclick="editStudent()">
                    <i class="fas fa-edit"></i> Edit Student
                </button>
            <?php endif; ?>
            <button class="btn btn-primary btn-sm" onclick="closeModal('student-modal')">Close</button>
        </div>
    </div>
</div>

<!-- EDIT STUDENT MODAL -->
<div id="edit-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Student</h2>
            <button class="close-btn" onclick="closeModal('edit-modal')">×</button>
        </div>
        <form id="edit-form" onsubmit="saveEditedStudent(event)">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" name="id" class="form-input" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-input">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Course</label>
                    <input type="text" name="course" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Eagle Coins</label>
                    <input type="number" name="eagle_coins" class="form-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Mother Name</label>
                    <input type="text" name="mother_name" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Mother Phone</label>
                    <input type="text" name="mother_phone" class="form-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Father Name</label>
                    <input type="text" name="father_name" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Father Phone</label>
                    <input type="text" name="father_phone" class="form-input">
                </div>
            </div>

            <div class="form-group-full">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-input"></textarea>
            </div>

            <div class="action-buttons" style="margin-top: 30px;">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="closeModal('edit-modal')">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStudentId = null;
    let allStudents = [];

    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(el => {
            el.classList.remove('active');
        });
        
        // Remove active class from all nav links
        document.querySelectorAll('.nav-link').forEach(el => {
            el.classList.remove('active');
        });
        
        // Show selected section
        document.getElementById(sectionId).classList.add('active');
        
        // Add active class to clicked nav link
        event.target.classList.add('active');

        // Update page title
        const titles = {
            'student-entry': { title: 'Add New Student', subtitle: 'Enter student information' },
            'student-management': { title: 'Student Management', subtitle: 'View and manage students' },
            'admin-management': { title: 'Admin Management', subtitle: 'Manage admin users' }
        };

        if (titles[sectionId]) {
            document.getElementById('page-title').textContent = titles[sectionId].title;
            document.getElementById('page-subtitle').textContent = titles[sectionId].subtitle;
        }

        // Load data if needed
        if (sectionId === 'student-management') {
            loadStudents();
        } else if (sectionId === 'admin-management') {
            loadAdmins();
        }
    }

    function addStudent(event) {
        event.preventDefault();
        
        const form = document.getElementById('student-form');
        const formData = new FormData(form);
        formData.append('action', 'add_student');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('students-alert', 'Student added successfully!', 'success');
                form.reset();
                setTimeout(() => loadStudents(), 1000);
            } else {
                showAlert('students-alert', data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('students-alert', 'An error occurred', 'danger');
        });
    }

    function loadStudents() {
        fetch('?action=get_students')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    allStudents = data.data;
                    displayStudents(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function displayStudents(students) {
        const tbody = document.getElementById('students-tbody');
        
        if (students.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 40px;">No students found</td></tr>';
            return;
        }

        tbody.innerHTML = students.map(student => `
            <tr>
                <td>${escapeHtml(student.id)}</td>
                <td>${escapeHtml(student.name)}</td>
                <td>${escapeHtml(student.email)}</td>
                <td>${escapeHtml(student.phone || '-')}</td>
                <td>${escapeHtml(student.course || '-')}</td>
                <td>${student.eagle_coins || 0}</td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="viewStudent('${escapeHtml(student.id)}')">
                        <i class="fas fa-info-circle"></i> Info
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function viewStudent(studentId) {
        const student = allStudents.find(s => s.id === studentId);
        if (!student) return;

        currentStudentId = studentId;

        const modalBody = document.getElementById('modal-body');
        modalBody.innerHTML = `
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Student ID</span>
                    <span class="info-value">${escapeHtml(student.id)}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">${escapeHtml(student.name)}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">${escapeHtml(student.email)}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">${escapeHtml(student.phone || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date of Birth</span>
                    <span class="info-value">${escapeHtml(student.dob || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gender</span>
                    <span class="info-value">${escapeHtml(student.gender || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Course</span>
                    <span class="info-value">${escapeHtml(student.course || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Eagle Coins</span>
                    <span class="info-value">${student.eagle_coins || 0}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Mother Name</span>
                    <span class="info-value">${escapeHtml(student.mother_name || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Mother Phone</span>
                    <span class="info-value">${escapeHtml(student.mother_phone || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Father Name</span>
                    <span class="info-value">${escapeHtml(student.father_name || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Father Phone</span>
                    <span class="info-value">${escapeHtml(student.father_phone || '-')}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Assignments Completed</span>
                    <span class="info-value">${student.assigns_complete || 0}</span>
                </div>
            </div>
            <div style="background: rgba(255,255,255,0.03); padding: 15px; border-radius: 10px; margin-top: 20px;">
                <span class="info-label">Address</span>
                <span class="info-value">${escapeHtml(student.address || '-')}</span>
            </div>
        `;

        openModal('student-modal');
    }

    function editStudent() {
        const student = allStudents.find(s => s.id === currentStudentId);
        if (!student) return;

        const form = document.getElementById('edit-form');
        form.querySelector('input[name="id"]').value = student.id;
        form.querySelector('input[name="name"]').value = student.name;
        form.querySelector('input[name="email"]').value = student.email;
        form.querySelector('input[name="phone"]').value = student.phone || '';
        form.querySelector('input[name="dob"]').value = student.dob || '';
        form.querySelector('select[name="gender"]').value = student.gender || '';
        form.querySelector('input[name="course"]').value = student.course || '';
        form.querySelector('input[name="eagle_coins"]').value = student.eagle_coins || 0;
        form.querySelector('input[name="mother_name"]').value = student.mother_name || '';
        form.querySelector('input[name="mother_phone"]').value = student.mother_phone || '';
        form.querySelector('input[name="father_name"]').value = student.father_name || '';
        form.querySelector('input[name="father_phone"]').value = student.father_phone || '';
        form.querySelector('textarea[name="address"]').value = student.address || '';

        closeModal('student-modal');
        openModal('edit-modal');
    }

    function saveEditedStudent(event) {
        event.preventDefault();
        
        const form = document.getElementById('edit-form');
        const formData = new FormData(form);
        formData.append('action', 'update_student');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('students-alert', 'Student updated successfully!', 'success');
                closeModal('edit-modal');
                setTimeout(() => loadStudents(), 1000);
            } else {
                showAlert('students-alert', data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('students-alert', 'An error occurred', 'danger');
        });
    }

    function deleteStudent() {
        if (!confirm('Are you sure you want to delete this student?')) return;

        const formData = new FormData();
        formData.append('action', 'delete_student');
        formData.append('id', currentStudentId);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('students-alert', 'Student deleted successfully!', 'success');
                closeModal('student-modal');
                setTimeout(() => loadStudents(), 1000);
            } else {
                showAlert('students-alert', data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('students-alert', 'An error occurred', 'danger');
        });
    }

    function addAdmin(event) {
        event.preventDefault();
        
        const form = document.getElementById('admin-form');
        const formData = new FormData(form);
        formData.append('action', 'add_admin');

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('admins-alert', 'Admin created successfully!', 'success');
                form.reset();
                setTimeout(() => loadAdmins(), 1000);
            } else {
                showAlert('admins-alert', data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('admins-alert', 'An error occurred', 'danger');
        });
    }

    function loadAdmins() {
        fetch('?action=get_admins')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayAdmins(data.data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function displayAdmins(admins) {
        const tbody = document.getElementById('admins-tbody');
        
        if (admins.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 40px;">No admins found</td></tr>';
            return;
        }

        tbody.innerHTML = admins.map(admin => `
            <tr>
                <td>${escapeHtml(admin.username)}</td>
                <td><span style="background: rgba(16,185,129,0.2); padding: 4px 8px; border-radius: 4px; font-size: 12px;">${admin.role.toUpperCase()}</span></td>
                <td>
                    ${admin.role === 'admin' ? `
                        <button class="btn btn-danger btn-sm" onclick="deleteAdmin('${escapeHtml(admin.username)}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    ` : '<span style="color: #a0a0a0;">-</span>'}
                </td>
            </tr>
        `).join('');
    }

    function deleteAdmin(username) {
        if (!confirm('Are you sure you want to delete this admin?')) return;

        const formData = new FormData();
        formData.append('action', 'delete_admin');
        formData.append('username', username);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('admins-alert', 'Admin deleted successfully!', 'success');
                setTimeout(() => loadAdmins(), 1000);
            } else {
                showAlert('admins-alert', data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('admins-alert', 'An error occurred', 'danger');
        });
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
    }

    function showAlert(containerId, message, type) {
        const container = document.getElementById(containerId);
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-circle-exclamation';
        
        container.innerHTML = `
            <div class="alert ${alertClass}">
                <i class="fas ${icon}"></i>
                <span>${escapeHtml(message)}</span>
            </div>
        `;

        setTimeout(() => {
            container.innerHTML = '';
        }, 5000);
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.remove('show');
            }
        });
    });
</script>

<?php endif; ?>

</body>
</html>