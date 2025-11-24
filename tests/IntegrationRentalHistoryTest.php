<?php

use PHPUnit\Framework\TestCase;

// Pastikan session aktif untuk shared data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/RentalMobil.php';
require_once __DIR__ . '/../src/history.php';

class IntegrationRentalHistoryTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset session agar tidak terpengaruh test sebelumnya
        $_SESSION = [];
    }

    public function testTransaksiRentalMobilMunculDiHistory()
    {
        $rental = new RentalMobil();
        
        $rental->searchTicket(
            withDriver: true,
            location: "Yogyakarta",
            startDate: "2025-11-25 08:00",
            endDate: "2025-11-27 18:00"
        );

        $result = $rental->pilihMobil("Avanza");
        $this->assertEquals("Mobil yang dipilih : Avanza", $result);

        $history = new history();
        $history->login(); // Harus login dulu untuk akses history

        $riwayat = $history->getHistory();
        $this->assertIsArray($riwayat, "History harus berupa array setelah login");

        $pemesananRental = array_filter($riwayat, function($item) {
            return $item['kategori'] === 'rental mobil';
        });

        $this->assertNotEmpty($pemesananRental, "Harus ada minimal 1 pemesanan rental mobil di history");
         $this->assertCount(1, $pemesananRental, "Harus tepat 1 pemesanan rental mobil");

        $pemesanan = reset($pemesananRental);
        $detail = $pemesanan['detail'] ?? [];

        $this->assertEquals("Avanza", $detail['mobil'] ?? null);
        $this->assertEquals("Yogyakarta", $detail['lokasi'] ?? null);
        $this->assertEquals("2025-11-25 08:00", $detail['mulai'] ?? null);
        $this->assertTrue($pemesanan['kategori'] === 'rental mobil');
    }
}