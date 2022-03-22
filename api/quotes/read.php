<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    $quote->authorid = ( isset( $_GET['authorId'] ) && is_numeric( $_GET['authorId'] ) ) ? intval( $_GET['authorId'] ) : 0;
    $quote->categoryid = ( isset( $_GET['categoryId'] ) && is_numeric( $_GET['categoryId'] ) ) ? intval( $_GET['categoryId'] ) : 0;

    $result = $quote->read();

    $num = $result->rowCount();

    if($num > 0){
        $quote_arr = array();
       // $quote_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'authorid' => $authorid,
                'categoryid' => $categoryid
            );
          array_push($quote_arr, $quote_item);  
        }

        echo json_encode($quote_arr);

    }else {
        echo (json_encode(array('message'=>'No Quotes Found')));
    }

   