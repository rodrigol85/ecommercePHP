<?php
session_start();


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.css">
  <link rel="stylesheet" href="<?php echo ROOT_URL; ?>css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <title>E-commerce</title>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark  fixed-top">
    <div class="container">

      <a class="navbar-brand" href="<?php echo ROOT_URL; ?>be/?page=homepage">E-commerce</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

   

          <?php
          // Controlla se l'utente è loggato e il suo ruolo
       
        
          if (isset($_SESSION['stato']) && $_SESSION['stato'] === "loggato") {
            // Utente loggato come admin
            echo '<li class="nav-item">
                <a class="nav-link" href="' . ROOT_URL . 'be/admin/?page=orders">Ordini Pendenti</a>
            </li>';
        }
        ?>
              <?php
          // Controlla se l'utente è loggato e il suo ruolo
        //   if (!isset($_SESSION['role'])) {
        //  echo ' <li class="nav-item">
        //   <form action="http://localhost/ecommerce/public/user/pages/?page=search_product" method="GET" class="d-flex" role="search">
        //       <input class="form-control me-2" name="search" type="search" placeholder="Cerca prodotto" aria-label="Search">
        //       <button class="btn btn-outline-success" type="submit">Search</button>
        //     </form>
        //   </li>';
        //   }elseif($_SESSION['role'] === "user") {
           
        //         echo ' <li class="nav-item">
        //       <form action="http://localhost/ecommerce/public/?page=search_product" method="POST" class="d-flex" role="search">
        //           <input type="text" id="search-input" class="form-control me-2" name="search" placeholder="Cerca prodotti" aria-label="Search">
        //           <button class="btn btn-outline-success" type="submit">Cerca</button>
        //       </form>
        //   </li>
        //   ';
        //    } elseif ($_SESSION['role'] === "admin") {
        //     echo ' <li class="nav-item">
        //   <form action="http://localhost/ecommerce/public/user/pages/?page=search_product" method="GET" class="d-flex" role="search">
        //       <input class="form-control me-2" name="search" type="search" placeholder="Cerca utente" aria-label="Search">
        //       <button class="btn btn-outline-success" type="submit">Search</button>
        //     </form>
        //   </li>';
        //    } ?>
        </ul>

              
    


        <ul class="navbar-nav ml-2">
          <?php if (!isset($_SESSION['stato']) || $_SESSION['stato'] !== "loggato") { ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo ROOT_URL ?>be/admin/?page=registration_admin">Sign up</a>
            </li>
          <?php } ?>

          <?php if (isset($_SESSION['stato']) && $_SESSION['stato'] === "loggato") { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Amministratore
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>be/admin/?page=category">Creare nuova categoria</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>be/admin/?page=product_insert">Inserire nuovo prodotto</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>be/admin/?page=lista_prodotti">Lista di Prodotti</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>be/admin/?page=users_list">Utenti</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>be/admin/?page=all_orders">Lista di tutti gli ordini</a></li>
              </ul>
            </li>
          <?php } ?>

        



          <a class="nav-link" href="<?php echo ROOT_URL . 'be/admin/?page=' . (isset($_SESSION['stato']) ? ($_SESSION['stato'] === "loggato" ? 'logout' : 'login') : 'login'); ?>">
            <?php echo (isset($_SESSION['stato']) && $_SESSION['stato'] === "loggato") ? 'Logout' : 'Sign in'; ?>
          </a>
          </li>



        </ul>

      </div>

    </div>
  </nav>


  <script>
    document.getElementById('search-form').addEventListener('submit', function(event) {
        // Prevenire il comportamento di default del form
        event.preventDefault();

        // Ottenere il valore dell'input
        const searchTerm = document.getElementById('search-input').value;

        // Inviare una richiesta AJAX o reindirizzare a un'altra pagina
        // ...
    });
</script>