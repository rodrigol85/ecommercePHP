<?php

define('ROOT', dirname(__FILE__) . '/../../../../');

require_once ROOT . 'classes/Admin.php';
require_once ROOT . 'phpmailer/sendEmail.php';
require_once ROOT . 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email =htmlspecialchars($_POST['email']);
    $password =$_POST['password'];
    $status = 'disabled';
    $confirm_code = bin2hex(random_bytes(32));
    $telefono =$_POST['telefono'];



      
    $reflection = new ReflectionClass("Admin");
    $adminSearch = $reflection->newInstanceWithoutConstructor();

    $admin = $adminSearch->findByEmail($email);
    if(!empty($admin)){
        session_start();
        $_SESSION['emailPresente'] = "Questa email è già presente nel database";
        
        header("Location:". ROOT_URL . "be/admin/?page=registration_admin");
        exit();
       
        
    }else{
        $result = $adminSearch->createAdmin($name, $surname, $email, $password, $status, $confirm_code, $telefono );

        if($result){
            $link = ' http://localhost/ecommerce/be/admin/pages/public?token=' . $confirm_code;
            $subject = 'Attiva il suo account';
            $emailBody = '<h4>Ecommerce</h4><br>
                    <h6>Clicka sul link sotto per attivare il suo account</h6><br>
                    <p><a href="' . $link . '">Link Attiva account</a></p><br>
                    <p>Se non si è registrato sul nostro sito, ignora questo messaggio</p><br>
                    <p>Un saluto dal team Ecommerce</p>';

                    inviaEmail($email, $subject, $emailBody, $link);
                    session_start();
                    $_SESSION['registracionSuccess'] = "La registrazione è stato un successo, un link per attivare l'account arriverà via email, potrebbe arrivare alla cartella SPAM";
                    header("Location:". ROOT_URL . "be/admin/?page=registration_admin");
                    exit();
        }else {
            echo "Error inserting user data";
        }
        
    }



}
?>