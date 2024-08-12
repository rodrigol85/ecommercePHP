<?php

ini_set('session.gc_maxlifetime', 600);

session_set_cookie_params(600);

session_start();
$sessionStato = $_SESSION['stato'];

if($sessionStato !== "loggato"){
    header("Location: ../../index.php");
}


?>
<?php

define('ROOT', dirname(__FILE__) . '/../../../../');
require_once ROOT . 'classes/User.php';
require_once ROOT . 'inc/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    
    $result = User::deleteById($id);

    if ($result) {
        header("Location: " . ROOT_URL . "be/admin/?page=users_list");
        session_start();
        $_SESSION['errorMessage'] = "Cancellazione con successo";
       
        exit;
    } else {
        echo "Si è verificato un errore ";
        header("Location: " . ROOT_URL . "be/admin/?page=users_list");
        session_start();
        $_SESSION['errorMessage'] = "L'utente è stato cancellato correttamente";
       
        exit;
    }
}

?>