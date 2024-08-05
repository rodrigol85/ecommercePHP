<?php 

include 'controllo.php';

?> 
<?php

define('ROOT', dirname(__FILE__) . '/../../../');



require_once ROOT . 'classes/Product.php';
require_once ROOT . 'classes/Database.php';
require_once ROOT . 'classes/Chart.php';
require_once ROOT . 'classes/User.php';
require_once ROOT . 'classes/chart_items.php';

if (isset($_GET['id'])) {
    $chart_id = $_GET['id'];
}
$db = new Database('localhost', 'root', '', 'ecommerce');

$chart = $db->findChartById($chart_id);
$user = $db->findByIdUser($chart->getUser_id());
$address = $db->findByIdAddress($chart->getUser_id());

$chart_items = $db->findChartItems($chart_id);
$total = 0;



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detagli del Ordine</title>
</head>

<body>
    <h1>Detagli del Ordine</h1>
    <h3>Dati dell'utente</h3>
    <table class="table table-striped">
        <thead class="table-info">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Indirizzo</th>
                <th>Citt&agrave; </th>
                <th>Cap </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo  $user->getName(); ?></td>
                <td><?php echo  $user->getEmail(); ?></td>
                <td><?php echo  $user->getTelefono(); ?></td>
                <td><?php echo  $address->getStreet(); ?></td>
                <td><?php echo  $address->getCity(); ?></td>
                <td><?php echo  $address->getCap(); ?></td>

            </tr>

        </tbody>
    </table>

    <h1>Lista Prodotti</h1>
    <table class="table table-striped table-bordered">
            <thead class="table-info">
                <tr>
                    <th scope="col">Nome Prodotto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Quantit&agrave;</th>
                    <th scope="col">Totale</th>
                    <th scope="col">Immagine</th>
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
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
            <th colspan="4" class="table-info">Totale</th>
            <th class="table-primary"><?php echo number_format($total, 2) . " &euro;";; ?></th>
            <th class="table-info"></th>
        </tr>

            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>