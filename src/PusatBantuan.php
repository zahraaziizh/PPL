<?php
//INTEGRASI TESTING - TC05

//fungsi untuk menghubungi customer service
require_once __DIR__ .'/ChatCustomerService.php';

class CustomerService{
    public function tampilkanMenu(): string{
        return "Selamat datang di Customer Service. Anda bisa chat atau kirim email ke support@travelkita.com";
    }
}

class PusatBantuan {
    private array $produk = ["Pesawat", "Hotel", "Rental Mobil"];
    private array $topik = [
        "Refund Tiket",
        "Reschedule Tiket",
        "Refund Hotel"
    ];

    public function cariTopik(string $keyword): array {
        $hasil = [];
        foreach ($this->topik as $t){
            if (stripos($t, $keyword) !== false) {
                $hasil[] = $t;
            }
        }
        return $hasil;
    }

    public function pilihTopik(string $nama): ? string{
        return in_array($nama, $this->topik) ? $nama : null;
    }

    public function pilihProduk(string $nama): ? string {
        return in_array($nama, $this->produk) ? $nama : null;
    }

    public function hubungiKami(bool $hasOrder = false): string {
        return chatDenganCS($hasOrder);
    }
}
?>