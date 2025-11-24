<?php
//INTEGRASI TESTING - TC03

use PHPUnit\Framework\TestCase;
require __DIR__ . '/../src/IntegrasiBookingPembayaran.php';

class IntegrasiBookingPembayaranTest extends TestCase
{
    private array $tiketTersedia;

    protected function setUp(): void
    {
        $this->tiketTersedia = [
            [
                'id' => 1,
                'kategori' => 'Ekonomi',
                'time' => '06.00 - 12.00',
                'asal' => 'Solo Balapan',
                'tujuan' => 'Gambir',
                'harga' => 150000
            ],
            [
                'id' => 2,
                'kategori' => 'Bisnis',
                'time' => '12.00 - 18.00',
                'asal' => 'Surabaya',
                'tujuan' => 'Jakarta',
                'harga' => 300000
            ]
        ];
    }

    public function testBookingDanPembayaranKartuKreditBerhasil(): void
    {
        $hasil = prosesBookingDanPembayaran(
            'Solo Balapan', 'Gambir', '2025-11-25', 1,
            1, $this->tiketTersedia,
            'kartu_kredit',
            ['nama' => 'Andi', 'nomor_kartu' => '1234567812345678', 'cvv' => '123']
        );

        $this->assertEquals('sukses', $hasil['status']);
        $this->assertEquals(150000, $hasil['total_bayar']);
        $this->assertStringContainsString('berhasil', $hasil['pembayaran']);
    }

    public function testBookingDenganTiketTidakAda(): void
    {
        $hasil = prosesBookingDanPembayaran(
            'Solo Balapan', 'Gambir', '2025-11-25', 1,
            999, $this->tiketTersedia, // ID tidak ada
            'transfer_bank',
            ['bank' => 'BNI', 'rekening' => '1234567890']
        );

        $this->assertEquals('error', $hasil['status']);
        $this->assertEquals('Tiket tidak ditemukan', $hasil['pesan']);
    }

    public function testPembayaranTransferBankValid(): void
    {
        $hasil = prosesBookingDanPembayaran(
            'Surabaya', 'Jakarta', '2025-11-25', 2,
            2, $this->tiketTersedia,
            'transfer_bank',
            ['bank' => 'Mandiri', 'rekening' => '123456789012345']
        );

        $this->assertEquals('sukses', $hasil['status']);
        $this->assertEquals(600000, $hasil['total_bayar']); // 300000 * 2
    }
}