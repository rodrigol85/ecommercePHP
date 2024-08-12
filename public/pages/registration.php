<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<body>
    <div class="container">
        <h1>Registrazione</h1>
        <div>
        <?php  
        if(isset($_SESSION['registracionSuccess'])){
            echo "<p style='background-color:green; color:white; border-radius:5px;' >" . $_SESSION['registracionSuccess'] . "</p>";
            unset($_SESSION['registracionSuccess']);
        }elseif(isset($_SESSION['emailPresente'])){
            echo "<p style='background-color:red; color:white; border-radius:5px;' >" . $_SESSION['emailPresente'] . "</p>";
            unset($_SESSION['emailPresente']);
        }
        
        
        ?>
        </div>
        <form action="../public/control-pages/registration-control.php" method="POST" class="row g-3">
            <div class="mb-3">
                <label for="formFile" class="form-label">Nome</label>
                <input class="form-control" name="name" type="text" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Cognome</label>
                <input class="form-control" name="surname" type="text" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Email</label>
                <input class="form-control" name="email" type="email" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Telefono</label></label>
                <input class="form-control" name="telefono" type="Text" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Indirizzo</label></label>
                <input class="form-control" name="address" type="Text" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Città</label></label>
                <input class="form-control" name="city" type="Text" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">CAP</label></label>
                <input class="form-control" name="cap" type="number" id="formFile" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control" type="password" name="password" id="password" onkeyup="controllaPassword()" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirma Password</label>
                <input class="form-control" type="password" name="password-confirm" id="confermaPassword"onkeyup="controllaPassword()"  required>
                <span id="messaggio"></span><br><br>
            </div>
            <div class="mb-3">
            <button type="submit" class="btn btn-primary btn-lg">Invia</button>
            </div>

        </form>
    </div>


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
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>