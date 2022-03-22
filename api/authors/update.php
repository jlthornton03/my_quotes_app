<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $Author = new Author($db);

    $Author->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
    $Author->author = ( isset( $_GET['author'] ) && is_string( $_GET['author'] ) ) ? ( $_GET['author'] ) : 0;

    if (($Author->author==0) || ($Author->id==0)) {
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Author->update();
    }
        