
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
    // Recupera i dati dal POST
    $name = $_POST['nome'];
    $quantity = $_POST['quantita'];
    $price = $_POST['prezzo'];
    $description = $_POST['descrizione'];
    $category = $_POST['category_id'];

    // Crea un'istanza di Database, passando i parametri
    $db = new Database('localhost', 'root', '', 'ecommerce'); // Sostituisci con i tuoi valori di connessione

    // Salva il prodotto utilizzando il metodo saveProduct()
    $result = $db->saveProduct($name, $quantity, $price, $description, $category);

    if ($result) {
        // Inserimento andato a buon fine
        header("Location: http://localhost/ecommerce/public/?page=lista_prodotti");
        exit;
    } else {
        echo "Si è verificato un errore nel inserimento";
    }
}
?>