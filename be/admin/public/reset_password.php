<?php
if(isset($_GET['token'])) {
    $token = $_GET['token'];

    define('ROOT', dirname(__FILE__) . '/../../../');
    require_once ROOT . 'classes/Database.php';
    require_once ROOT . 'classes/Admin.php';
    require_once ROOT . 'inc/config.php';

    $db = new Database('localhost', 'root', '', 'ecommerce');
    $admin = $db->findByTokenAdmin($token);
    if(empty($admin)){
        
        $_SESSION['errorMessage'] = "Si è verificato un errore, token non valido";
       
        header("Location:" . ROOT_URL. "admin/?page=homework");
        exit;
    }else{

     ?>
     
     <!DOCTYPE html>
     <html lang="en">
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
     </head>
     <body>
        
     </body>
     </html>
     <div class="col-9">
        <h3>Ripristina la sua password</h3>
     <form action="public/update_password.php" method="POST" class="row g-3">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input class="form-control" type="password" name="password" id="password" onkeyup="controllaPassword()" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirma Password</label>
                <input class="form-control" type="password" name="password-confirm" id="confermaPassword"onkeyup="controllaPassword()"  required>
                <span id="messaggio"></span><br>
            </div>
            <div class="mb-3">
            <?php  
        if(isset($_SESSION['errorMessage'])){
            echo "<p style='background-color:yellow; color:green; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']);
        }
        ?>
            <button type="submit" class="btn btn-primary btn-lg">Invia</button>
            </div>

        </form>

        </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function controllaPassword() {
        var password = document.getElementById("password").value;
        var confermaPassword = document.getElementById("confermaPassword").value;
        var messaggio = document.getElementById("messaggio");

        if (password !== confermaPassword) {
            messaggio.style.color = "red";
            messaggio.innerHTML = "Le password non coincidono!";
        } else {
            messaggio.style.color = "green";
            messaggio.innerHTML = "Le password coincidono!";
        }
    }
</script>

</body>

</html>













     <?php
       
       
    }
}

?>