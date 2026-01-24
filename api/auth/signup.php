<?php
include_once "dbconf.php";
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dbconf = new DBconfig();
$con = $dbconf->check_con();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['result' => 500]);
    exit;
}

$name   = $_POST['student-name'] ?? '';
$gender = $_POST['gender'] ?? '';
$phone  = $_POST['phone'] ?? '';
$email  = $_POST['email'] ?? '';
$passw  = $_POST['passw'] ?? '';

if (!$name || !$gender || !$phone || !$email || !$passw) {
    echo json_encode(['result' => 422]);
    exit;
}

// CHECK IF USER EXISTS
$check = $con->prepare("SELECT id FROM users WHERE email=? OR phone=?");
$check->bind_param("ss", $email, $phone);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['result' => 409]);
    exit;
}

// HASH PASSWORD
$hashed = password_hash($passw, PASSWORD_BCRYPT);

$id = random_int(100000, 999999);
$ip = file_get_contents('https://api.ipify.org');

$con->begin_transaction();

try {
    // INSERT USER
    $q1 = $con->prepare(
        "INSERT INTO users (id,name,gender,phone,email,passw,IPADDR)
         VALUES (?,?,?,?,?,?,?)"
    );
    $q1->bind_param("sssssss", $id,$name,$gender,$phone,$email,$hashed,$ip);
    $q1->execute();

    // INSERT COURSE
    $q2 = $con->prepare("INSERT INTO course (id) VALUES (?)");
    $q2->bind_param("s", $id);
    $q2->execute();

    $con->commit();
    echo json_encode(['result' => 200]);

} catch (Exception $e) {
    $con->rollback();
    echo json_encode(['result' => 500]);
}
