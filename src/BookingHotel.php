<?php
//INTEGRASI TESTING - TC04
require_once __DIR__ . '/PromoDiskon.php';

function bookingHotel($lokasi, $checkin, $checkout, $jumlahKamar, ? string $kodePromo = null): array|string
{
    //validasi input kosong
    if (empty($lokasi) || empty($checkin) || empty($checkout) || $jumlahKamar <= 0) {
        return "Data booking tidak lengkap";
    }

    $today = date(format: "Y-m-d");

    //validasi checkin < hari ini
    if ($checkin < $today) {
        return "Tanggal check-in tidak valid";
    }

    //validasi checkout harus >= checkin
    if ($checkout < $checkin) {
        return "Tanggal check-out tidak valid";
    }

     // Hitung jumlah malam
    $malam = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);
    if ($malam <= 0) $malam = 1;

    // Misal harga dasar: Rp 1.000.000 per malam per kamar
    $hargaPerMalamPerKamar = 1000000;
    $totalSebelumDiskon = $malam * $jumlahKamar * $hargaPerMalamPerKamar;
    $diskonPersen = 0;
    $pesanPromo = "";

    // Jika ada kode promo, coba gunakan
    if ($kodePromo !== null) {
        $promoResult = PromoDiskon::gunakanKodePromo($kodePromo);

        // Cek apakah promo berhasil digunakan (berdasarkan pesan sukses)
        if (str_contains($promoResult, "berhasil digunakan")) {
            // Ekstrak diskon dari daftar promo (karena status sudah di-update)
            $daftar = PromoDiskon::getDaftarPromo(); 
            $diskonPersen = $daftar[$kodePromo]['diskon'] ?? 0;
            $pesanPromo = $promoResult;
        } else {
            // Jika promo gagal, kembalikan error
            return "Gagal menerapkan promo: " . $promoResult;
        }
    }

    // Hitung total setelah diskon
    $totalDiskon = ($diskonPersen / 100) * $totalSebelumDiskon;
    $totalSetelahDiskon = $totalSebelumDiskon - $totalDiskon;

    return [
        "lokasi" => $lokasi,
        "checkin" => $checkin,
        "checkout" => $checkout,
        "jumlahKamar" => $jumlahKamar,
        "jumlahMalam" => (int)$malam,
        "totalSebelumDiskon" => $totalSebelumDiskon,
        "diskonPersen" => $diskonPersen,
        "totalDiskon" => $totalDiskon,
        "totalSetelahDiskon" => $totalSetelahDiskon,
        "kodePromo" => $kodePromo,
        "pesanPromo" => $pesanPromo ?: "Tidak ada promo digunakan"
    ];
}
?>