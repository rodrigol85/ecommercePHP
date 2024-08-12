<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'classes/Database.php';
require_once ROOT . 'classes/Chart.php';
require_once ROOT . 'classes/chart_items.php';
require_once ROOT . 'classes/Product.php';
require_once ROOT . 'inc/config.php';




if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
}

$db = new Database('localhost', 'root', '', 'ecommerce');

//identifico il carello attivo dell'utente 
$chart = $db->findChartActive($id);

if (!empty($chart)) {
    $chart_id = $chart->getId_chart();
}

$chart_items = $db->findChartItems($chart_id);
$total = 0;

$totalItemsInChart = $db->getTotalQuantity($chart_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <style>
    .inline-form {
        display: inline-block;
        margin-right: 10px; 
    }
</style>
</head>

<body>
    <div class="container">
    <?php
                if(empty($chart_items)){
                    $update = $db->updateChartState($chart_id);
                  echo  '<h1> Carrello svuotato</h1>';
                  
                  exit;
                }
?>
        <div class="top-0 end-0">

            <span class="input-group-text">
                Elementi totale nel carello: <?php echo $totalItemsInChart ?>
            </span>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="table-info">
                <tr>
                    <th scope="col">Nome Prodotto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Quantit&agrave;</th>
                    <th scope="col">Totale</th>
                    <th scope="col">Immagine</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>

                <?php
               
                foreach ($chart_items as $item) :

                    $product = $db->findByIdProduct($item->getProduct_id()); 
                    if ($product) :

                ?>
                        <tr>
                            <th><?php echo $product->getName(); ?></th>
                            <th>
                                <?php
                                $categoria = Category::findById($product->getCategory());
                                if ($categoria) {
                                    echo $categoria->getName();
                                }
                                ?>
                            </th>
                            <th><?php echo $product->getPrice() . " &euro;";; ?></th>
                            <th><?php echo $item->getQuantity(); ?></th>
                            <th><?php echo $item->getUnit_price() * $item->getQuantity() . " &euro;"; ?></th>
                            <?php $total += ($item->getUnit_price() * $item->getQuantity()) ;    ?>
                            <th>
                                <img src="https://newlupetto.com/5462-amazon/sciarpa-stadium-giallo-rosso.jpg" style="width: 100px;" class="rounded float-end" alt="">
                            </th>
                            <th>
                            <form action="./user/pages/delete_item.php" method="post">
                            <input type="hidden" name="item_id" value="<?php echo $item->getId_chart_item(); ?>">
                            <input type="hidden" name="chart_id" value="<?php echo $chart_id; ?>">
                           <input type="submit" name="delete" class="btn btn-danger" value="Cancella">
                            </form>
                            </th>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
            <th colspan="4" class="table-info">Totale</th>
            <th class="table-primary"><?php echo number_format($total, 2) . " &euro;";; ?></th>
            <th class="table-info"></th>
            <th class="table-info"></th>
        </tr>

            </tbody>
        </table>
        <form method="post" action="./user/pages/control_payment.php" class="inline-form">
              <input type="hidden" name="chart_id" value="<?php echo $chart_id ?>">
              <input type="hidden" name="total" value="<?php echo $total; ?>">
              <button type="submit" class="btn btn-success <?php echo ($product->getQuantity() < 1) ? 'disabled' : ''; ?>">
                Pagamento
              </button>
            </form>
            <form method="post" action="./user/pages/delete_chart.php" class="inline-form">
              <input type="hidden" name="chart_id" value="<?php echo $chart_id ?>">
              <input type="hidden" name="total" value="<?php echo $total; ?>">
              <button type="submit" class="btn btn-danger">
                Svuota carrello
              </button>
            </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>