<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');



require_once ROOT . 'classes/Product.php';
require_once ROOT . 'classes/Database.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];
 
}

// Creo un oggetto Category con i dati della categoria
$db = new Database('localhost', 'root', '', 'ecommerce');
$product = $db->findByIdProduct( $id); 



  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica il prodotto</title>
</head>



<body>
<h1>Prodotto</h1>
<h3>Inserisca le modifiche:</h3><br>
<form action="pages/control-pages/control_modifica_prodotto.php" method="POST">
<?php $categories = Category::getAll(); ?>
<select class="form-select form-select-lg mb-3" aria-label="Large select example" name="category_id">
    <option value="<?php echo $product->getCategory(); ?>" selected><?php echo $db->getCategoryName($product->getCategory()); ?></option>
    <?php foreach ($categories as $category) : ?>
        <option value="<?php echo $category->getId(); ?>" <?php if ($category->getId() == $product->getCategory()) echo 'selected'; ?>><?php echo $category->getName(); ?></option>
    <?php endforeach; ?>
</select>
<input type="hidden" name="id" value="<?php echo $product->getId(); ?>">
<div class="input-group mb-3">

  <span class="input-group-text" id="inputGroup-sizing-default">Nome:</span>
  <input type="text" class="form-control" name="nome" aria-label="Sizing example input" value="<?php echo $product->getName(); ?>" aria-describedby="inputGroup-sizing-default" required>
</div>

<div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Quantit&agrave;:</span>
  <input type="number" class="form-control" name="quantita" aria-label="Sizing example input" value="<?php echo $product->getQuantity(); ?>" min=1 aria-describedby="inputGroup-sizing-default" required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Prezzo:</span>
  <input type="number" class="form-control" name="prezzo" min=1 aria-label="Sizing example input" value="<?php echo $product->getPrice(); ?>" step="0.01" aria-describedby="inputGroup-sizing-default" required>
</div>
<div class="input-group">
  <span class="input-group-text">Descrizione:</span>
  <textarea class="form-control" name="descrizione"  aria-label="With textarea" required><?php echo $product->getDescription(); ?></textarea>
</div>
<br>
<a href="javascript:history.back()" class="btn btn-info">Torna Indietro</a>
<button type="submit" class="btn btn-success mx-auto">Modifica</button>
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>