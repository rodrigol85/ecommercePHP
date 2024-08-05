<?php

require_once './classes/DB.php'; 
class ProductRepository {

  public function create(Product $product) {
    $conn = Db::getConnection();

    $sql = "INSERT INTO products (name, description, quantity, price, category_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $product->getName(), $product->getDescription(), $product->getQuantity(), $product->getPrice(), $product->getCategory()->getId()); // Assuming category has an getId() method
    $stmt->execute();
    $stmt->close();
  }

  public function read($id) {
    $conn = Db::getConnection();

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = null;
    if ($result->num_rows === 1) {
      $row = $result->fetch_assoc();
      $product = new Product($row['id'], $row['name'], $row['description'], $row['quantity'], $row['price'], null); // Assuming you have a way to get category details
    }
    $stmt->close();

    return $product;
  }

  public function update(Product $product) {
    $conn = Db::getConnection();

    $sql = "UPDATE products SET name = ?, description = ?, quantity = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdi", $product->getName(), $product->getDescription(), $product->getQuantity(), $product->getPrice(), $product->getId());
    $stmt->execute();
    $stmt->close();
  }

  public function delete($id) {
    $conn = Db::getConnection();

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }
}

class CategoryRepository {

  public function create(Category $category) {
    $conn = Db::getConnection();

    $sql = "INSERT INTO category (name) VALUES (?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category->getName()); 
    $stmt->execute();
    $stmt->close();
  }

  }



      ?>