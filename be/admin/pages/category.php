
<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');
//require_once ROOT . 'database/conexionPDO.php';


require_once ROOT . 'classes/Product.php';
require_once ROOT . 'inc/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorie</title>
</head>

<body>
  <h1>Categorie</h1>
  <h3>Inserisca una nuova categoria:</h3><br>
  <?php  
        if(isset($_SESSION['SuccessMessage'])){
            echo "<p style='background-color:yellow; color:green; border-radius:5px;' >" . $_SESSION['SuccessMessage'] . "</p>";
            unset($_SESSION['SuccessMessage']);
        } ?>
  <form action=" ./pages/control-pages/controllo-categoria.php" method="POST">
    <div class="input-group mb-3">
      <span class="input-group-text" id="inputGroup-sizing-default">Categoria:</span>
      <input type="text" class="form-control" name="nome" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
    </div>
    <button type="submit" class="btn btn-success mx-auto">Aggiungi</button>
  </form>
  <br><br>
  <?php


  $categories = Category::getAll();
  ?>



  <div class="container">
    <h1>Lista Categorie</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Categoria</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category) : ?>
          <tr>
            <td><?php echo  $category->getName(); ?></td>
            <!-- <td><a href='?page=modifica_categoria?id=<?php echo $category->getId(); ?>' class='btn btn-primary btn-sm' data-category-id='<?php echo $category->getId(); ?>'>Modifica</a></td> -->
            <td>
              <form action="?page=modifica_categoria" method="post">
                <input type="hidden" name="id" value="<?php echo $category->getId(); ?>">
                <button type="submit" class="btn btn-primary btn-sm">Modifica</button>
              </form>
            </td>
            <form action="pages/control-pages/control_delete_categoria.php" method="post">
              <input type="hidden" name="id" value="<?php echo $category->getId(); ?>">
              <td><input type="submit" name="delete" class="btn btn-danger" value="Cancella"></td>
            </form>


          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

</html>