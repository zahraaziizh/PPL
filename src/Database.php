<?php
// src/Database.php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = 'localhost';
          $port = '3307';
        $dbname = 'traveloka_replica';
        $username = 'root'; 
        $password = '';   

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
?>