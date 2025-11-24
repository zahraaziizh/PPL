<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/history.php';

class historyTest extends TestCase {

    //TC37 - membuka history saat Login
    public function testHistorySaatLogin() {
        $history = new history();
        $history->login();

        $result = $history->getHistory();

        $this->assertIsArray($result, "Saat login, harus bisa buka history");
        $this->assertNotEmpty($result, "History tidak boleh kosong saat login");
    }

    //TC38 - membuka history tanpa Login
    public function testHistoryTanpaLogin() {
        $history = new history();

        $result = $history->getHistory();

        $this->assertNull($result, "Tanpa login, tidak boleh ada tombol Purchase List");
    }

    //TC39 - memfilter kategori history
    public function testFilterHistoryKategoriHotel() {
        $history = new history();
        $history->login();

        $result = $history->filterHistory("hotel");

        $this->assertNotEmpty($result, "Filter kategori hotel harus mengembalikan data");
        foreach ($result as $order) {
            $this->assertEquals("hotel", $order["kategori"], "Semua history harus kategori hotel");
        }
    }
}
