<?php

//define('ROOT', dirname(__FILE__) . '/../../');
require_once ROOT . 'database/conexionPDO.php';


class Chart_items {
    private $id_chart_item;
    private $chart_id;
    private $product_id;
    private $quantity;
    private $unit_price;

        public function __construct($id_chart_item = null, $chart_id, $product_id, $quantity, $unit_price){
            $this->id_chart_item = $id_chart_item;
            $this->chart_id = $chart_id;
            $this->product_id = $product_id;
            $this->quantity = $quantity;
            $this->unit_price =  $unit_price;
        }

        public function getId_chart_item(){
            return $this->id_chart_item;
        }
        public function getChart_id(){
            return $this->chart_id;
        }
        public function getProduct_id(){
            return $this->product_id;
        }
        public function getQuantity(){
            return $this->quantity;
        }
        public function getUnit_price(){
            return $this->unit_price;
        }


    }


    ?>