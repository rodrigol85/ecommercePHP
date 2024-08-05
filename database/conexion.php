<?php



// define('ROOT', dirname(__FILE__) . '/../../');
 require_once ROOT . 'inc/config.php';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
   





?>