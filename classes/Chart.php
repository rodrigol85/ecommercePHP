<?php

//define('ROOT', dirname(__FILE__) . '/../../');
require_once ROOT . 'database/conexionPDO.php';


class Chart{
    private $state;
    private $id_chart;
    private $user_id;
    private $created_at;

        public function __construct($id_chart = null, $user_id, $created_at, $state){
            $this->state =  $state;
            $this->id_chart = $id_chart;
            $this->user_id = $user_id;
            $this->created_at = $created_at;
        }

        public function getState(){
            return $this->state;
        }
        public function getId_chart()
        {
            return $this->id_chart;
        }
        public function getUser_id(){
            return $this->user_id;
        }
        public function getCreated_at(){
            return $this->created_at;
        }



}













?>