<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $Category = new Category($db);

    $Category->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
    $Category->category = ( isset( $_GET['category'] ) && is_string( $_GET['category'] ) ) ? ( $_GET['category'] ) : 0;

    if (($Category->category==0) || ($Category->id==0)) {
        echo json_encode(array('message'=>'Missing Required Parameters'));
    }else{
        $Category->update();
    }
        