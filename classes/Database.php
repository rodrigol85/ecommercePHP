<?php



    class Database {
        private $conn;
    
        public function __construct($host, $user, $password, $dbname) {
            try {
                $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8mb4');
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }
    
      //=====================================================================================================================
                            // METODI PRODUCT
        //=====================================================================================================================
    
    

    public function saveProduct($name, $description, $quantity, $price, $category) {
        $stmt = $this->conn->prepare('INSERT INTO `products` (`name`, `quantity`, `price`, `description`, `category_id`) VALUES(?, ?, ?, ?, ?)');
        $stmt->bindValue(1, $name, PDO::PARAM_STR);
        $stmt->bindValue(2, $description, PDO::PARAM_STR);
        $stmt->bindValue(3, $quantity, PDO::PARAM_INT);
        $stmt->bindValue(4, $price, PDO::PARAM_STR); // Assumendo che il prezzo sia un numero decimale, altrimenti usa PDO::PARAM_INT
        $stmt->bindValue(5, $category, PDO::PARAM_INT); // Assumendo che la categoria sia un ID numerico

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getCategoryName($id) {
        $stmt = $this->conn->prepare('SELECT name FROM category WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'] ?? '';
    }


    public function updateProduct($id, $name, $description, $quantity, $price, $category) {
        $stmt = $this->conn->prepare("UPDATE `products` SET `name` = :name, `description` = :description, `quantity` = :quantity, `price` = :price, `category_id` = :category_id WHERE `id` = :id");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR); // 
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $category, PDO::PARAM_INT); 
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function findByIdProduct($id) {
        
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            return null;
        }
    
        return new Product(
            $result['id'],
            $result['name'],
            $result['description'],
            $result['quantity'],
            $result['price'],
            $result['category_id']
        );
    }


    //questo metodo lo utilizzo per fare la ricerca per il nome
    public function findProductsByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE name LIKE :name");
        $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!$result) {
                return []; 
            }
    
            $products = [];
            foreach ($result as $row) {
                $products[] = new Product(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['quantity'],
                    $row['price'],
                    $row['category_id']
                );
            }
    
            return $products;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Restituisce un array vuoto in caso di errore
        }
    }
    

//METODO PER CARICARE UN UTENTE SINGOLO, NON MI PERMETTEVA FARLO NELLA CLASSE USER E HO TROVATO QUESTO APPROCCIO PER AVERE IL RESULTATO 
// Metodi classe User
    public function findByIdUser($id){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }
        return new User(
            $row['id'],
            $row['name'],
            $row['surname'],
            $row['email'],
            $row['password'],
            $row['role'],
            $row['status'],
            $row['confirm_code'],
            $row['telefono'],
            $row['address_id']
        );

    }

    public function updateUser($id, $name, $surname, $email, $role, $status,$telefono) {
        $stmt = $this->conn->prepare("UPDATE `users` SET `name` = :name, `surname` = :surname, `email` = :email, `role` = :role, `status` = :status, `telefono` = :telefono  WHERE `id` = :id");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR); // 
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR); 
        $stmt->bindValue(':telefono', $telefono, PDO::PARAM_INT); 
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //questa funzione mi serve per attivare l'account dopo che l'utente si registra

    public function findByToken($confirm_code){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE confirm_code = :confirm_code");
        $stmt->bindValue(':confirm_code', $confirm_code, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }
        return new User(
            $row['id'],
            $row['name'],
            $row['surname'],
            $row['email'],
            $row['password'],
            $row['role'],
            $row['status'],
            $row['confirm_code'],
            $row['telefono'],
            $row['address_id']
        );

    }

    public function activeAccount($confirm_code) {
        $stmt = $this->conn->prepare("UPDATE `users` SET `status` = 'activated', `confirm_code` = NULL WHERE `confirm_code` = :confirm_code");
        $stmt->bindValue(':confirm_code', $confirm_code, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Gestisci l'errore, ad esempio loggandolo o restituendo un messaggio informativo
            echo "Errore durante l'attivazione dell'account: " . $e->getMessage();
            return false;
        }
    }

