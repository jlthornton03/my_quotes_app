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
            $this->url = getenv('JAWSDB_URL');
            $this->dbparts = parse_url($url);
            $this->host = $dbparts['host'];
            $this->username = $dbparts['user'];
            $this->password = $dbparts['pass'];
            $this->dbname = ltrim($dbparts['path'],'/');
            echo $this->host . "\n";
            echo $this->username . "\n";
            echo $this->password . "\n";
            echo $this->dbname . "\n";
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