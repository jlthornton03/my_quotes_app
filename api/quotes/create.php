<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();
    
    $Quote = new Quote($db);


    $data = json_decode(file_get_contents("php://input"));

    $Quote->categoryid = $data->categoryId;
    $Quote->authorid = $data->authorId;
    $Quote->quote = $data->quote;
    
    

    if ( empty($Quote->quote) || empty($Quote->categoryid) || empty($Quote->authorid)){
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Quote->create();
    }