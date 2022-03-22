<?php
class Author{
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        //Create query
        $query = 'SELECT 
            id, author
            FROM authors';
            
        $stmt = $this->conn->prepare($query);
    
        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
    
        return $stmt;
        }



    public function read_single() {
        $query = 'SELECT id, author
            FROM authors
            WHERE id = ? ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->author = $row['author'];
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . '
            SET
            author = ?';
        
        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(1, $this->author);

        try {
            $stmt->execute();
            $last_id = $this->conn->lastInsertId();
            $this->outputChange($last_id,$this->author);
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
    }

    public function update(){

        $result = $this->checkAuthor();
        if ($result == true){
        $query ='UPDATE '. $this->table .'
            SET author = ?
            WHERE id = ?';
        
        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(1, $this->author);
        $stmt->bindParam(2, $this->id);

        try {
            $stmt->execute();
            $this->outputChange($this->id,$this->author);
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
        }
    }

    public function delete(){
        $result = $this->checkAuthor();
        if ($result == true){
         $query ='delete from '. $this->table .'
              WHERE id = ?';
        
          $stmt = $this->conn->prepare($query);

          $stmt->bindParam(1, $this->id);

          try {
             $stmt->execute();
                echo json_encode(array('id' => $this->id));
              } catch (Exception $e) {
                echo json_encode(array('message'=>$e));
              }
        }
    }

    public function checkAuthor(){
        
        $query = 'Select * 
                    from authors
                    where id= :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
    
        if ($stmt->rowCount()==0){
            echo json_encode(array('message'=>'authorId Not Found'));
           return false;
           }
        else{
            return true;
        }
    }



    public function outputChange($changeId, $changeAuthor){
        $change_arr = array(
            'id' => $changeId, 
            'author' => $changeAuthor
        );
        echo json_encode($change_arr);
    }
}

