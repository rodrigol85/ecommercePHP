<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/User.php';
require_once ROOT . 'classes/Database.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista utenti</title>
</head>
<body>
<?php

$users = User::getAll();

$db = new Database('localhost', 'root', '', 'ecommerce');



?>
    <?php  
        if(isset($_SESSION['errorMessage'])){
            echo "<p style='background-color:yellow; color:green; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']);
        }
        
        
        ?>

    <div class="container">
    <h1>Lista Utenti</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Cognome</th>
          <th>Email</th>
          <th>Ruolo</th>
          <th>Stato</th>
          <th>Telefono</th>
          <th>Indirizzo</th>

          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) :?>
        
          <tr>
            <td style="color:<?php echo $user->getRole() == 'admin' ? 'red' : 'green'; ?>"><?php echo  $user->getName(); ?></td>
            <td><?php echo  $user->getSurname(); ?></td>
            <td><?php echo  $user->getEmail(); ?></td>
            <td style="color:<?php echo $user->getRole() == 'admin' ? 'red' : 'green'; ?>"><?php echo $user->getRole(); ?></td>
            <td><?php echo  $user->getStatus();?></td>
            <td><?php echo  $user->getTelefono();?></td>
            <?php  $address_id = $user->getAddress();

              $userAddress = $db->findByIdAddress($address_id); ?>

            <td><?php  echo $userAddress->getStreet();?></td>
     
            
            
            <td>
              <form action="?page=modifica_user" method="post">
                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                <button type="submit" class="btn btn-primary btn-sm">Modifica</button>
              </form>
            </td>
            <form action="pages/control-pages/control_delete_user.php" method="post">
              <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
              <td><input type="submit" name="delete" class="btn btn-danger" value="Cancella"></td>
            </form>


          </tr>
        <?php endforeach; ?>
       
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>