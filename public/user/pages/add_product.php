

<?php

session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id'])) {
  session_start();
  $_SESSION['errorMessage'] = "Prima deve loggarsi ";  
  header("Location: http://localhost/ecommerce/public/?page=login ");
    die();
}
$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$unit_price = $_POST['unit_price'];

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ecommerce';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
 // Gestisce gli errori come eccezioni
} catch(PDOException $e) {
    echo "Errore di connessione al database: " . $e->getMessage();
    die();
}
// Verifica esistenza carrello
$query = "SELECT id_chart FROM charts WHERE user_id = :user_id AND state = 'active' LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  // Crea nuovo carrello
  $query = "INSERT INTO charts (user_id, state) VALUES (:user_id, 'active')";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();
  $chart_id = $pdo->lastInsertId();
} else {
  $chart_id = $row['id_chart'];
}
$_SESSION['cart_id'] = $chart_id;
// Verifica esistenza prodotto nel carrello
$query = "SELECT id_chart_item FROM chart_items WHERE chart_id = :chart_id AND product_id = :product_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':chart_id', $chart_id);
$stmt->bindParam(':product_id', $product_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  // Inserisci nuovo prodotto nel carrello
  $query = "INSERT INTO chart_items (chart_id, product_id, quantity, unit_price) VALUES (:chart_id, :product_id, 1, :unit_price)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':chart_id', $chart_id);
  $stmt->bindParam(':product_id', $product_id);
  $stmt->bindParam(':unit_price', $unit_price);
  $stmt->execute();
} else {
  // Aggiorna quantità prodotto
  $id_chart_item = $row['id_chart_item'];
  $query = "UPDATE chart_items SET quantity = quantity + 1 WHERE id_chart_item = :id_chart_item";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id_chart_item', $id_chart_item);
  $stmt->execute();
}

//con questo codice rimane nella stessa pagina dove aggiunge al carrello
header('Content-Type: application/json');
echo json_encode(['success' => true]);
exit;