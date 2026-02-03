<?php
// The hash from your database
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

// The password to verify
$password = 'password123';

// Verify the password
if (password_verify($password, $hash)) {
    echo "Password is valid!";
    // Admin login successful
} else {
    echo "Invalid password!";
}