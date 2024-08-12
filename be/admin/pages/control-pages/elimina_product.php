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

define('ROOT', dirname(__FILE__) . '/../../../../');
require_once ROOT . 'classes/Product.php';
require_once ROOT . 'inc/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Chiama direttamente il metodo statico deleteById
    $result = Product::deleteById($id);

    if ($result) {
        session_start();
        $_SESSION['SuccessMessage'] = "Prodotto eliminato con successo";
        header("Location: " . ROOT_URL . "be/admin/?page=lista_prodotti");
        exit;
        
    } else {
        session_start();
        $_SESSION['SuccessMessage'] = "Si è verificato un errore";
        header("Location: " . ROOT_URL . "be/admin/?page=lista_prodotti");
        exit;
    }
}

?>