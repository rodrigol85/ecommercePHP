<?php


//require_once ROOT . 'inc/config.php';
$GLOBALS['DB_HOST'] = 'localhost';
$GLOBALS['DB_USER'] = 'root';
$GLOBALS['DB_PASS'] = '';
$GLOBALS['DB_NAME'] = 'ecommerce';

try {
    $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  
  function getConnection() {
    global $conn;
    return $conn;
  }

 

  
  ?>

