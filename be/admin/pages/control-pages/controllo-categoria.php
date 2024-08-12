<?php

ini_set('session.gc_maxlifetime', 600);

session_set_cookie_params(600);

session_start();

$sessionStato = $_SESSION['stato'];

if($sessionStato !== "loggato" ){
    header("Location: ../../index.php");
}


?>
<?php

define('ROOT', dirname(__FILE__) . '/../../../../');
require_once ROOT . 'classes/Product.php';
require_once ROOT . 'database/conexionPDO.php';
require_once ROOT . 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = new Category($_POST['nome']);
    $category->save();
   
    session_start();
    $_SESSION['SuccessMessage'] = "Nuova categoria aggiunta con successo";
    header("Location: " . ROOT_URL . "be/admin/?page=category");
    exit;
}
?>