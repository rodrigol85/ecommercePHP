
<?php 

include 'controllo.php';

?> 

<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/Product.php';
require_once ROOT . 'classes/Database.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Lista prodotti</title>
</head>
<body>
<?php

$products = Product::getAll();
$db = new Database('localhost', 'root', '', 'ecommerce');

?>
    
    <div class="container">
    <h1>Lista Prodotti</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Prodotto</th>
          <th>Quantit&agrave;</th>
          <th>Prezzo</th>
          <th>Categoria</th>
          <th>Descrizione</th>
          <th></th>
          <th>
  <a class="btn btn-info" href="?page=product_insert" style="float: right;">
    Aggiungi prodotto <ion-icon name="add-circle-sharp"></ion-icon><ion-icon name="add-circle-sharp"></ion-icon>
  </a>
</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product) : ?>
          <tr>
            <td><?php echo  $product->getName(); ?></td>
            <td><?php echo  $product->getQuantity(); ?></td>
            <td><?php echo  $product->getPrice(); ?></td>
            <td><?php echo  $db->getCategoryName($product->getCategory());?></td>
            <td><?php echo  substr($product->getDescription(),0, 10) . " ...";?></td>
            
            
            <td>
              <form action="?page=modifica_prodotto" method="post">
                <input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
                <button type="submit" class="btn btn-primary btn-sm">Modifica</button>
              </form>
            </td>
            <form action="http://localhost/ecommerce/public/admin/pages/control-pages/elimina_product.php" method="post">
              <input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
              <td><input type="submit" name="delete" class="btn btn-danger" value="Cancella"></td>
            </form>


          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>