<?php
//INTEGRASI TESTING - TC04
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/PromoDiskon.php';

class PromoDiskonTest extends TestCase
{
    protected function setUp(): void
    {
        //setiap test dimulai kondisi fresh
        PromoDiskon::resetPromo();
    }

    public function testKodePromoValid(): void 
    {
        $result = PromoDiskon::gunakanKodePromo(kode: "PROMO10");
        $this->assertEquals(expected:"Kode promo PROMO10 berhasil digunakan, diskon 10% telah diberikan", actual: $result);
    }

    public function testKodePromoExpired(): void 
    {
        $result = PromoDiskon::gunakanKodePromo(kode: "PROMO20");
        $this->assertEquals(expected:"Kode promo PROMO20 sudah expired", actual: $result);
    }

    public function testKodePromoDipakaiDuaKali(): void 
    {
        //pakai pertama kali
        PromoDiskon::gunakanKodePromo(kode: "PROMO10");
        //pakai kedua kali
        $result = PromoDiskon::gunakanKodePromo(kode: "PROMO10");
        $this->assertEquals(expected:"Kode promo PROMO10 sudah pernah digunakan", actual: $result);
    }
}
?>