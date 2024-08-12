<?php
// helper.php
define('ROOT', dirname(__FILE__) . '/../');
require_once ROOT .'classes/Database.php';
require_once ROOT . 'classes/Chart.php';

session_start();


if (isset($_SESSION['user_id'])) {
  $id = $_SESSION['user_id'];
}

$db = new Database('localhost', 'root', '', 'ecommerce');

//identifico il carello attivo dell'utente 
$chart = $db->findChartActive($id);


if (!empty($chart)) {
  $chart_id = $chart->getId_chart();
  if (is_numeric($chart_id)) {
    $result = $db->getTotalQuantity($chart_id);
    $data = ['cartTotal' => $result]; // Create data array to pass to template
    echo json_encode($data);
  } else {
    // ... (handle invalid chart ID)
  }
} else {
  echo json_encode(['cartTotal' => 0]);
}



?>



<!-- 
<script>
  document.addEventListener('DOMContentLoaded', function() {
    function getTotalCartItems() {
      setInterval(function(){



        fetch('../inc/helper.php') // Fetches data from helper.php
          .then(response => response.json()) // Parses response as JSON
          .then(data => {
            console.log(data); // Logs data for debugging (optional)
            document.getElementById('totCartItems').textContent = data.total;
          })
          .catch(error => console.error('Errore:', error)); // Handles errors
        },1000);
      }

    getTotalCartItems();
  });
</script> -->