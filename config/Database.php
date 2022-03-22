<?php
    class Database {
        //DB Params

        //private $host = 'localhost';

       // private $dbname = 'quotesdb';
       // private $username = 'root';
       // private $password = '123456';

       // private $url2 = getenv('JAWSDB_URL');
        private $url;
        private $dbparts;
        private $host;
        private $dbname; 
        private $password; 
        private $username;
        private $conn;

      //  //DB Connect
        function __construct() {
            $url = getenv('JAWSDB_URL');
            $dbparts = parse_url($url);
            $this->host = $dbparts['host'];
            $this->username = $dbparts['user'];
            $this->password = $dbparts['pass'];
            $this->dbname = ltrim($dbparts['path'],'/');
           // echo $dbname . "\n";
            
        }

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