<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../src/PusatBantuan.php';

class PusatBantuanTest extends TestCase{
    public function testCariTopik(){
        $bantuan = new PusatBantuan();
        $hasil = $bantuan->cariTopik("refund");
        $this->assertContains("Refund Tiket", $hasil);
        $this->assertContains("Refund Hotel", $hasil);
    }

    public function testPilihTopikPopuler(){
        $bantuan = new PusatBantuan();
        $hasil = $bantuan->pilihTopik("Reschedule Tiket");
        $this->assertEquals("Reschedule Tiket", $hasil);
    }

    public function testPilihProduk(){
        $bantuan = new PusatBantuan();
        $hasil = $bantuan->pilihProduk("Rental Mobil");
        $this->assertEquals("Rental Mobil", $hasil);
    }

    public function testHubungiKamiDenganPesanan() {
        $bantuan = new PusatBantuan();
        $pesan = $bantuan->hubungiKami(hasOrder: true);
        $this->assertEquals("Chat dengan cs terkait pesanan Anda dimulai", $pesan);
    }

    public function testHubungiKamiTanpaPesanan() {
        $bantuan = new PusatBantuan();
        $pesan = $bantuan->hubungiKami(hasOrder: false);
        $this->assertEquals("Chat dengan CS umum dimulai (tidak ada pesanan)", $pesan);
    }
}
?>