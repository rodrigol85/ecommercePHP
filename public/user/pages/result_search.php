
<?php
define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'classes/Database.php';
require_once ROOT . 'classes/Product.php';

$searchTerm = isset($_GET['search']) ? urldecode($_GET['search']) : '';

$db = new Database('localhost', 'root', '', 'ecommerce');

$products = $db->findProductsByName($searchTerm);


echo "Search term: " . $searchTerm . "<br>";

if (!empty($products)) {
    echo "<h1>Lista Prodotti per '" . $searchTerm . "'</h1>";
 
} else {
    echo "<h1>Nessun Prodotto Trovato per '" . $searchTerm . "'</h1>";
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <title>Lista prodotti</title>
</head>
<body>
<div class="container">
    <?php if (!empty($products)) { ?>
        <h1>Lista Prodotti</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Prodotto</th>
                    <th>Prezzo</th>
                    <th>Categoria</th>
                    <th>Descrizione</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product->getName(); ?></td>
                        <td><?php echo $product->getPrice(); ?></td>
                        <td><?php echo $db->getCategoryName($product->getCategory()); ?></td>
                        <td><?php echo substr($product->getDescription(), 0, 10) . "..."; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <h1>Nessun Prodotto Trovato</h1>
    <?php } ?>
</div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>