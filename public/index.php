<?php
$page = isset($_GET["page"]) ? $_GET["page"] : 'products';
$page = preg_replace('/[^-a-zA-Z0-9_]/', '', $page);
$p = isset($_GET['p']) ? intval($_GET['p']) : 1; // Parametro per la paginazione
$p = max($p, 1);
?>
<?php include '../inc/config.php' ?>
<?php include '../classes/Database.php' ?>


<?php include ROOT_PATH . 'public/template/header.php' ?>

<div id="main" class="container" style="margin-top: 100px" ;>
     <div class="row">
          <div class="col-9">
               <!-- =============================================== -->
               <?php if (isset($_SESSION['stato']) && $_SESSION['stato'] === "loggato" && $_SESSION['role'] === "user") {
                    include ROOT_PATH . 'public/user/pages/' . $page . '.php';

                    exit;
               } elseif (!isset($_SESSION['stato']) || $_SESSION['stato'] !== "loggato") {

                    include ROOT_PATH . 'public/pages/' . $page . '.php';
               } ?>



               <!-- ============================================================== -->



          </div>
          <div class="col-3">
               <?php include ROOT_PATH . 'public/template/sidebar.php' ?>
          </div>
     </div>

     <?php include ROOT_PATH . 'public/template/footer.php' ?>


     <script>
          document.addEventListener('DOMContentLoaded', function() {
               function getTotalCartItems() {
                    setInterval(function() {



                         fetch('../inc/helper.php') // Fetches data from helper.php
                              .then(response => response.json()) // Parses response as JSON
                              .then(data => {
                                   console.log(data); // Logs data for debugging (optional)
                                   document.getElementById('totCartItems').textContent = data.total;
                              })
                              .catch(error => console.error('Errore:', error)); // Handles errors
                    }, 1000);
               }

               getTotalCartItems();
          });
     </script>