<?php
//INTEGRASI TESTING - TC03

//2 modul yg akan diintegrasikan
require_once __DIR__ . '/BookingTransportasi.php';
require_once __DIR__ . '/MetodePembayaran.php';

//integrasi dengan shared data structure
function prosesBookingDanPembayaran(
    string $asal,
    string $tujuan,
    string $waktu,
    int $kursi,
    int $tiketId,
    array $tiketTersedia,
    string $metode,
    array $detailPembayaran
): array {
    // 1. Validasi booking awal
    $booking = bookingTransportasi($asal, $tujuan, $waktu, $kursi);
    if (!$booking) {
        return ['status' => 'error', 'pesan' => 'Data booking tidak lengkap'];
    }

    // 2. Pilih tiket
    $tiket = pilihTiket($tiketId, $tiketTersedia);
    if (!$tiket) {
        return ['status' => 'error', 'pesan' => 'Tiket tidak ditemukan'];
    }

    // 3. Validasi konsistensi (opsional tapi baik untuk integrasi)
    if ($tiket['asal'] !== $asal || $tiket['tujuan'] !== $tujuan) {
        return ['status' => 'error', 'pesan' => 'Data tiket tidak sesuai booking'];
    }

    // 4. Proses pembayaran berdasarkan metode
    $pesanPembayaran = '';
    if ($metode === 'kartu_kredit') {
        $nama = $detailPembayaran['nama'] ?? '';
        $nomorKartu = $detailPembayaran['nomor_kartu'] ?? '';
        $cvv = $detailPembayaran['cvv'] ?? '';
        $pesanPembayaran = pembayaranKartuKredit($nama, $nomorKartu, $cvv);
    } elseif ($metode === 'transfer_bank') {
        $bank = $detailPembayaran['bank'] ?? '';
        $rekening = $detailPembayaran['rekening'] ?? '';
        $pesanPembayaran = pembayaranTransferBank($bank, $rekening);
    } else {
        return ['status' => 'error', 'pesan' => 'Metode pembayaran tidak didukung'];
    }

    // 5. Tentukan status akhir
    if (str_contains($pesanPembayaran, 'berhasil')) {
        return [
            'status' => 'sukses',
            'tiket' => $tiket,
            'total_bayar' => $tiket['harga'] * $kursi,
            'pembayaran' => $pesanPembayaran
        ];
    } else {
        return [
            'status' => 'gagal',
            'alasan' => $pesanPembayaran
        ];
    }
}