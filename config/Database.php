<?php
    class Database {
        //DB Params

        private $host = 'localhost';
        private $dbname = 'quotesdb';
        private $username = 'root';
        private $password = '123456';
        private $conn;

      //  //DB Connect
      //  function __construct() {
      //      $this->password = getenv('mysqlpwd');
      //  }

        public function connect() {
            $this->conn = null;
            try{
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname='. $this->dbname, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }
        return $this->conn;
        }
    }