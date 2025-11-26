<?php
//require_once __DIR__ . '/history.php'; 
require_once __DIR__ . '/Database.php'; 


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
        if (!in_array($mobil, $daftarMobil)){
            return "Mobil tidak tersedia";
        }

        $data = [
            'kategori' => 'rental mobil',
            'tanggal' => date('Y-m-d'), // tanggal pemesanan
            'detail' => [
                'mobil' => $mobil,
                'lokasi' => $this->lokasi ?? 'default',
                'mulai' => $this->startDate ?? 'now',
                'selesai' => $this->endDate ?? 'later'
            ]
        ];

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            INSERT INTO orders (user_email, kategori, tanggal, detail)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            'laillanurulita@gmail.com',
            $data['kategori'],
            $data['tanggal'],
            json_encode($data['detail']) // array → JSON string
        ]);

        return "Mobil yang dipilih : $mobil";
    }
}

?>