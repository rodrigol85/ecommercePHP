<?php 

include 'controllo.php';

?> 
<?php
define('ROOT', dirname(__FILE__) . '/../../../');



require_once ROOT . 'classes/User.php';
require_once ROOT . 'classes/Database.php';


if (isset($_POST['id'])) {
    $id = $_POST['id'];
} elseif (isset($_SESSION['id'])) {
   
        //Inizzializo un nuovo User senza parametri
$reflection = new ReflectionClass("User");
$userFound = $reflection->newInstanceWithoutConstructor();

    $userFound->setAddress_id = $_SESSION['id'];
    $id = $_SESSION['id'];
    unset($_SESSION['id']);
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
    <title>Modifica utente</title>
</head>

<?php  
        if(isset($_SESSION['errorMessage'])){
           
            echo "<p style='background-color:yellow; color:green; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']);
        }
        
        
        ?>

    <h1>Utente</h1>
    <h3>Inserisca le modifiche:</h3><br>
    <form action="../public/admin/pages/control-pages/control_modifica_user.php" method="POST">

        <div class="input-group mb-3">
            <input type="hidden" name="id" value="<?php echo $userFound->getId(); ?>">
            <span class="input-group-text" id="inputGroup-sizing-default">Nome:</span>
            <input type="text" class="form-control" name="nome" aria-label="Sizing example input" value="<?php echo $userFound->getName(); ?>" aria-describedby="inputGroup-sizing-default" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Cognome:</span>
            <input type="text" class="form-control" name="cognome" aria-label="Sizing example input" value="<?php echo $userFound->getSurname(); ?>" min=1 aria-describedby="inputGroup-sizing-default" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Email:</span>
            <input type="email" class="form-control" name="email" min=1 aria-label="Sizing example input" value="<?php echo $userFound->getEmail(); ?>" step="0.01" aria-describedby="inputGroup-sizing-default" required>
        </div>
        <span class="input-group-text" id="inputGroup-sizing-default">Seleziona il ruolo:</span>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="role" value="<?php echo $userFound->getRole(); ?>">
            <option value="<?php echo $userFound->getRole(); ?>" selected><?php echo $userFound->getRole(); ?></option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Telefono:</span>
            <input type="number" class="form-control" name="telefono" min=1 aria-label="Sizing example input" value="<?php echo $userFound->getTelefono(); ?>" step="0.01" aria-describedby="inputGroup-sizing-default" required>
        </div>
        <span class="input-group-text" id="inputGroup-sizing-default">Seleziona lo stato:</span>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="stato" value="<?php echo $userFound->getStatus(); ?>">
            <option value="<?php echo $userFound->getStatus(); ?>" selected><?php echo $userFound->getStatus(); ?></option>
            <option value="activated">activated</option>
            <option value="disable">disabled</option>
        </select>

        <br>
        <button type="submit" class="btn btn-success mx-auto">Modifica</button>
    </form><br>
    <div class="container">


        <ul class="list-group">
            <li class="list-group-item active" aria-current="true">Dati Anagrafici:   </li>
            <li class="list-group-item">Indirizzo:  <?php echo $userAddress->getStreet(); ?> </li>
            <li class="list-group-item">Citt&agrave;:   <?php echo $userAddress->getCity(); ?> </li>
            <li class="list-group-item">Cap:  <?php echo $userAddress->getCap(); ?></li>
            <li class="list-group-item">  <form action="?page=modifica_indirizzo_utente" method="post">
                <input type="hidden" name="id" value="<?php echo $userAddress->getAddress_id(); ?>">
                <button type="submit" class="btn btn-success btn-sm">Modifica</button>
              </form></li>
            
        </ul>
       



        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        </body>

</html>