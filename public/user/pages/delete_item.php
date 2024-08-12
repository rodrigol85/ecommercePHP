
<?php

define('ROOT', dirname(__FILE__) . '/../../../');


require_once ROOT . 'classes/chart_items.php';
require_once ROOT . 'classes/Chart.php';
require_once ROOT . 'classes/Database.php';
require_once ROOT . 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_item = $_POST['item_id'];
    $id_chart = $_POST['chart_id'];

    $db = new Database('localhost', 'root', '', 'ecommerce');

    $countItems = $db->countItemsInChart($id_chart);

 
        $result = $db->deleteItem($id_item, $id_chart);
        if($result){
           
            header("Location: ". ROOT_URL . "public/?page=chart_view_with_products");
            exit;

        }else{
            echo "Si è verificato un errore";
            header("Location: ". ROOT_URL . "public/?page=products");
           // header("Location: http://localhost/ecommerce/public/?page=products");
        exit;
        }

    




}

?>