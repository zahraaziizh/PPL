<?php
//session_start();

class history {
    //private $isLoggedIn = false;
    private function getOrders(){
        return $_SESSION['orders'] ?? [
        ["id" => 1, "kategori" => "hotel", "tanggal" => "2025-09-01"],
        ["id" => 2, "kategori" => "pesawat", "tanggal" => "2025-09-15"],
        ["id" => 3, "kategori" => "hotel", "tanggal" => "2025-09-20"],
        ];
    }

    private function setOrders($orders){
        $_SESSION['orders'] = $orders;
    }

    public function login() {
         $_SESSION['logged_in'] = true;
    }

    public function logout() {
        unset($_SESSION['logged_in']);
    }

      private function isLoggedIn(): bool {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function tambahPemesananRental($mobil, $lokasi, $mulai, $selesai) {
        $orders = $this->getOrders();
        $newId = empty($orders) ? 1 : (end($orders)['id'] + 1);

        $orders[] = [
            'id' => $newId,
            'kategori' => 'rental mobil',
            'tanggal' => date('Y-m-d'),
            'detail' => [
                'mobil' => $mobil,
                'lokasi' => $lokasi,
                'mulai' => $mulai,
                'selesai' => $selesai
            ]
        ];

        $this->setOrders($orders);
    }

    // akses history hanya jika login
    public function getHistory() {
        if (!$this->isLoggedIn()) {
            return null; // tanpa login, tidak ada tombol Purchase List
        }
        return $this->getOrders();
    }

    // filter berdasarkan kategori
    public function filterHistory($kategori) {
        if (!$this->isLoggedIn) {
            return null;
        }
          $orders = $this->getOrders();
        return array_filter($orders, function($order) use ($kategori) {
            return $order["kategori"] === $kategori;
        });
    }
}
