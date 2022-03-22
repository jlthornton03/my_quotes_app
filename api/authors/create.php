<?php



    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $createAuthor = new Author($db);
    
    $createAuthor->author = ( isset( $_GET['author'] )  ) ? strval( $_GET['author'] ) : 0;
    
    if (empty($createAuthor->author)==false){
        $result=$createAuthor->create();    
    }else{
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }
