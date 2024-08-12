
<?php
$page = isset($_GET["page"]) ? $_GET["page"] : 'homepage';
$page = preg_replace('/[^-a-zA-Z0-9_]/', '', $page);
$p = isset($_GET['p']) ? intval($_GET['p']) : 1; // Parametro per la paginazione
$p = max($p, 1);
?>
<?php include '../../inc/config.php' ?>


<?php include ROOT_PATH . 'be/admin/public/header_admin.php' ?>

<div id="main" class="container" style="margin-top: 100px";>
    <div class="row">
        <div class="col-9">
        <!-- =============================================== -->
        <?php if (isset($_SESSION['stato']) && $_SESSION['stato'] === "loggato"){ 
            
             include ROOT_PATH . 'be/admin/pages/' . $page . '.php';  
                exit;

        }elseif (!isset($_SESSION['stato']) || $_SESSION['stato'] !== "loggato") {

             include ROOT_PATH . 'be/admin/public/' . $page . '.php'; } ?> 



        <!-- ============================================================== -->
           
          
        
        <!-- </div>
        <div class="col-3">
        <?php include ROOT_PATH . 'public/template/sidebar.php' ?>
        </div> -->
</div>

<!-- <?php include ROOT_PATH . 'public/template/footer.php' ?> -->