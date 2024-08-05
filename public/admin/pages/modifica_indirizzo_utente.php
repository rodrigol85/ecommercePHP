<?php 

include 'controllo.php';

?> 

<?php
define('ROOT', dirname(__FILE__) . '/../../../');



require_once ROOT . 'classes/User.php';
require_once ROOT . 'classes/Database.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$db = new Database('localhost', 'root', '', 'ecommerce');
$userFound = $db->findByIdUser($id);

$address_id = $userFound->getAddress();

$userAddress = $db->findByIdAddress($address_id);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica dati anagrafici</title>
</head>


    
    <h4>Dati dell'utente:  <?php echo $userFound->getName() . " " .   $userFound->getSurname();     ?></h4><br>
    <h6>Inserisca le modifiche </h6>
    <form action="../public/admin/pages/control-pages/control_modifica_address.php" method="POST">

        <div class="input-group mb-3">
            <input type="hidden" name="address_id" value="<?php echo $userAddress->getAddress_id(); ?>">
            <span class="input-group-text" id="inputGroup-sizing-default">Indirizzo:</span>
            <input type="text" class="form-control" name="indirizzo" aria-label="Sizing example input" value="<?php echo $userAddress->getStreet(); ?>" aria-describedby="inputGroup-sizing-default" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Citt&agrave;:</span>
            <input type="text" class="form-control" name="citta" aria-label="Sizing example input" value="<?php echo $userAddress->getCity(); ?>"  aria-describedby="inputGroup-sizing-default" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Cap:</span>
            <input type="number" class="form-control" name="cap" aria-label="Sizing example input" value="<?php echo $userAddress->getCap();  ?>"  aria-describedby="inputGroup-sizing-default" required>
        </div>
       
        <br>
        <button type="submit" class="btn btn-success mx-auto">Modifica</button>
    </form><br>