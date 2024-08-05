<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="container">
        <div class="login">
            <h1>Login</h1><img class="loginIcon" src="../css/image/login.png" alt="login icon">
        </div>
            <form action="../public/control-pages/login-control.php" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
            
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
        </div>
<!-- =================================================================
    MESSAGGIO DI ERRORE
================================================================= -->

        <?php  
        if(isset($_SESSION['errorMessage'])){
            echo "<p style='background-color:yellow; color:red; border-radius:5px;' >" . $_SESSION['errorMessage'] . "</p>";
            unset($_SESSION['errorMessage']);
        }
        
        
        ?>
       <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>