<?php
ob_clean(); // Clear any previous output
// error_reporting(1); // Disable error display (they can break JSON)
// ini_set('display_errors', 1);

session_start();
include_once "dbconf.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$db = new DBconfig();
$con = $db->check_con();

function get_course($con) {

    if (!isset($_SESSION['current-student'])) {
        echo json_encode(['error' => 'User not logged in']);
        return;
    }

    $username = $_SESSION['current-student'];
    // $username = 'mohamed';

    $sql = "
    SELECT c.course_name, c.description, c.is_complete, c.assignment_completion, c.total_assigns
    FROM course c
    INNER JOIN users u ON u.id = c.id
    WHERE u.name = ?
    ";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        if(count($row) == 0){
            echo json_encode(['result' => 'No Course found']);
            break;
        }
        else echo json_encode(['result' => $row]);
    }

    
}

get_course($con);

