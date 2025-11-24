<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Registrasi.php';

class RegistrasiTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset session sebelum tiap test
        $_SESSION['users'] = [];
    }

    //TC01 - Memasukkan email valid, melengkapi data diri, membuat password dengan 8 karakter kombinasi huruf-angka
    public function testRegisterSuccess()
    {
        $this->assertTrue(register('Lailla Nurulita', 'laillanurulita@gmail.com', 'Lailla04'));
    }

    //TC02 - Memasukkan email valid, melengkapi data diri, membuat password dengan 7 karakter
    public function testRegisterShortPassword()
    {
        $this->assertFalse(register('Lailla Nurulita', 'laillanurulita@gmail.com', 'masa123'));
    }
}
?>