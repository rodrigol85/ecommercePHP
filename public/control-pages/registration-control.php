<?php


//dirname(__FILE__) restituisce la directory del file PHP corrente.
//  '/../../' viene aggiunto per salire di due livelli nella gerarchia delle cartelle, raggiungendo la radice del progetto.
define('ROOT', dirname(__FILE__) . '/../../');
require_once ROOT . 'database/conexion.php';
require_once ROOT . 'phpmailer/sendEmail.php';
require_once ROOT . 'inc/config.php';



$name = mysqli_real_escape_string($conn, $_POST['name']);
$surname = mysqli_real_escape_string($conn, $_POST['surname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$role = 'user';
$status = 'disabled';
$telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
$confirm_code = bin2hex(random_bytes(32));
$street = mysqli_real_escape_string($conn, $_POST['address']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$cap = mysqli_real_escape_string($conn, $_POST['cap']);


//========================Controllo se l'email non esiste gia nel database================

$query = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    session_start();
    $_SESSION['emailPresente'] = "Questa email è già presente nel database";
    header("Location: ". ROOT_URL . "public/?page=registration ");
    die;

}



//Codifica password
$pass = password_hash($password, PASSWORD_DEFAULT); 
$hashedPasswordUser= $pass;

// Evita il commit automatico dei dati
mysqli_autocommit($conn, FALSE);




// 1. Inserisco l'indirizzo per primo per avere un id da collegare allo user
$addressInsertQuery = "INSERT INTO addresses (street, city, cap) VALUES ('$street', '$city', '$cap')";
$addressInsertResult = mysqli_query($conn, $addressInsertQuery);

if ($addressInsertResult) {
    // prende ultimo id creato quando si usa autoincrement
    $addressId = mysqli_insert_id($conn);

    // 2. Inserisco i dati dello user collegando su address_id
    $userInsertQuery = "INSERT INTO users (name, surname, email, password, role, status, telefono, confirm_code, address_id) 
    VALUES ('$name', '$surname', '$email', '$hashedPasswordUser', '$role', '$status', '$telefono', '$confirm_code', '$addressId')";
    $userInsertResult = mysqli_query($conn, $userInsertQuery);

    if ($userInsertResult) {
        // Controlla che entrambe le query sono andate a buon fine
        mysqli_commit($conn); // Commit per attiva il commit dopo che entrambe hanno avuto successo

        $link = 'http://localhost/ecommerce/public?token=' . $confirm_code;
        $subject = 'Attiva il suo account';
        $emailBody = '<h4>Ecommerce</h4><br>
                <h6>Clicka sul link sotto per attivare il suo account</h6><br>
                <p><a href="' . $link . '">Link Attiva account</a></p><br>
                <p>Se non si è registrato sul nostro sito, ignora questo messaggio</p><br>
                <p>Un saluto dal team Ecommerce</p>';

            //Invio un'email all'utente con il link per attivare l'account
            inviaEmail($email, $subject, $emailBody, $link);
        session_start();
        $_SESSION['registracionSuccess'] = "La registrazione è stato un successo, un link per attivare l'account arriverà via email, potrebbe arrivare alla cartella SPAM";
        header("Location: ". ROOT_URL . "public/?page=registration ");
    } else {
        // Se c'è un errore all'inserire nella tabella user
        mysqli_rollback($conn); // Rollback se c'è un errore in questa parte del codice
        echo "Error inserting user data: " . mysqli_error($conn);
    }
} else {
    // Se c'è un errore all'inserire nella tabella address
    mysqli_rollback($conn); // Rollback se c'è un errore in questa parte del codice
    echo "Error inserting address data: " . mysqli_error($conn);
}


?>