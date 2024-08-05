<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/Order.php';
require_once ROOT . 'classes/Database.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$db = new Database('localhost', 'root', '', 'ecommerce');
$order = $db->findOrdertById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>

<?php  
        if(isset($_SESSION['errorMessage'])){
            echo "<p style='background-color:yellow; color:green; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']);
        }
        
        
        ?>
<h1>Ordine</h1>
<h6>Ordine N°: <?php echo $order->getId_order(); ?> </h6>
<h6>Ordinato in data: <?php echo date("d/m/Y", strtotime($order->getOrder_at())); ?> </h6>
<form action="../public/admin/pages/control-pages/control_order.php" method="POST">
<input type="hidden" name="id" value="<?php echo $order->getId_order(); ?>">
<span class="input-group-text" id="inputGroup-sizing-default">Seleziona lo stato:</span>
        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="order_state" value="<?php echo $order->getOrder_state(); ?>">
            <option value="<?php echo $order->getOrder_state(); ?>" selected><?php echo $order->getOrder_state(); ?></option>
            <option value="pending">pending</option>
            <option value="delivering">delivering</option>
            <option value="delivered">delivered</option>
        </select>

        <button type="submit" class="btn btn-success mx-auto">Modifica</button>
   
</form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
