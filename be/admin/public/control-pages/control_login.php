<?php


require_once '../../../../classes/Admin.php';
require_once '../../../../inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal POST
    $email=htmlspecialchars($_POST['email']);
    $password=$_POST['password'];

}

        //Inizzializo un nuovo User senza parametri
        $reflection = new ReflectionClass("Admin");
        $adminSearch = $reflection->newInstanceWithoutConstructor();

$admin = $adminSearch->findByEmail($email);
if(empty($admin)){
    session_start();
      $_SESSION['errorMessage'] = "Non esiste nessun utente con questa email";
      header("Location: " . ROOT_URL . "be/admin/?page=login");
}else{
   $pass = $admin->getPassword();
   $userEmail = $admin->getEmail();
   $status = $admin->getStatus();
   $adminId= $admin->getId();
   if($email === $userEmail && password_verify($password, $pass)) {
        if($status !== 'activated'){
            session_start();
        $_SESSION['errorMessage'] = "Il suo account non è stato attivato, controlla la sua email con il link per attivare";
        header("Location: " . ROOT_URL . "be/admin/?page=login");
        } else {
            session_start();
            $_SESSION['stato'] = "loggato";
            $_SESSION['email'] = $userEmail;
            header("Location: " . ROOT_URL . "be/admin/?page=homepage");
            
        }


   }else {
        session_start();
        $_SESSION['errorMessage'] = "Password o username incorretti";
        header("Location: " . ROOT_URL . "be/admin/?page=login");
        exit;
   }
}




?>