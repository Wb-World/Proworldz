<?php
session_start();
include_once "../dbconf.php";
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$db = new DBconfig();
$conn = $db->check_con();

if(!is_string($conn)){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $mail = $_POST['mail-login'];
        $passw = $_POST['passw-login'];
        $q = $conn->prepare("SELECT id FROM `users` WHERE email = ? AND passw = ?");
        $q->bind_param("ss",$mail,$passw);
        $q->execute();
        $getres = $q->get_result();

        if($getres->num_rows > 0){
            $datas = $getres->fetch_assoc();
            $_SESSION['id'] = $datas['id'];
            echo json_encode(['result' => $datas['id']]);
        } else echo json_encode(['result' => null]);
    }
} else echo json_encode(['result' => null]);
?>