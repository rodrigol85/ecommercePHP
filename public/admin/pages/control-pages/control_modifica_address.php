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
    
    $address_id = $_POST['address_id'];
    $city = $_POST['citta'];
    $street = $_POST['indirizzo'];
    $cap = $_POST['cap'];
   

   
    $db = new Database('localhost', 'root', '', 'ecommerce');

    $result = $db->updateAddress($address_id, $street, $city, $cap);

    

    if ($result) {
        session_start();
        $_SESSION['errorMessage'] = "Dati anagrafici aggiornati correttamente";
        
        header("Location: http://localhost/ecommerce/public/?page=users_list");
        exit;
    } else {
        echo "Si è verificato un errore, modifiche non riuscite";
    }
}