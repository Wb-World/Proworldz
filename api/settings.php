<?php
// api/settings.php
require_once __DIR__ . '/../dbconf.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Create database connection
try {
    $db = new DBconfig();
    $conn = $db->check_con();
    
    // Check if connection is valid
    if (!$conn || is_string($conn)) {
        throw new Exception('Database connection failed');
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection error: ' . $e->getMessage(),
        'debug' => ['error' => $e->getMessage()]
    ]);
    exit();
}

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Function to validate user ID
function validateUserId($id) {
    return !empty($id) && is_string($id) && preg_match('/^[A-Za-z0-9_-]+$/', $id);
}

// Function to validate name
function validateName($name) {
    return !empty($name) && strlen($name) >= 2 && strlen($name) <= 100;
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different request methods
switch ($method) {
    case 'GET':
        handleGetRequest();
        break;
        
    case 'POST':
        handlePostRequest();
        break;
        
    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Method not allowed',
            'allowed_methods' => ['GET', 'POST']
        ]);
        http_response_code(405);
        break;
}

function handleGetRequest() {
    global $conn;
    
    // Get action and ID from query parameters
    $action = $_GET['action'] ?? '';
    $userId = $_GET['id'] ?? '';
    
    if ($action !== 'get') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid action for GET request',
            'valid_actions' => ['get']
        ]);
        http_response_code(400);
        return;
    }
    
    if (!validateUserId($userId)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID format',
            'hint' => 'User ID should contain only letters, numbers, hyphens, and underscores'
        ]);
        http_response_code(400);
        return;
    }
    
    // Fetch user data
    try {
        $db = new DBconfig();
        $fields = ['id', 'name', 'gender', 'phone', 'email', 'IPADDR', 'eagle_coins', 'assignments', 'course'];
        $userData = $db->getUserInfo($userId, $fields);
        
        if (!$userData) {
            // User not found, return error
            echo json_encode([
                'status' => 'error',
                'message' => 'User not found',
                'user_id' => $userId
            ]);
            http_response_code(404);
            return;
        }
        
        // Add client IP for demonstration (in real app, this would come from session)
        $userData['IPADDR'] = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        
        // Add timestamp
        $userData['last_updated'] = date('Y-m-d H:i:s');
        $userData['timestamp'] = time();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'User data retrieved successfully',
            'user' => $userData,
            'meta' => [
                'request_time' => date('Y-m-d H:i:s'),
                'api_version' => '1.0',
                'endpoint' => 'settings/get'
            ]
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database query failed',
            'debug' => ['error' => $e->getMessage()]
        ]);
        http_response_code(500);
    }
}

function handlePostRequest() {
    global $conn;
    
    // Get the raw POST data
    $rawData = file_get_contents("php://input");
    
    // Try to decode as JSON
    $data = json_decode($rawData, true);
    
    // If JSON decode failed, check for form data
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle as regular POST data (for file uploads, etc.)
        $data = $_POST;
    }
    
    $action = $data['action'] ?? '';
    
    switch ($action) {
        case 'update':
            handleUpdateAction($data);
            break;
            
        case 'upload':
            handleUploadAction();
            break;
            
        default:
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid action specified',
                'valid_actions' => ['update', 'upload']
            ]);
            http_response_code(400);
            break;
    }
}

function handleUpdateAction($data) {
    global $conn;
    
    $userId = $data['id'] ?? '';
    $newName = $data['name'] ?? '';
    
    // Validate input
    if (!validateUserId($userId)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
        http_response_code(400);
        return;
    }
    
    if (!validateName($newName)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid name. Name must be 2-100 characters long.'
        ]);
        http_response_code(400);
        return;
    }
    
    // Sanitize name
    $sanitizedName = sanitizeInput($newName);
    
    try {
        // Check if user exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
        $checkStmt->bind_param("s", $userId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows === 0) {
            $checkStmt->close();
            echo json_encode([
                'status' => 'error',
                'message' => 'User not found'
            ]);
            http_response_code(404);
            return;
        }
        $checkStmt->close();
        
        // Update user name
        $updateStmt = $conn->prepare("UPDATE users SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $updateStmt->bind_param("ss", $sanitizedName, $userId);
        
        if ($updateStmt->execute()) {
            if ($updateStmt->affected_rows > 0) {
                // Get updated user data
                $db = new DBconfig();
                $fields = ['id', 'name', 'gender', 'phone', 'email', 'IPADDR', 'eagle_coins', 'assignments', 'course'];
                $updatedUser = $db->getUserInfo($userId, $fields);
                
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Profile updated successfully',
                    'user' => $updatedUser,
                    'changes' => [
                        'field' => 'name',
                        'old_value' => 'Retrieved from original data',
                        'new_value' => $sanitizedName
                    ],
                    'meta' => [
                        'update_time' => date('Y-m-d H:i:s'),
                        'timestamp' => time()
                    ]
                ]);
            } else {
                // No rows affected (same name or other issue)
                echo json_encode([
                    'status' => 'success',
                    'message' => 'No changes detected or user not found',
                    'note' => 'Name may already be the same'
                ]);
            }
        } else {
            throw new Exception($updateStmt->error);
        }
        
        $updateStmt->close();
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Update failed',
            'debug' => ['error' => $e->getMessage()]
        ]);
        http_response_code(500);
    }
}

function handleUploadAction() {
    // This function would handle profile image uploads
    // For now, return a placeholder response
    
    $userId = $_POST['id'] ?? '';
    
    if (!validateUserId($userId)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
        http_response_code(400);
        return;
    }
    
    // Check if file was uploaded
    if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No file uploaded or upload error',
            'upload_error' => $_FILES['profile_image']['error'] ?? 'No file'
        ]);
        return;
    }
    
    // This is a placeholder - implement actual file upload logic here
    echo json_encode([
        'status' => 'success',
        'message' => 'File upload endpoint ready',
        'note' => 'Implement file upload logic here',
        'received_file' => $_FILES['profile_image']['name'] ?? 'No file'
    ]);
}

// Close database connection
if (isset($conn) && is_object($conn) && method_exists($conn, 'close')) {
    $conn->close();
}

// Function to get the base URL
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    return $protocol . $host;
}
?>