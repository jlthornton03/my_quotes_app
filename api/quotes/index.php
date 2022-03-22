<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    }

    if ($method == 'GET'){
        $quote_id = ( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) ? intval( $_GET['id'] ) : 0;
        if (empty($quote_id)){
            include_once 'read.php';
        }else{
            include_once 'read_single.php';
        }
    }elseif($method == 'POST') {
        include_once 'create.php';
    }elseif($method == 'PUT'){
        include_once 'update.php';
    }else{
        echo "Not Configured";
    }

