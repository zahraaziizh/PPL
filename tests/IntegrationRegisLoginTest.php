<?php

use PHPUnit\Framework\TestCase;

// Mulai session sekali (PHPunit biasanya tidak otomatis start session)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/Registrasi.php';
require_once __DIR__ . '/../src/Login.php';

class IntegrationRegisLoginTest extends TestCase
{
    protected function setUp(): void
    {
        // Pastikan session bersih sebelum tiap test
        $_SESSION = [];
    }

    //TC-INT-01: Registrasi sukses → Login sukses dengan data yang sama
    public function testRegisterThenLoginSuccess()
    {
        // 1. Registrasi pengguna baru
        $registered = register('Lailla Nurulita', 'laillanurulita@gmail.com', 'Lailla04');
        $this->assertTrue($registered, 'Registrasi harus berhasil');

        // 2. Login dengan kredensial yang sama
        $login = new Login();
        $result = $login->authenticate('laillanurulita@gmail.com', 'Lailla04');

        // 3. Verifikasi hasil login dan keberadaan session
        $this->assertEquals('Login berhasil', $result);
        $this->assertTrue($_SESSION['logged_in']);
        $this->assertEquals('laillanurulita@gmail.com', $_SESSION['email']);
    }
}