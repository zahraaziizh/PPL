<?php
session_start();
if (!($_SESSION['logged_in'] ?? false)) {
    die('Akses ditolak. Silakan login dulu.');
}
?>
<h1>Selamat Datang!</h1>
<p>Anda berhasil login, <?= htmlspecialchars($_SESSION['email']) ?>!</p>