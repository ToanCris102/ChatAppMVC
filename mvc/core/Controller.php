<?php 
    class Controller{
        public function model($model){
            //Format for empty require
            require_once "./mvc/models/".$model.".php";
            return new $model;
        }

        public function view($view, $data=[]){
            require_once "./mvc/views/".$view.".php";            
        }
    }
?>