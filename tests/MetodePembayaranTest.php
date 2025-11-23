<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../src/MetodePembayaran.php';

class MetodePembayaranTest extends TestCase
{
    //TC12 - Memilih metode pembayaran
    public function testPilihMetodePembayaran(): void
    {
        $result = pilihMetodePembayaran("Kartu Kredit");
        $this->assertEquals(expected: "Metode pembayaran Kartu Kredit berhasil dipilih", actual: $result);
    }
    //TC13 - Melakukan pembayaran dengan kartu kredit yang valid
    public function testPembayaranKartuKreditValid(): void
    {
        $hasil = pembayaranKartuKredit(nama: "Citra", nomorKartu: "1234567812345678", cvv: "123");
        $this->assertEquals(expected: "Transaksi dengan kartu kredit atas nama Citra berhasil", actual: $result);
    }

    public function testPembayaranKartuKreditInvalid(): void 
    {
        $result = pembayaranKartuKredit(nama: "Citra", nomorKartu: "0097", cvv: "00");
        $this->assertEquals(expected: "Nomor kartu kredit atau CVV tidak valid", actual: $result);
    }

    public function testPembayaranTransferBank(): void
    {
        $result = pembayaranTransferBank(bank: "BRI", nomorRekening: "1234567890");
        $this->assertEquals(expected: "Transaksi transfer bank ke BRI dengan rekening 1234567890 berhasil", actual: $result);
    }
}
?>