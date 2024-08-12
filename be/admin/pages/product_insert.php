<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');
//require_once ROOT . 'database/conexionPDO.php';


require_once ROOT . 'classes/Product.php';


  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserire nuovo prodotto</title>
</head>
<body>
<h1>Prodotto</h1>
<h3>Inserisca il nuovo prodotto:</h3><br>
<form action="pages/control-pages/control_new_product.php" method="POST">
<?php $categories = Category::getAll(); ?>
    <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="category_id">
        <option value="" disabled selected>Scelga la categoria</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
        <?php endforeach; ?>
    </select>
<div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Nome:</span>
  <input type="text" class="form-control" name="nome" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
</div>

<div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Quantit&agrave;:</span>
  <input type="number" class="form-control" name="quantita" aria-label="Sizing example input" min=1 aria-describedby="inputGroup-sizing-default" required>
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Prezzo:</span>
  <input type="number" class="form-control" name="prezzo" min=1 aria-label="Sizing example input" step="0.01" aria-describedby="inputGroup-sizing-default" required>
</div>
<div class="input-group">
  <span class="input-group-text">Descrizione:</span>
  <textarea class="form-control" name="descrizione" aria-label="With textarea" required></textarea>
</div>
<br>
<a href="javascript:history.back()" class="btn btn-info">Torna Indietro</a>
<button type="submit" class="btn btn-success mx-auto">Aggiungi</button>
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>