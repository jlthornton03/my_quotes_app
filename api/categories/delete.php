<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $deleteCategory = new Category($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $deleteCategory->id = $data->id;
    
    if (empty($deleteCategory->id)==false){
        $deleteCategory->delete();
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }