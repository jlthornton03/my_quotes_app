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
    $Quote->id = $data->id;
    $Quote->categoryid = $data->categoryId;
    $Quote->authorid = $data->authorId;
    $Quote->quoteinput = $data->quote;

    if ( ($Quote->id == 0) || ($Quote->quoteinput == 0) || ($Quote->categoryid == 0) || (empty($Quote->author) == 0 )){
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Quote->update();
    }
        