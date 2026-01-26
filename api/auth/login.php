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
        
        // 1. Email validation using ZeroBounce API
        $zerobounceApiKey = 'af3bcaaeec3446f486d806e8b6a1b773';
        $isEmailValid = validateEmailWithZeroBounce($mail, $zerobounceApiKey);
        
        if($isEmailValid !== true){
            // http_response_code(203);
            echo json_encode(['result' => 203]);
            exit();
        }
        
        // 2. Get client's real IP using ipify API
        $clientIP = getClientIP();
        
        $q = $conn->prepare("SELECT id FROM `users` WHERE email = ? AND passw = ?");
        $q->bind_param("ss",$mail,$passw);
        $q->execute();
        $getres = $q->get_result();

        if($getres->num_rows > 0){
            $datas = $getres->fetch_assoc();
            if(isset($datas)){
                $_SESSION['id'] = $datas['id'];
                
                // 3. Insert IP address using existing upload_data function
                if(isset($_SESSION['id'])){
                    $db->upload_data('IPADDR', $clientIP, $_SESSION['id']);
                    
                    echo json_encode([
                        'result' => $datas['id']
                    ]);
                } else echo json_encode(['result' => 'Try again']);
            }
        } else echo json_encode(['result' => null]);
    }
} else echo json_encode(['result' => null]);

// ZeroBounce email validation function
function validateEmailWithZeroBounce($email, $apiKey) {
    $apiUrl = "https://api.zerobounce.net/v2/validate";
    $requestUrl = $apiUrl . "?api_key=" . urlencode($apiKey) . "&email=" . urlencode($email);

    $ch = curl_init($requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($response === false || $httpCode !== 200) {
        return true; // Allow login if API fails
    }

    $data = json_decode($response, true);
    
    if(isset($data['error'])) {
        return true; // Allow login on API errors
    }

    $status = $data['status'] ?? 'unknown';
    $validStatuses = ['valid'];
    $invalidStatuses = ['invalid', 'spamtrap', 'abuse', 'do_not_mail'];
    
    if(in_array($status, $validStatuses)) {
        return true;
    } elseif(in_array($status, $invalidStatuses)) {
        return false;
    } else {
        return false;
    }
}

// Get client IP using ipify API
function getClientIP() {
    $ipifyUrl = "https://api.ipify.org?format=json";
    
    $ch = curl_init($ipifyUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if($response !== false) {
        $data = json_decode($response, true);
        if(isset($data['ip'])) {
            return $data['ip'];
        }
    }
    
    // Fallback to $_SERVER if ipify fails
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    
    return $ip;
}
?>