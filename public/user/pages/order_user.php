<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/Order.php';
require_once ROOT . 'classes/Database.php';

$db = new Database('localhost', 'root', '', 'ecommerce');

$user_id =  $_SESSION['user_id'];

$orders = $db->findOrdersByUser($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordini Precedenti</title>
</head>
<body>

<?php
 if(empty($orders)) {   ?>

    <h3>Nessun Ordine fatto ancora</h3>


<?php }else {   ?>

    <div class="container">
    <h1>Lista Ordini fatti </h1>
    <table class="table table-striped table-hover">
      <thead class="table table-dark">
        <tr>
          <th>Ordine N°:</th>
          <th>Codice Carrello</th>
          <th>Data creazione</th>
          <th>Stato ordine</th>
          <th>Totale</th>
         
        </tr>
      </thead>
      <tbody>
    <?php foreach ($orders as $order) : ?>
        <!-- <tr onclick="window.location.href='?page=orders_detail&id=<?php echo $order->getChart_id(); ?>'"> -->
            <td><?php echo $order->getId_order(); ?></td>
            <td><?php echo $order->getChart_id(); ?></td>
            <td><?php echo date("d/m/Y", strtotime($order->getOrder_at())); ?></td>
            <td><?php echo $order->getOrder_state(); ?></td>
            <td><?php echo $order->getTotal(); ?></td>
            
        </tr>
    <?php endforeach; ?>


      </tbody>
    </table>
  </div>





<?php }   ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


