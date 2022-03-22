<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);

    $author->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
    
    $author->read_single();

    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
        );

    if (empty($author->id)){
        echo json_encode(array('message'=>'authorId Not Found'));
    }else{
        echo(json_encode($author_arr));
    }