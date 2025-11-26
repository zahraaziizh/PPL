<?php

use PHPUnit\Framework\TestCase;

// Mulai session sekali (PHPunit biasanya tidak otomatis start session)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/IntegrationRegisLogin.php';

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
        // Panggil fungsi integrasi: registrasi + auto-login dalam SATU alur
        $result = registerAndLogin('Lailla Nurulita', 'laillanurulita@gmail.com', 'Lailla04');

        // Verifikasi hasil integrasi
        $this->assertTrue($result['success'], 'Integrasi registrasi dan login harus berhasil');
        $this->assertEquals('Registrasi dan login berhasil', $result['message']);

        // Verifikasi session login aktif (bukti login benar-benar terjadi)
        $this->assertTrue($_SESSION['logged_in'], 'Session logged_in harus aktif');
        $this->assertEquals('laillanurulita@gmail.com', $_SESSION['email'], 'Email session tidak sesuai');
    }
}