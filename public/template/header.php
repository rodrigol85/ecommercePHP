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

      <a class="navbar-brand" href="<?php echo ROOT_URL; ?>public?page=homepage">E-commerce</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <?php

          if (!isset($_SESSION['role'])) {

            echo '<li class="nav-item">
              <a class="nav-link" href="' . ROOT_URL . 'public/?page=about">Chi siamo</a>
          </li>';
          } elseif ($_SESSION['role'] === "user") {

            echo '<li class="nav-item">
              <a class="nav-link" href="' . ROOT_URL . 'public?page=about">Chi siamo</a>
          </li>';
          }
          ?>

          <?php
          // Controlla se l'utente è loggato e il suo ruolo
          if (!isset($_SESSION['role'])) {
            // Utente non loggato
            echo '<li class="nav-item">
              <a class="nav-link" href="' . ROOT_URL . 'public/?page=products">Prodotti</a>
          </li>';
          } elseif ($_SESSION['role'] === "user") {
            // Utente loggato come user
            echo '<li class="nav-item">
              <a class="nav-link" href="' . ROOT_URL . 'public?page=products">Prodotti</a>
          </li>';
          }
          ?>
       
        </ul>


        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "user") { ?>
          <ul class="cart-desktop navbar-nav ml-auto">
            <li class="nav-item">
              <span id="total-items-in-cart" style="display: none;">0</span>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo ROOT_URL; ?>public?page=chart_view_empty">
                <i class="fas fa-shopping-cart"></i>
                <span class="badge badge-primary badge-pill js-totCartItems" id="totCartItems">
              
                </span>

              </a>
            </li>
          </ul>
        <?php } ?>


        <ul class="navbar-nav ml-2">
          <?php if (!isset($_SESSION['stato']) || $_SESSION['stato'] !== "loggato") { ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo ROOT_URL ?>public?page=registration">Sign up</a>
            </li>
          <?php } ?>


          <?php if (isset($_SESSION['stato']) && $_SESSION['stato'] === "loggato" && $_SESSION['role'] === "user") { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Utente
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>public?page=profile">Profilo</a></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>public?page=order_user">Ordini Precedenti</a></li>

              </ul>
            </li>
          <?php } ?>



          <a class="nav-link" href="<?php echo ROOT_URL . 'public?page=' . (isset($_SESSION['stato']) ? ($_SESSION['stato'] === "loggato" ? 'logout' : 'login') : 'login'); ?>">
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
