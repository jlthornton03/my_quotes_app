<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $createCategory = new Category($db);
    
    $createCategory->category = ( isset( $_GET['category'] ) && is_string( $_GET['category'] ) ) ? ( $_GET['category'] ) : 0;

    if (empty($createCategory->category)==false){
        $createCategory->create();
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }