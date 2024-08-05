<?php

define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'classes/Chart.php';
require_once ROOT . 'classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['chart_id'];

    $db = new Database('localhost', 'root', '', 'ecommerce');
    $result = $db->updateChartState($id);

    if ($result) {
        // Eliminazione riuscita
        header("Location: http://localhost/ecommerce/public/?page=chart_view_empty");
        exit;
    } else {
        echo "Si è verificato un errore ";
        header("Location: http://localhost/ecommerce/public/?page=category");
        exit;
    }
}

?>