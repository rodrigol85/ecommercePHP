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
require_once ROOT . 'classes/User.php';
//require_once ROOT . 'database/conexionPDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    
    $result = User::deleteById($id);

    if ($result) {
        // Eliminazione riuscita
        header("Location: http://localhost/ecommerce/public/?page=users_list");
        session_start();
        $_SESSION['errorMessage'] = "Dati anagrafici aggiornati correttamente";
       
        exit;
    } else {
        echo "Si è verificato un errore ";
        header("Location: http://localhost/ecommerce/public/?page=users_list");
        session_start();
        $_SESSION['errorMessage'] = "L'utente è stato cancellato correttamente";
       
        exit;
    }
}

?>