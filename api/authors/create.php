<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $createAuthor = new Author($db);
    
    $createAuthor->author = ( isset( $_GET['author'] )  ) ? strval( $_GET['author'] ) : 0;
    echo $createAuthor->author . "\n";
    
    if (empty($createAuthor->author)==false){
        $createAuthor->create();
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }