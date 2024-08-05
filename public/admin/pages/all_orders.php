
<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/Order.php';
require_once ROOT . 'classes/Database.php';
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>
<body>
<?php

$orders = Order::getAll();
$db = new Database('localhost', 'root', '', 'ecommerce');

?>

<div class="container">
    <h1>Lista Ordini</h1>
    <span>(Si visualizzano tutti gli ordini) </span>
    <table class="table table-striped table-hover">
      <thead class="table table-dark">
        <tr>
          <th>Ordine N°:</th>
          <th>Codice Utente</th>
          <th>Codice Carrello</th>
          <th>Data creazione</th>
          <th>Stato ordine</th>
          <th>Totale</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
    <?php foreach ($orders as $order) : ?>
        <tr onclick="window.location.href='?page=orders_detail&id=<?php echo $order->getChart_id(); ?>'">
            <td><?php echo $order->getId_order(); ?></td>
            <td><?php echo $order->getUser_id(); ?></td>
            <td><?php echo $order->getChart_id(); ?></td>
            <td><?php echo date("d/m/Y", strtotime($order->getOrder_at())); ?></td>
            <td><?php echo $order->getOrder_state(); ?></td>
            <td><?php echo $order->getTotal(); ?></td>
            <td>
            <form action="?page=modifica_orders" method="POST">
                    <input type="hidden" name="id" value="<?php echo $order->getId_order(); ?>">
                    <button type="submit" class="btn btn-primary btn-sm">Modifica</button>
                </form>
            </td>
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