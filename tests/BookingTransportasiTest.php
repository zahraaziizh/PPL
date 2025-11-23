<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../src/BookingTransportasi.php';

class BookingTransportasiTest extends TestCase
{
    //TC07 - Mengisi waktu,asal, tujuan, dan jumlah kursi 
    public function testMengisiFormulirBooking()
    {
        $hasil = bookingTransportasi("Solo Balapan", "Gambir", "2025-09-25", 1);
        $this->assertIsArray($hasil);
        $this->assertEquals("Solo Balapan", $hasil['asal']);
        $this->assertEquals("Gambir", $hasil['tujuan']);
        $this->assertEquals("2025-09-25", $hasil['waktu']);
        $this->assertEquals(1, $hasil['kursi']);
    }
    //TC08 - Mengisi waktu,asal, tujuan, dan jumlah kursi di waktu hari ini  
    public function testBookingHariIni()
    {
        $today = date("Y-m-d");
        $hasil = bookingTransportasi("Solo Balapan", "Gambir", $today, 1);
        $this->assertEquals($today, $hasil['waktu']);
    }
    //TC09 - Menfilter pilihan tiket berdasarkan kategori
    public function testFilterTiketAdaHasil()
    {
        $tiket = [
            ["id" => 1, "kategori" => "Ekonomi", "time" => "06.00 - 12.00"],
            ["id" => 2, "kategori" => "Bisnis", "time" => "00.00 - 06.00"]
        ];

        $hasil = filterTiket("Ekonomi", "06.00 - 12.00", $tiket);
        $this->assertCount (1, $hasil);
        $this->assertEquals("Ekonomi", $hasil[0]['kategori']);
        $this->assertEquals("06.00 - 12.00", $hasil[0]['time']);
    }
    //TC10 - Menfilter pilihan tiket berdasarkan kategori namun tidak ada tiket yang sesuai dengan filter
    public function testFilterTiketTidakAdaHasil()
    {
        $tiket = [
             ["id" => 1, "kategori" => "Ekonomi", "time" => "06.00 - 12.00"],
            ["id" => 2, "kategori" => "Bisnis", "time" => "00.00 - 06.00"]
        ];

        $hasil = filterTiket("Ekonomi", "00.00 - 06.00", $tiket);
        $this->assertEmpty($hasil);
    }
    //TC11 - Memilih tiket yang ingin dibooking
    public function testPilihJenisTiketBooking()
    {
        $tiket = [
            ["id" => 1, "kategori" => "pesawat"],
            ["id" => 2, "kategori" => "bus"]
        ];

        $hasil = pilihTiket(1, $tiket);
        $this->assertNotNull($hasil);
        $this->assertEquals(1, $hasil['id']);
        $this->assertEquals("pesawat", $hasil['kategori']);
    }
}
