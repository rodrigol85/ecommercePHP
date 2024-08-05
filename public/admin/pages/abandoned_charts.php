<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/Chart.php';
require_once ROOT . 'classes/User.php';
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


$db = new Database('localhost', 'root', '', 'ecommerce');
$charts = $db->findAbandonedChart();
?>

<div class="container">
    <h1>Lista Carrelli abbandonati</h1>
  
    <table class="table table-striped table-hover">
      <thead class="table table-dark">
        <tr>
          <th>Carrello N°:</th>
          <th>Utente</th>
          <th>Data creazione</th>
          <th>Stato carello</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
    <?php foreach ($charts as $chart) : ?>
        <?php $user = $db->findByIdUser($chart->getUser_id())  ?> 
        <tr>
            <td><?php echo $chart->getId_chart(); ?></td>
            <td><?php echo $user->getEmail(); ?></td>
            <td><?php echo date("d/m/Y", strtotime($chart->getCreated_at())); ?></td>
            <td><?php echo $chart->getState();?></td>
        
        
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