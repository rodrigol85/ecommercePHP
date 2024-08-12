<?php

define('ROOT', dirname(__FILE__) . '/../../');


include '../inc/ini.php';
require_once ROOT . 'database/conexion.php';
require_once ROOT . 'inc/config.php';
try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }


$email=htmlspecialchars($_POST['email']);
$password=$_POST['password'];

$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(":email", $email);
if ($stmt->execute()) {
    $rows = $stmt->rowCount();
    if ($rows > 0) {
       while($row=$stmt->fetch()){
            $pass= $row['password'];
            $userEmail= $row['email'];
            $userRole= $row['role'];
            $userStatus = $row['status'];
            $user_id = $row['id'];
            if($email === $userEmail && password_verify($password, $pass)) {
                if($userRole == 'admin'){
                  session_start();
                  $_SESSION['stato'] = "loggato";
                  $_SESSION['role'] = "admin";
                  $_SESSION['email'] = $userEmail;
                  header("Location: ../admin/pages/?page=homepage");
                }elseif($userRole == 'user' && $userStatus !== 'activated'){
                  session_start();
                  $_SESSION['errorMessage'] = "Il suo account non è ancora attivato, controlla la sua email per attivare";
                  header("Location: ". ROOT_URL . "public/?page=login ");

                }else{
                  session_start();

                  $_SESSION['last_activity'] = time();

                  $_SESSION['stato'] = "loggato";
                  $_SESSION['role'] = "user";
                  $_SESSION['email'] = $userEmail;
                  $_SESSION['user_id'] = $user_id;
                 
                  header("Location: ". ROOT_URL . "public/?page=products ");
               

                  
                }
                  
            
              } else {
                  session_start();
                  $_SESSION['errorMessage'] = "Password o username incorretti";
                  header("Location: ". ROOT_URL . "public/?page=login ");

              }
       }
    } else {
      session_start();
      $_SESSION['errorMessage'] = "Non esiste nessun utente con questa email";
      header("Location: ". ROOT_URL . "public/?page=login ");
    }
} else {
    echo "Errore: " . $stmt->errorInfo()[2];
}



?>



