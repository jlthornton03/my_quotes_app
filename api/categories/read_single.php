<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $category->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
    
    $category->read_single();

    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
        );

    if (empty($category->id)){
        echo (json_encode(array('message'=>'categoryId Not Found')));
    }else{
        echo(json_encode($category_arr));
    }