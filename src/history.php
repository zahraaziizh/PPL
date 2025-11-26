<?php
require_once __DIR__ . '/Database.php';

class history {
    public function login() {
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = 'laillanurulita@gmail.com';
    }

    private function isLoggedIn(): bool {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function getHistory() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_email = ? ORDER BY id DESC");
        $stmt->execute(['laillanurulita@gmail.com']);
        $rows = $stmt->fetchAll();

        return array_map(function($row) {
            $row['detail'] = json_decode($row['detail'], true);
            return $row;
        }, $rows);
    }

    public function filterHistory($kategori) {
        if (!$this->isLoggedIn()) {
            return null;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_email = ? AND kategori = ? ORDER BY id DESC");
        $stmt->execute(['laillanurulita@gmail.com', $kategori]);
        $rows = $stmt->fetchAll();

        return array_map(function($row) {
            $row['detail'] = json_decode($row['detail'], true);
            return $row;
        }, $rows);
    }
}
?>