<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/User.php';
require_once ROOT . 'classes/Database.php';

//prendo l'id dell'utente che ho creato quanto s'è loggato
$id = $_SESSION['user_id'];

//Istanzio la classe Database dove ho il mio metodo findById()
$db = new Database('localhost', 'root', '', 'ecommerce');
$user = $db->findByIdUser($id);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>
</head>

<body>
    <div class="container">
        <h2>I tuoi dati</h2>

        <img src="https://www.lascimmiapensa.com/wp-content/uploads/2020/12/Bud-spencer-terence-hill.png" style="width: 400px;" class="img-thumbnail" alt="foto profilo">

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nome:</span>
            <input type="text" class="form-control" placeholder="<?php echo $user->getName(); ?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Cognome:</span>
            <input type="text" class="form-control" placeholder="<?php echo $user->getSurname(); ?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Email:</span>
            <input type="text" class="form-control" placeholder="<?php echo $user->getEmail(); ?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Telefono:</span>
            <input type="text" class="form-control" placeholder="<?php echo $user->getTelefono(); ?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>