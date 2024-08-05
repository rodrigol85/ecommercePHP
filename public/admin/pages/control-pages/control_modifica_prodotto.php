<?php

ini_set('session.gc_maxlifetime', 600);

session_set_cookie_params(600);

session_start();
$sessionRole = $_SESSION['role'];
$sessionStato = $_SESSION['stato'];

if($sessionStato !== "loggato" || $sessionRole !== "admin"){
    header("Location: ../../index.php");
}


?>
<?php


require_once '../../../../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    $name = $_POST['nome'];
    $description = $_POST['descrizione'];
    $quantity = $_POST['quantita'];
    $price = $_POST['prezzo'];
    $category = $_POST['category_id'];

   
    $db = new Database('localhost', 'root', '', 'ecommerce');

    $result = $db->updateProduct($id, $name, $description, $quantity, $price, $category);

    

    if ($result) {
        
        header("Location: http://localhost/ecommerce/public/?page=lista_prodotti");
        exit;
    } else {
        echo "Si è verificato un errore, modifiche non riuscite";
    }
}















?>