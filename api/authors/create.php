<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $createAuthor = new Author($db);
    
    $createAuthor->author = ( isset( $_GET['author'] ) && is_string( $_GET['author'] ) ) ? ( $_GET['author'] ) : 0;
    
    if (empty($createAuthor->author)==false){
        $createAuthor->create();
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }