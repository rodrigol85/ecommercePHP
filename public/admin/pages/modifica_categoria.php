<?php 

include 'controllo.php';

?> 

<?php

define('ROOT', dirname(__FILE__) . '/../../../');



require_once ROOT . 'classes/Product.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];
 
}

// Creo un oggetto Category con i dati della categoria
$category = Category::findById($id); 






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title> </head>
<body>
<br>
<h3>Modifica categoria:</h3><br>
<form action="../public/admin/pages/control-pages/control_modifica_categoria.php" method="POST">
    <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Categoria:</span>
        <input type="text" class="form-control" name="nome" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $category->getName(); ?>" required>
        <input type="hidden" name="id" value="<?php echo $category->getId(); ?>">
    </div>
    <a href="javascript:history.back()" class="btn btn-info">Torna Indietro</a>
    <button type="submit" class="btn btn-success mx-auto">Modifica</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>