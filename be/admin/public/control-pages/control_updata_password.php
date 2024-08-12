<?php


//dirname(__FILE__) restituisce la directory del file PHP corrente.
//  '/../../' viene aggiunto per salire di due livelli nella gerarchia delle cartelle, raggiungendo la radice del progetto.
define('ROOT', dirname(__FILE__) . '/../../../../');
require_once ROOT . 'classes/Database.php';
require_once ROOT . 'classes/Admin.php';
require_once ROOT . 'phpmailer/sendEmail.php';
require_once ROOT . 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
}

$reflection = new ReflectionClass("Admin");
$admin = $reflection->newInstanceWithoutConstructor();

$db = new Database('localhost', 'root', '', 'ecommerce');
$searchEmail = $admin->findByEmail($email);

if(empty($searchEmail)){
    session_start();
    $_SESSION['emailNonTrovato'] = "Questa email non è  presente nel database";
    header("Location: " . ROOT_URL . "be/admin/?page=new_password");
    exit;
}else{
    $confirm_code = bin2hex(random_bytes(32));
    $updateToken = $db->updatetokenAdmin($email, $confirm_code);
    $link = 'http://localhost/ecommerce/be/admin/?page=reset_password&token=' . $confirm_code;
    $subject = 'Ripristina la sua password';
    $emailBody = '<h4>Ecommerce</h4><br>
            <h6>Clicka sul link sotto per ripristinare la sua password</h6><br>
            <p><a href="' . $link . '">Link Ripristina password</a></p><br>
            <p>Se non ha fatto nessuna richiesta, ignora questo messaggio</p><br>
            <p>Un saluto dal team Ecommerce</p>';

            inviaEmail($email, $subject, $emailBody, $link);
            session_start();
            $_SESSION['emailNonTrovato'] = "L'abbiamo inviata una email con il link per ripristinare, potrebbe arrivare alla cartella SPAM";
            header("Location: " . ROOT_URL . "be/admin/?page=new_password");
            exit;
}




?>