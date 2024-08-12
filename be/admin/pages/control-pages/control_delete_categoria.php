
<?php

ini_set('session.gc_maxlifetime', 600);

session_set_cookie_params(600);

session_start();
$sessionStato = $_SESSION['stato'];

if($sessionStato !== "loggato"){
    header("Location: ./index.php");
}


?>
<?php

define('ROOT', dirname(__FILE__) . '/../../../../');
require_once ROOT . 'classes/Product.php';
require_once ROOT . 'database/conexionPDO.php';
require_once ROOT . 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $result = Category::deleteById($id);
 

    session_start();
    if ($result) {
        $_SESSION['SuccessMessage'] = "Categoria cancellata con successo";
    } else {
        $_SESSION['SuccessMessage'] = "Categoria cancellata con successo";
    }
    header("Location: " . ROOT_URL . "be/admin/?page=category");
    exit;
}


?>