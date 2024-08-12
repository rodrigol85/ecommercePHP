<?php
define('ROOT', dirname(__FILE__) . '/../../../../');



require_once ROOT . 'classes/Database.php';
require_once ROOT . 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupero i dati dal POST
    $order_state = $_POST['order_state'];
    $id = $_POST['id'];

    $db = new Database('localhost', 'root', '', 'ecommerce');

    $result =$db->updateOrderState($id, $order_state);
    if ($result) {
        session_start();
        $_SESSION['errorMessage'] = "Si è modificato con successo";
        header("Location: " . ROOT_URL . "be/admin/?page=orders");
        exit;
    } else {
        session_start();
        $_SESSION['errorMessage'] = "Si è modificato con successo";
        header("Location: " . ROOT_URL . "be/admin/?page=orders");
        exit;
    }
}