<?php
function getClientIP() {
    // Try external API first
    try {
        $response = @file_get_contents("https://api.ipify.org?format=json");
        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['ip'])) {
                return $data['ip'];
            }
        }
    } catch (Exception $e) {
        // Continue to fallback methods
    }
    
    // Fallback to server variables
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwarded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($forwarded[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    
    return $_SERVER['REMOTE_ADDR'];
}

echo getClientIP();