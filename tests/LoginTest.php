<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/login.php';
require_once __DIR__ . '/../src/Registrasi.php'; // tambahkan ini

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        session_start();
        $_SESSION['users'] = [];
        // Daftarkan user "Lailla" sebelum tiap test login
        register('Lailla Nurulita', 'laillanurulita@gmail.com', 'Lailla04');
    }

    //TC03 - Mengisi email dan password yang terdaftar
    public function testLoginBerhasil() {
        $login = new Login();
        $result = $login->authenticate("laillanurulita@gmail.com", "Lailla04");
        $this->assertEquals("Login berhasil", $result);
    }

    //TC04 - mengisi email terdaftar dan password salah
    public function testLoginGagalPasswordSalah() {
        $login = new Login();
        $result = $login->authenticate("laillanurulita@gmail.com", "apaya12");
        $this->assertEquals("Email atau password tidak sesuai", $result);
    }
}