<?php
//session_start();

function register($name, $email, $password) {
    // Dummy storage sederhana
    if (!isset($_SESSION['users'])) {
        $_SESSION['users'] = [];
    }

    if (empty($name) || empty($email) || empty($password)) {
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Password minimal 8 karakter, harus ada huruf dan angka
    if (strlen($password) < 8 || 
        !preg_match('/[a-zA-Z]/', $password) || 
        !preg_match('/\d/', $password)) {
        return false;
    }

    if (isset($_SESSION['users'][$email])) {
        return false; // email sudah terdaftar
    }

    $_SESSION['users'][$email] = [
        'name' => $name,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    return true;
}

?>

