<?php

//define('ROOT', dirname(__FILE__) . '/../../');
require_once ROOT . 'database/conexionPDO.php';




class Order
{
    private $id_order;
    private $chart_id;
    private $user_id;
    private $order_at;
    private $order_state;
    private $total;

        public function __construct($id_order = null, $chart_id, $user_id, $order_at, $order_state, $total)
        {
            $this->id_order = $id_order;
            $this->chart_id = $chart_id;
            $this->user_id = $user_id;
            $this->order_at= $order_at;
            $this->order_state= $order_state;
            $this->total = $total;
        }


        public function getId_order()
        {
            return $this->id_order;
        }
        public function getChart_id(){
            return $this->chart_id;
        }
        public function getUser_id(){
            return $this->user_id;
        }
        public function getOrder_at(){
            return $this->order_at;
        }
        public function getOrder_state(){
            return $this->order_state;
        }
        public function getTotal(){
            return $this->total;
        }



        public static function getAll()
        {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM orders");
            $stmt->execute();
            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[] = new Order($row['id_order'], $row['chart_id'],$row['user_id'], $row['order_at'],$row['order_state'], $row['total']);
            }
            return $orders;
        }
        public static function getAllPending()
        {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM orders WHERE order_state= 'pending' ");
            $stmt->execute();
            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orders[] = new Order($row['id_order'], $row['chart_id'],$row['user_id'], $row['order_at'],$row['order_state'], $row['total']);
            }
            return $orders;
        }




}


?>