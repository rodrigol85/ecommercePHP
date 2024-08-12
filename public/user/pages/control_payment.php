

<?php

define('ROOT', dirname(__FILE__) . '/../../../');

require_once ROOT . 'phpmailer/sendEmail.php';
require_once ROOT . 'classes/Chart.php';
require_once ROOT . 'classes/chart_items.php';
require_once ROOT . 'classes/Product.php';
require_once ROOT . 'classes/Database.php';
require_once ROOT . 'inc/config.php';

session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['chart_id'])) {
  session_start();
  $_SESSION['errorMessage'] = "Prima deve loggarsi ";
  header("Location: ". ROOT_URL . "user/public/?page=login");
 
    die();
}



$user_id = $_SESSION['user_id'];
$chart_id = $_POST['chart_id'];
$total =  $_POST['total'];
$email = $_SESSION['email'];
$link = '';

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ecommerce';

$db = new Database('localhost', 'root', '', 'ecommerce');
$chart_items = $db->findChartItems($chart_id);
$total = 0;


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch(PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    die();
}




//================ Corpo dell'email da mandare all'utente ===========

//prepara l'email da mandare all'utente 
$subject = 'Pagamento avviato con successo, i detagli del suo acquisto';

$emailBody= '<h4>Ecommerce</h4><br> 
<h6>I detagli del suo acquisto</h6><br>
<table class="table table-striped table-bordered">
                <thead class="table-info">
                    <tr>
                        <th scope="col">Nome Prodotto</th>
                        <th scope="col">Prezzo</th>
                        <th scope="col">Quantit&agrave;</th>
                        <th scope="col">Totale</th>
                        <th scope="col">Immagine</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($chart_items as $item) {
    $product = $db->findByIdProduct($item->getProduct_id());
    if ($product) {
       
      
        $total += ($item->getUnit_price() * $item->getQuantity());

        $emailBody .= '<tr>
                        <th>' . $product->getName() . '</th>
                      
                        <th>' . $product->getPrice() . ' &euro;</th>
                        <th>' . $item->getQuantity() . '</th>
                        <th>' . ($item->getUnit_price() * $item->getQuantity()) . ' &euro;</th>
                        <th><img src="https://newlupetto.com/5462-amazon/sciarpa-stadium-giallo-rosso.jpg" style="width: 100px;" class="rounded float-end" alt=""></th>
                    </tr>';
    }
}

$emailBody .= '<th colspan="4" class="table-info">Totale</th>
            <th class="table-primary"> '.  number_format($total, 2) . ' &euro;;</th>
            <th class="table-info"></th>
        </tr>
 </tbody></table>';


//=============================================================================================================




    //Controllo che tutti i dati richiesti  mi sono arrivati dal form

    if (empty($chart_id) || empty($user_id) || empty($total)) {
        throw new Exception("Dati richiesti mancanti");
    } else {
        $query = "INSERT INTO orders (chart_id, user_id, order_state, total) VALUES (:chart_id, :user_id, 'pending', :total)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':chart_id', $chart_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':total', $total);
    
        try {
            if ($stmt->execute()) {
                try {
                    $updateQuery = "UPDATE charts SET state = 'pagato' WHERE id_chart = :chart_id";
                    $updateStmt = $pdo->prepare($updateQuery);
                    $updateStmt->bindParam(':chart_id', $chart_id);
        
                    if ($updateStmt->execute()) {
                        $result= $updateStmt->rowCount();
                        if ($result > 0) {
                            inviaEmail($email, $subject, $emailBody, $link);
                            session_start();
                            $_SESSION['errorMessage'] = "Il pagamento è avvenuto con successo, contralla la sua email";
                            
                            header("Location: ". ROOT_URL . "public/?page=products");
                        } else {
                            session_start();
                            $_SESSION['errorMessage'] = "Si è verificato un errore";
                            //header("Location: http://localhost/ecommerce/public/?page=login ");
                            header("Location: ". ROOT_URL . "user/public/?page=login");
                              die();
                        }
                    } else {
                        throw new Exception("Errore durante l'aggiornamento del carrello.");
                    }
                } catch (PDOException $e) {
                    echo "Errore di database: " . $e->getMessage();
                }
            } else {
                // Qualcosa è andato storto, ma non è stata lanciata un'eccezione
                echo "Si è verificato un errore durante l'inserimento dell'ordine.";
            }
        } catch (PDOException $e) {
            // Gestisci l'errore, ad esempio loggandolo o inviando una notifica
            echo "Errore durante l'inserimento dell'ordine: " . $e->getMessage();
        }
    }
    
    
  





?>
