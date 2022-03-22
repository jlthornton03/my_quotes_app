<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $Quote = new Quote($db);

    $Quote->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
    $Quote->categoryid = ( isset( $_GET['categoryId'] ) && is_numeric( $_GET['categoryId'] ) ) ? intval( $_GET['categoryId'] ) : 0;
    $Quote->authorid = ( isset( $_GET['authorId'] ) && is_numeric( $_GET['authorId'] ) ) ? intval( $_GET['authorId'] ) : 0;
    $Quote->quoteinput = ( isset( $_GET['quote'] ) && is_string( $_GET['quote'] ) ) ? ( $_GET['quote'] ) : 0;


    if ( ($Quote->id == 0) || ($Quote->quoteinput == 0) || ($Quote->categoryid == 0) || (empty($Quote->author) == 0 )){
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Quote->update();
    }
        