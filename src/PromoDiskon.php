<?php
//INTEGRASI TESTING - TC04
class PromoDiskon {
    private static $daftarPromo = [
        "PROMO10" => ["diskon" => 10, "expired" => "2025-12-31", "digunakan" => false],
        "PROMO20" => ["diskon" => 20, "expired" => "2024-12-31", "digunakan" => false],
    ];

    public static function gunakanKodePromo($kode): string {
        $today = date(format: "Y-m-d");

        if(!isset(self::$daftarPromo[$kode])){
            return "Kode promon tidak ditemukan";
        }

        $promo = &self::$daftarPromo[$kode];

        //cek expired
        if($today > $promo["expired"]){
            return "Kode promo $kode sudah expired";
        }

        //cek sudah digunakan
        if($promo["digunakan"]){
            return "Kode promo $kode sudah pernah digunakan";
        }

        //tandai sebagai sudah digunakan
        $promo["digunakan"] = true;
        return "Kode promo $kode berhasil digunakan, diskon {$promo['diskon']}% telah diberikan";
    }

    //tambahkan helper reset biar tiap test mulai fresh
    public static function resetPromo(): void {
        self::$daftarPromo = [
        "PROMO10" => ["diskon" => 10, "expired" => "2025-12-31", "digunakan" => false],
        "PROMO20" => ["diskon" => 20, "expired" => "2024-12-31", "digunakan" => false],
        ];
    }

    //tambahkan method getter 
    public static function getDaftarPromo(): array {
        return self::$daftarPromo;
    }
}
?>