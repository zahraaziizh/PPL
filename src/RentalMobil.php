<?php
require_once __DIR__ . '/history.php'; 

class RentalMobil {
    private $lokasi;
    private $startDate;
    private $endDate;
    private $withDriver;

    public function searchTicket($withDriver, $location, $startDate, $endDate)
    {
        if (empty($location) || empty($startDate) || empty($endDate)){
            return "Data tidak lengkap!";
        }

        $this->withDriver = $withDriver;
        $this->lokasi = $location;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

    $driver = $withDriver ? "Dengan sopir" : "Tanpa Sopir";
    return "Lokasi : $location | Mulai : $startDate | Selesai : $endDate | $driver";
    }

    public function pilihMobil($mobil)
    {
        $daftarMobil = ["Avanza", "Innova", "Brio"];
        if (!in_Array($mobil, $daftarMobil)){
            return "Mobil tidak tersedia";
        }

        $history = new history();
        $history->tambahPemesananRental(
            $mobil,
            $this->lokasi?? 'default',
            $this->startDate ?? 'now',
            $this->endDate ?? 'later'
        );

        return "Mobil yang dipilih : $mobil";
    }
}
?>