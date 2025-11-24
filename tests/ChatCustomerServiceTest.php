<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../src/ChatCustomerService.php';

class ChatCustomerServiceTest extends TestCase
{
    public function testPilihPusatBantuan(): void
    {
        $result = pilihPusatBantuan();
        $this->assertEquals(expected: "Opsi pusat bantuan berhasil dipilih", actual: $result);
    }

    public function testDenganCSSaatPunyaPesanan():void
    {
        $result = chatDenganCS(hasOrder: true); //true = punya pesanan
        $this->assertEquals(expected: "Chat dengan cs terkait pesanan Anda dimulai", actual: $result);
    }

    public function testChatDenganCSSaatTidakPunyaPesanan(): void
    {
        $result = chatDenganCS(hasOrder: false); //false = tidak punya pesanan
        $this->assertEquals(expected: "Chat dengan CS umum dimulai (tidak ada pesanan)", actual: $result);
    }
}
?>