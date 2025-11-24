<?php
// src/Integration.php

require_once __DIR__ . '/Registrasi.php';
require_once __DIR__ . '/Login.php';

function registerAndLogin(string $name, string $email, string $password): array {
    // Langkah 1: Registrasi
    $registered = register($name, $email, $password);
    
    if (!$registered) {
        return ['success' => false, 'message' => 'Registrasi gagal'];
    }

    // Langkah 2: Login
    $login = new Login();
    $result = $login->authenticate($email, $password);

    if ($result === "Login berhasil") {
        return ['success' => true, 'message' => 'Registrasi dan login berhasil'];
    } else {
        return ['success' => false, 'message' => $result];
    }
}