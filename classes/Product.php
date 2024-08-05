<?php

//define('ROOT', dirname(__FILE__) . '/../../');
require_once ROOT . 'database/conexionPDO.php';




class Product
{
    private $id;
    private $name;
    private $description;
    private $quantity;
    private $price;
    private $category;
   

    public function __construct($id = null, $name, $description, $quantity, $price, $category)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->category = $category;
        
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getCategory()
    {
        return $this->category;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }


    

    public static function getAll()
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product($row['id'], $row['name'],$row['description'], $row['quantity'],$row['price'], $row['category_id']);
        }
        return $products;
    }

    public static function deleteById($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
        try {
            $stmt->execute([':id' => $id]);
          
        } catch (PDOException $e) {
            echo "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
        $stmt = null;
        $conn = null;

    }


   
  
    
  
    
    
    
    
}







//==============CLASS CATEGORY ================================================================

class Category
{
    private $id;
    private $name;




    public function __construct($name = null, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }





    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function save()
    {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->execute([':name' => $this->name]);
        $this->id = $conn->lastInsertId();
    }

    public static function getAll()
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM category");
        $stmt->execute();
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($row['name'], $row['id']);
        }
        return $categories;
    }

    public function update()
    {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE `category` SET `name` = :name WHERE id = :id");
        $stmt->execute([':name' => $this->name, ':id' => $this->id]);

        $countStmt = $conn->prepare("SELECT COUNT(*) FROM `category` WHERE id = :id");
        $countStmt->execute([':id' => $this->id]);
        $row = $countStmt->fetch();

        if ($row && $row[0] > 0) {
            
            return true;
        } else {
           
            return false;
        }
    }


    public static function findById($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {

            return null;
        }

        return new Category($result['name'], $result['id']);
    }

    public static function deleteById($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM category WHERE id = :id");
        try {
            $stmt->execute([':id' => $id]);
          
        } catch (PDOException $e) {
            echo "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
        $stmt = null;
        $conn = null;

    }
}
