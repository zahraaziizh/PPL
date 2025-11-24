<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/BookingHotel.php';

class BookingHotelTest extends TestCase
{
    //data booking lengkap & valid
    public function testBookingHotelValid(): void 
    {
        $lokasi = "Bali";
        $checkin = date(format: "Y-m-d", timestamp: strtotime("+1 day")); //besok
        $checkout = date(format: "Y-m-d", timestamp: strtotime("+3 days")); //3 hari lagi
        $jumlahKamar = 2;

        $result = bookingHotel(lokasi: $lokasi, checkin: $checkin, checkout: $checkout, jumlahKamar: $jumlahKamar);
        
        $this->assertIsArray(actual: $result);
        $this->assertEquals(expected: "Bali", actual: $result["lokasi"]);
        $this->assertEquals(expected: $checkin, actual: $result["checkin"]);
    }

    //tanggal check-in < hari ini
    public function testBookingHotelTanggalCheckinInvalid(): void 
    {
        $lokasi = "Bali";
        $checkin = date(format: "Y-m-d", timestamp: strtotime("-1 day")); //kemarin
        $checkout = date(format: "Y-m-d", timestamp: strtotime("+2 days")); //besok lusa
        $jumlahKamar = 1;

        $result = bookingHotel(lokasi: $lokasi, checkin: $checkin, checkout: $checkout, jumlahKamar: $jumlahKamar);
        
        $this->assertEquals(expected: "Tanggal check-in tidak valid", actual: $result);
    }

    public function testBookingHotelDenganPromoValid(): void
    {
        PromoDiskon::resetPromo(); // pastikan fresh

        $lokasi = "Bali";
        $checkin = date("Y-m-d", strtotime("+1 day"));
        $checkout = date("Y-m-d", strtotime("+3 days")); // 2 malam
        $jumlahKamar = 1;
        $kodePromo = "PROMO10";

        $result = bookingHotel($lokasi, $checkin, $checkout, $jumlahKamar, $kodePromo);

        $this->assertIsArray($result);
        $this->assertEquals(10, $result['diskonPersen']);
        $this->assertEquals(2000000, $result['totalSebelumDiskon']); // 2 malam × 1 kamar × 1jt
        $this->assertEquals(200000, $result['totalDiskon']);        // 10% dari 2jt
        $this->assertEquals(1800000, $result['totalSetelahDiskon']);
        $this->assertStringContainsString("berhasil digunakan", $result['pesanPromo']);
    }

    public function testBookingHotelDenganPromoExpired(): void
    {
        PromoDiskon::resetPromo();

        $lokasi = "Jakarta";
        $checkin = date("Y-m-d", strtotime("+1 day"));
        $checkout = date("Y-m-d", strtotime("+2 days"));
        $jumlahKamar = 1;
        $kodePromo = "PROMO20"; // expired di 2024

        $result = bookingHotel($lokasi, $checkin, $checkout, $jumlahKamar, $kodePromo);

        $this->assertIsString($result);
        $this->assertStringContainsString("Gagal menerapkan promo", $result);
        $this->assertStringContainsString("sudah expired", $result);
    }
}
?>