//con questo metodo conto i prodotti che ci sono nel database per poter fare la paginazione nella pagina products cartella user

    public function countProducts() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM products");
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row[0];
        } else {
            
            echo 'Errore nella query: ' . $stmt->errorInfo()[2];
            return false;
        }
    }
    

    public function getPaginatedProducts($offset, $limit) {
        $offset = max(0, (int)$offset);
        $limit = max(1, (int)$limit);
    
        $query = "SELECT * FROM products LIMIT $offset, $limit";
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            
            echo "Errore nella query: " . $e->getMessage();
            return []; 
        }
    }
    
    
    
    







    //====================Metodi Classe Indirizzo =====================

       public function findByIdAddress($id){
        $stmt = $this->conn->prepare("SELECT * FROM addresses WHERE address_id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }
        return new Address(
            $row['address_id'],
            $row['street'],
            $row['city'],
            $row['cap'],
           
        );

    }


    public function updateAddress($address_id, $street, $city, $cap) {
        $stmt = $this->conn->prepare("UPDATE `addresses` SET `street` = :street, `city` = :city, `cap` = :cap WHERE `address_id` = :address_id");
        $stmt->bindValue(':street', $street, PDO::PARAM_STR);
        $stmt->bindValue(':city', $city, PDO::PARAM_STR);
        $stmt->bindValue(':cap', $cap, PDO::PARAM_INT); //  
        $stmt->bindValue(':address_id', $address_id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    //===========================================================================================

    //              Metodi CHART

    //============================================================================================

    public function findChartActive($user_id){
        $stmt = $this->conn->prepare("SELECT id_chart, user_id, created_at, state FROM charts WHERE user_id = :user_id AND state = 'active' LIMIT 1");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return [];
        }
        // Controllo se i campi esistono nell'array $row
        if (!isset($row['id_chart'], $row['user_id'], $row['created_at'], $row['state'])) {
           
            return null;
        }
        return new Chart(
            $row['id_chart'],
            $row['user_id'],
            $row['created_at'],
            $row['state']
        );
    }
    public function findChartById($chart_id){
        $stmt = $this->conn->prepare("SELECT * FROM charts WHERE id_chart= :chart_id");
        $stmt->bindValue(':chart_id', $chart_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return [];
        }
        // Controllo se i campi esistono nell'array $row
        if (!isset($row['id_chart'], $row['user_id'], $row['created_at'], $row['state'])) {
           
            return [];
        }
        return new Chart(
            $row['id_chart'],
            $row['user_id'],
            $row['created_at'],
            $row['state']
        );
    }

    public function updateChartState($id_chart) {
        $stmt = $this->conn->prepare("UPDATE `charts` SET `state` = 'abandoned' WHERE `id_chart` = :id_chart");
        $stmt->bindValue(':id_chart', $id_chart, PDO::PARAM_INT); 
       
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function findAbandonedChart(){
        $stmt = $this->conn->prepare("SELECT * FROM charts WHERE state = 'abandoned' ");
        
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows){
            return [];
        }
        $charts = [];
        foreach ($rows as $row) {
            $charts[] = new Chart(
                $row['id_chart'],
                $row['user_id'],
                $row['created_at'],
                $row['state']
           
            );
        }
        return $charts;

    }


    






    //================================================================

               // METODI CHART-ITEMS
    //===================================================================


    public function findChartItems($chart_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM chart_items WHERE chart_id = :chart_id");
            $stmt->bindValue(':chart_id', $chart_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $cartItemsResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!$cartItemsResult) {
                return null;
            }
    
            // Crea un array di oggetti Chart_Items
            $cartItems = [];
            foreach ($cartItemsResult as $cartItem) {
                $cartItems[] = new Chart_Items(
                    $cartItem['id_chart_item'],
                    $cartItem['chart_id'],
                    $cartItem['product_id'],
                    $cartItem['quantity'],
                    $cartItem['unit_price']
                );
            }
    
            return $cartItems;
        } catch (PDOException $e) {
            
            echo "Errore nella query: " . $e->getMessage();
            return null;
        }
    }
    public function deleteItem($id_chart_item) {
        $stmt = $this->conn->prepare("DELETE FROM chart_items WHERE id_chart_item = :id_chart_item");
        $stmt->bindValue(':id_chart_item', $id_chart_item, PDO::PARAM_INT); 
    
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Item deleted successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete item'];
        }
    }
    
    
    

    public function countItemsInChart($chart_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as items FROM chart_items WHERE chart_id = :chart_id");
        $stmt->bindValue(':chart_id', $chart_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['items'];
    }









    //=====================================================================================================================
                //Metodi Orders
    //=======================================================================================================================


    public function findOrdertById($id_order){
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id_order= :id_order");
        $stmt->bindValue(':id_order', $id_order, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row){
            return null;
        }
        // Controllo se i campi esistono nell'array $row
        if (!isset($row['id_order'], $row['chart_id'],  $row['user_id'], $row['order_at'], $row['order_state'], $row['total'])) {
           
            return null;
        }
        return new Order(
            $row['id_order'],
            $row['chart_id'],
            $row['user_id'],
            $row['order_at'],
            $row['order_state'],
            $row['total']
        );
    }

    public function updateOrderState($id_order, $new_state) {
        $stmt = $this->conn->prepare("UPDATE `orders` SET `order_state` = :order_state WHERE `id_order` = :id_order");
        $stmt->bindValue(':order_state', $new_state, PDO::PARAM_STR);
        $stmt->bindValue(':id_order', $id_order, PDO::PARAM_INT); 
       
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

   
    
    
    
}






?>