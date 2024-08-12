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
require_once '../../../../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupero i dati dal form
    $id = $_POST['id'];
    $name = $_POST['nome'];
    $surname = $_POST['cognome'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $telefono = $_POST['telefono'];
    $status = $_POST['stato'];

 
    $db = new Database('localhost', 'root', '', 'ecommerce');

    $result = $db->updateUser($id, $name, $surname, $email, $role, $status,$telefono);

    

    if ($result) {
        session_start();
        $_SESSION['errorMessage'] = "I dati dell'utente sono stati aggiornati correttamente";
        $_SESSION['id'] =  $id ;
        header("Location: " . ROOT_URL . "be/admin/?page=modifica_user");
        exit;
    } else {
        session_start();
        $_SESSION['errorMessage'] = "Si è verificato un errore, modifiche non riuscite";
        
    }
}