<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    $quote->id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
    
        $quote->read_single();

        $quote_arr = array(
            'id' => $quote->id,
            'quote' => $quote->quote
         );

        
    if (empty($quote->id)){
        echo json_encode(array('message'=>'No Quotes Found')); 
    }else{
        echo(json_encode($quote_arr));
    }

