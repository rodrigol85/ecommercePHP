<?php

require_once 'DataUser.php';

class Admin{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $status;
    private $confirm_code;
    private $telefono;

    private $db;

    
    public function __construct($id, $name, $surname, $email, $password, $status, $confirm_code, $telefono){
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
        $this->confirm_code = $confirm_code;
        $this->telefono = $telefono;
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
  
    public function getStatus(){
        return $this->status;
    }
    public function getConfirm_code(){
        return $this->confirm_code;
    }
    public function getTelefono(){
        return $this->telefono;
    }
  
 
        
    public function setConfirm_pass($confirm_code) {
        $this->confirm_code = $confirm_code;
    }   


    public static function findByEmail($email) {
        $db = DataUser::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            return new Admin(
                $row['id'],
                $row['name'],
                $row['surname'],
                $row['email'],
                $row['password'],
                $row['status'],
                $row['confirm_code'],
                $row['telefono'],
                $db
            );
        } else {
            return null;
        }
    }

    public static function createAdmin($nome, $cognome, $email, $password, $status, $confirm_code, $telefono) {
        $db = DataUser::getInstance()->getConnection();
    
        try {
           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $stmt = $db->prepare('INSERT INTO `admins` (`name`, `surname`, `email`, `password`, `status`, `confirm_code`, `telefono`) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->bindValue(1, $nome, PDO::PARAM_STR);
            $stmt->bindValue(2, $cognome, PDO::PARAM_STR);
            $stmt->bindValue(3, $email, PDO::PARAM_STR);
            $stmt->bindValue(4, $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(5, $status, PDO::PARAM_STR);
            $stmt->bindValue(6, $confirm_code, PDO::PARAM_STR);
            $stmt->bindValue(7, $telefono, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return true;
            } else {
                
                throw new Exception('Error creating admin: ' . $stmt->errorInfo()[2]);
            }
        } catch (PDOException $e) {
         
            echo 'Database error: ' . $e->getMessage();
            return false;
        }
    }
    
}