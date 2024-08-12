

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<div class="container">
        <div class="login">
            <h4>Ripristina la sua password</h4>
        </div>
            <form action="../public/control-pages/control_updata_password.php" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
            
        </div> <br>
     
<!-- =================================================================
    MESSAGGIO DI ERRORE
================================================================= -->

        <?php  
        if(isset($_SESSION['emailNonTrovato'])){
            echo "<p style='background-color:yellow; color:red; border-radius:5px;' >" . $_SESSION['emailNonTrovato'] . "</p>";
            unset($_SESSION['emailNonTrovato']);
        }
        
        
        ?>
       <br>
       
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    
</body>
</html>