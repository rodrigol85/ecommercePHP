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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
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

    <div class="col-9">
    <h1>Benvenuti al nostro sito</h1>

    <div class="row row-cols-1 row-cols-md-2 g-4">
  <div class="col">
    <div class="card">
      <img src="https://www.serverplan.com/blog/wp-content/uploads/2020/04/categoria-ecommerce.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="https://www.ispionline.it/wp-content/uploads/2022/07/digital_trade_0.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="https://www.calliduspro.com/wp-content/uploads/2014/04/mockup-ecommerce-monitor.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="https://www.accademia.me/site/uploads/2019/06/ecommerce-seo-tips.jpg" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>