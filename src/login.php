<?php
//session_start();

class Login {
    public function authenticate($email, $password) {
        if (!isset($_SESSION['users'][$email])) {
            return "Email atau password tidak sesuai";
        }

        $hash = $_SESSION['users'][$email]['password'];
        if (password_verify($password, $hash)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;   
            return "Login berhasil";
        }

        return "Email atau password tidak sesuai";
    }
}
?>
