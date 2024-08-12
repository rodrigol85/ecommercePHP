<?php 

include 'controllo.php';

?> 
<?php
define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'classes/Database.php';
require_once ROOT . 'classes/Product.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
   
  }

$db = new Database('localhost', 'root', '', 'ecommerce');

$product = $db->findByIdProduct($id);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detagli del prodotto</title>
    <style>

      .button-group {
      display: flex;
      justify-content: start;
  }
    </style>

</head>

<body>


<div class="toast-container position-fixed bottom-5 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header" style="background-color: orange; color: white;">
        <strong class="me-auto">Notifica</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" style="color: white; background-color: green;">
        Prodotto aggiunto al carrello!
      </div>
    </div>
  </div>
    <div class="container ">


    <div class="col">
    <div class="card h-80">
      <img src="https://www.teatronaturale.it/media2/articoli/27417-princ.jpg" class="card-img-top" alt="Immagine del prodotto">
      <div class="card-body">
      <h5 class="card-title"><?php echo $product->getName(); ?></h5>
        <h6 class="card-title"><?php echo $product->getPrice() . " " . "&euro;"; ?> </h6>
        <p class="card-text"><?php echo $product->getDescription(); ?></p>
       
        <div class="button-group">
        <a href="javascript:history.back()" class="btn btn-info">Torna Indietro</a>

        <form method="post" action="./user/pages/add_product.php">
              <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
              <input type="hidden" name="unit_price" value="<?php echo $product->getPrice(); ?>">
              <button type="submit" class="btn btn-primary <?php echo ($product->getQuantity() < 1) ? 'disabled' : ''; ?>">
                <?php echo ($product->getQuantity() < 1) ? 'Esaurito' : 'Aggiungi <i class="fas fa-shopping-cart"></i>'; ?>
              </button>
            </form>
        </div>
            
      </div>


  


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();

    var toastEl = document.getElementById('liveToast');
    var toast = new bootstrap.Toast(toastEl);

    fetch(event.target.action, {
        method: 'POST',
        body: new FormData(event.target)
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
});



  </script>
</body>

</html>