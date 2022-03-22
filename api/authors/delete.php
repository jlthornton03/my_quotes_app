<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $deleteAuthor = new Author($db);
    
    $deleteAuthor->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? ( $_GET['id'] ) : 0;
    
    if (empty($deleteAuthor->id)==false){
        $deleteAuthor->delete();
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }