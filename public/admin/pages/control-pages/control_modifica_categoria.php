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
require_once ROOT . 'database/conexionPDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['nome'];

    $category = new Category($name, $id);
    $result = $category->update();

    if ($result) {
        // Aggiornamento riuscito
        header("Location: http://localhost/ecommerce/public/?page=category");
        exit;
    } else {
        echo "errore nel aggiornare";
    }
}

?>