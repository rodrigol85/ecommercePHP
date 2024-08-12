<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';



//questa è la funzione che utilizzo per inviare l'email per attivare l'account e anche quando si fa il pagamento


function inviaEmail($destinatario, $subject, $body, $link) {
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com'; // Sostituisci con il tuo server SMTP
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'phpprova@outlook.it';
        $mail->Password = 'Provaperphp1';

        // Imposta mittente e destinatario
        $mail->setFrom('phpprova@outlook.it', 'Ecommerce');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        // Imposto oggetto e corpo dell'email
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Invia l'email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}




?>
