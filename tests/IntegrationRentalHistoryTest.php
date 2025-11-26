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
       $db = Database::getInstance()->getConnection();
        $db->exec("DELETE FROM orders");

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
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

        $pemesanan = reset($pemesananRental);
        $this->assertArrayHasKey('tanggal', $pemesanan);
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2}/', $pemesanan['tanggal']);
        $detail = $pemesanan['detail'] ?? [];

        $this->assertEquals("Avanza", $detail['mobil'] ?? null);
        $this->assertEquals("Yogyakarta", $detail['lokasi'] ?? null);
        $this->assertEquals("2025-11-25 08:00", $detail['mulai'] ?? null);
        $this->assertEquals("2025-11-27 18:00", $detail['selesai'] ?? null);
        $this->assertTrue($pemesanan['kategori'] === 'rental mobil');
    }
}