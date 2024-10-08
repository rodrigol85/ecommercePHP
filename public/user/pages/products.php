<?php

include 'controllo.php';

?>

<?php
define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'database/conexion.php';

include 'pagination.php';



$timeout_duration = 600; // 10 minuti

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {

  // Se l'utente è inattivo per più di 10 minuti
  session_unset();     // rimuove tutte le variabili di sessione
  session_destroy();   // distrugge la sessione
  session_start();
  $_SESSION['errorMessage'] = "La sessione è scaduta, inserisca i suoi dati di nuovo";
  header("Location: http://localhost/ecommerce/public/?page=login");
} else {
  $_SESSION['last_activity'] = time(); // aggiorna l'ultimo tempo di attività

}
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$limit = 12;
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$page = max($page, 1);
$page = preg_replace('/[^-a-zA-Z0-9_]/', '', $page);
$start = ($page - 1) * $limit;
$result = $conn->query("SELECT * FROM products LIMIT $start, $limit");
$products = $result->fetch_all(MYSQLI_ASSOC);

$result1 = $conn->query("SELECT count(id) AS id FROM products");
$productCount = $result1->fetch_all(MYSQLI_ASSOC);
$total = $productCount[0]['id'];
$pages = ceil($total / $limit);

$Previous = $page - 1;
$Next = $page + 1;




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <title>Lista prodotti</title>
  <style>
    .cards-container {
      display: flex;
      flex-wrap: wrap;
      gap: .5rem;

    }

    .card {
      flex: 1 1 calc(25% - .5rem);
    }

    .fixed-size {
      width: 200px;
      height: 200px;
      object-fit: cover;
    }

    .button-group {
      display: flex;
      justify-content: start;
    }
  </style>
</head>

<body>

  <div class="toast-container position-fixed bottom-5 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: orange; color: white;">
      <div class="toast-header" style="background-color: blue; color:white;">
        <strong class="me-auto">Notifica</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Prodotto aggiunto al carrello!
      </div>
    </div>
  </div>


  <div class="container">
    <h1>Lista Prodotti</h1>
    <div style="padding-bottom: 3px;">

      <form action="?page=search_product" method="POST" class="d-flex ms-auto" role="search">
        <input type="text"  class="form-control me-2" name="search" placeholder="Cerca prodotti" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Cerca</button>
      </form>
    </div>
    <?php
    if (isset($_SESSION['errorMessage'])) {
      echo "<p style='background-color:green; color:white; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
      unset($_SESSION['errorMessage']);
    }


    ?>


    <?php echo generatePagination($page, $pages); ?>



    <div class="cards-container ">
      <?php foreach ($products as $product) :
      ?>

        <div class="card" style="width: 18rem;">
          <img src="https://static.tecnichenuove.it/logisticanews/2018/04/ecommerce-1.jpg" class="card-img-top fixed-size" alt="imagine del prodotto">
          <div class="card-body">
            <h2 class="card-title"><?php echo $product['name']; ?></h2>
            <p class="card-text"><?php echo $product['price'] . " " . '&euro;';  ?></p>
            <p class="card-text"><?php echo substr($product['description'], 0, 20) . " " . "..."; ?></p>
            <div class="button-group">
              <a href="./?page=product_detail&id=<?php echo $product['id']; ?>" class="card-link">Info... &ggg;</a>
              <form method="post" action="user/pages/add_product.php" id="myForm">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="unit_price" value="<?php echo $product['price']; ?>">
                <button type="submit" class="btn btn-primary <?php echo ($product['quantity'] < 1) ? 'disabled' : ''; ?>" onclick="aggiungiAlCarrello(event)">
                  <?php echo ($product['quantity'] < 1) ? 'Esaurito' : 'Aggiungi <i class="fas fa-shopping-cart"></i>'; ?>
                </button>
                <div id="product-added-message" class="alert alert-success" style="display: none;">Prodotto aggiunto al carrello!</div>
              </form>

            </div>
          </div>
        </div>
      <?php endforeach; ?>


    </div>
    <?php echo generatePagination($page, $pages); ?>


  </div>

  <script>
    function aggiungiAlCarrello(event) {
      event.preventDefault();

      const form = event.target.closest('form');

      var toastEl = document.getElementById('liveToast');
      var toast = new bootstrap.Toast(toastEl);

      fetch(form.action, {
          method: 'POST',
          body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('Prodotto aggiunto con successo');
            toast.show();
          } else {
            console.error('Errore nell\'aggiunta del prodotto:', data.error || 'Errore generico');
          }
        })
        .catch(error => {
          console.error('Errore nella richiesta:', error);
        });
    }
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>



</html>