<?php
// tasks.php
session_start();
require_once 'dbconf.php';

header('Content-Type: application/json');

// if(!isset($_SESSION['id'])) {
//     echo json_encode(['success' => false, 'message' => 'Not authenticated']);
//     exit;
// }

$userId = 'PWZ-210';
$db = new DBconfig();

if(!$db->check_con()) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get tasks from database
$gettasksinfo = $db->get_tasks($userId,'all');
echo json_encode(['status' => $gettasksinfo]);
?>