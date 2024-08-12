
<?php
if(isset($_GET['token'])) {
    $token = $_GET['token'];

    define('ROOT', dirname(__FILE__) . '/../../');
    require_once ROOT . 'classes/Database.php';
    require_once ROOT . 'classes/User.php';
 

    $users = User::getAll();

    $db = new Database('localhost', 'root', '', 'ecommerce');
    $userFound = $db->findByToken($token);
    if($userFound !== null){
        $db->activeAccount($token);
        $_SESSION['errorMessage'] = "Il tuo account è stato attivato";
    }else{
       
        $_SESSION['errorMessage'] = "Si è verificato un errore";
    }


}
?>

<?php
//define('ROOT', dirname(__FILE__) . '/../../');

//require_once ROOT . 'database/conexion.php';

include 'pagination.php';


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
    <div>
    <?php  
        if(isset($_SESSION['errorMessage'])){
            echo "<p style='background-color:yellow; color:green; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']);
        }
        ?>
    </div>
  <div class="container">
    <h1>Lista Prodotti</h1>


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
            <form method="post" action="./user/pages/add_product.php">
              <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
              <input type="hidden" name="unit_price" value="<?php echo $product['price']; ?>">
              <button type="submit" class="btn btn-primary <?php echo ($product['quantity'] < 1) ? 'disabled' : ''; ?>">
                <?php echo ($product['quantity'] < 1) ? 'Esaurito' : 'Aggiungi <i class="fas fa-shopping-cart"></i>'; ?>
              </button>
            </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>


    </div>
    <?php echo generatePagination($page, $pages); ?>


  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>



</html>