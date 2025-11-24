<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/RentalMobil.php';

class RentalMobilTest extends TestCase
{
    public function testCariTiketLengkap()
    {
        $rental = new RentalMobil();
        $result = $rental->searchTicket(true, "Jakarta", "2025-10-05 08:00", "2025-10-06 08:00");
        $this->assertStringContainsString("Dengan sopir", $result);
        $this->assertStringContainsString("Lokasi : Jakarta", $result);
    }

    public function testCariTiketTanpaLokasi()
    {
        $rental = new RentalMobil();
        $result = $rental->searchTicket(false, "", "2025-10-05", "2025-10-06");
        $this->assertEquals("Data tidak lengkap!", $result);
    }

    public function testPilihMobil()
    {
        $rental = new RentalMobil();
        $this->assertEquals("Mobil yang dipilih : Avanza", $rental->pilihMobil("Avanza"));
    }
}