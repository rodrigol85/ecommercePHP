<?php

require_once 'DataUser.php';

class User {
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $role;
    private $status;
    private $confirm_code;
    private $telefono;
    private $address;
    private $db;

    public function __construct($id, $name, $surname, $email, $password, $role, $status, $confirm_code, $telefono, $address){
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
        $this->confirm_code = $confirm_code;
        $this->telefono = $telefono;
        $this->address = $address;
        $this->db = DataUser::getInstance()->getConnection();
        

    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
        
    public function getSurname(){
        return $this->surname;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getRole(){
        return $this->role;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getConfirm_code(){
        return $this->confirm_code;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getAddress(){
        return $this->address;
    }
      
    public function setAddress($address) {
        $this->address = $address;
    }    
        
    public function setConfirm_pass($confirm_code) {
        $this->confirm_code = $confirm_code;
    }   

   

    public static function getAll() {
        $db = DataUser::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['id'],
                $row['name'],
                $row['surname'],
                $row['email'],
                $row['password'],
                $row['role'],
                $row['status'],
                $row['confirm_code'],
                $row['telefono'],
                $row['address_id'],
                $db // Passa l'istanza di Database al costruttore di User
            );
        }
        return $users;
    }

    public static function findByEmail($email) {
        $db = DataUser::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
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
                $row['address_id'],
                $db
            );
        } else {
            return null;
        }
    }
    

    
    public static function deleteById($id)
    {
        $db = DataUser::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
        try {
            $stmt->execute([':id' => $id]);
          
        } catch (PDOException $e) {
            echo "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
        $stmt = null;
        $conn = null;

    }
    
        
    
}

class Address{
    private $address_id;
    private $street;
    private $city;
    private $cap;
    private $db;
   

    public function __construct($address_id, $street, $city, $cap){
        $this->address_id = $address_id;
        $this->street = $street;
        $this->city = $city;
        $this->cap = $cap;
        $this->db = DataUser::getInstance()->getConnection();
        
    }
   
    public function getAddress_id(){
        return $this->address_id;
    }
    public function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }  
    public function getStreet(){
        return $this->street;
    }
    public function getCity(){
        return $this->city;
    }
    public function getCap(){
        return $this->cap;
    }


    
    public static function getAll() {
        $db = DataUser::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM addresses");
        $stmt->execute();
        $addresses = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new Address(
                $row['address_id'],
                $row['street'],
                $row['city'],
                $row['cap'],
                
                $db // Passa l'istanza di Database al costruttore di User
            );
        }
        return $addresses;
    }


 



}













?>