<?php
class DataUser {
    private static $instance;
    private $pdo;

    private function __construct() {
        $conn = 'mysql:host=localhost;dbname=ecommerce';
        $user = 'root';
        $password = '';

        try {
            $this->pdo = new PDO($conn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DataUser();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}



?>