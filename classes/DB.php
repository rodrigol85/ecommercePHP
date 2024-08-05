<?php

class Db {
  private static $conn;

  public static function getConnection() {
    if (self::$conn === null) {
      try {
        $host = 'localhost'; 
        $dbname = 'ecommerce'; 
        $username = 'root'; 
        $password = ''; 

        self::$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit(); 
      }
    }

    return self::$conn;
  }
}
