<?php 

include 'controllo.php';

?> 
<?php



define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'classes/Database.php';
require_once ROOT . 'classes/Chart.php';

if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    
}

$db = new Database('localhost', 'root', '', 'ecommerce');

$chart = $db->findChartActive($id);

if (empty($chart)) { 

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
</head>
<body>

<h1>Carrello Vuoto</h1>

<h4>Scelga il prodotto desiderato...</h4>


<a href="javascript:history.back()" class="btn btn-info">Torna Indietro</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
 


 <?php
    
    
} else {
    header("Location: http://localhost/ecommerce/public/?page=chart_view_with_products");
}

?>
