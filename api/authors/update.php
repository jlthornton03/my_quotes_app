<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $Author = new Author($db);

    $data = json_decode(file_get_contents("php://input"));

    $Author->id = $data->id;
    $Author->author = $data->author;

    if (($Author->author==0) || ($Author->id==0)) {
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Author->update();
    }
        