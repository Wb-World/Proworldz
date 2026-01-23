<?php
include_once 'dbconf.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$db = new DBconfig();
$conn = $db->check_con();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!is_string($conn)) {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo json_encode(['error' => 'User ID is required']);
            exit;
        }
        
        $id = $_GET['id'];
        $info = $db->getUserInfo($id, ['name', 'eagle_coins']);
        
        if ($info) {
            echo json_encode($info);
        } else {
            echo json_encode(['error' => 'User not found']);
        }
    } else {
        echo json_encode(['error' => 'Database connection failed']);
    }
    exit;
}

// Handle OPTIONS for CORS preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Handle other HTTP methods
http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);