<?php
if(isset($_GET['token'])) {
    $token = $_GET['token'];

    require './classes/DataUser.php';
    require './classes/User.php';
  

    //$users = User::getAll();

    $db = new Database('localhost', 'root', '', 'ecommerce');
  
    $userFound = $db->findByToken($token);
    if($userFound !== null){
        session_start();
        $_SESSION['errorMessage'] = "Il tuo account è stato attivato";
    }else{
        session_start();
        $_SESSION['errorMessage'] = "Si è verificato un errore";
    }


} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
</head>
<body>
    back end users
</body>
</html>