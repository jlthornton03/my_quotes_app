<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $deleteCategory = new Category($db);
    
    $deleteCategory->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? ( $_GET['id'] ) : 0;
    
    if (empty($deleteCategory->id)==false){
        $deleteCategory->delete();
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }