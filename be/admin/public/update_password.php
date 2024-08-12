<?php
define('ROOT', dirname(__FILE__) . '/../../../');



require_once ROOT . 'classes/Admin.php';
require_once ROOT . 'classes/Database.php';
require_once ROOT . 'inc/config.php';


if (isset($_POST['password']) && isset($_POST['token'])) {
    $password = $_POST['password'];
    $token = $_POST['token'];

}

$db = new Database('localhost', 'root', '', 'ecommerce');
$admin = $db->findByTokenAdmin($token);
$email = $admin->getEmail();

$result = $db->updatePasswordAdmin($email, $password);

if($result){
    $db->updatetokenAdmin($email , null);
    session_start();
    $_SESSION['errorMessage'] = "La sua password è stata ripristinata correttamente, ora può loggarsi";
    header("Location: " . ROOT_URL . "be/admin/?page=login");
    
}else {
    session_start();
    $_SESSION['errorMessage'] = "Si è verificato un errore";
    header("Location: " . ROOT_URL . "be/admin/?page=login");
}

