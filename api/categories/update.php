<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $Category = new Category($db);

    $data = json_decode(file_get_contents("php://input"));
    
    $Category->id = $data->id;
    $Category->category = $data->category;


    if (($Category->category==0) || ($Category->id==0)) {
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Category->update();
    }
        