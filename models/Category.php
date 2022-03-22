<?php
class Category{
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    //get all categories
    public function read() {

        $query = 'SELECT 
            id, category
            FROM categories';
            
        $stmt = $this->conn->prepare($query);
    
        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
    
        return $stmt;
        }

    //read a single category based on ?id=#
    public function read_single() {
        $query = 'SELECT id, category
            FROM categories
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
        $this->category = $row['category'];
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . '
            SET
            category = ?';

        $stmt = $this->conn->prepare($query);

        $this->category = htmlspecialchars(strip_tags($this->category));

        $stmt->bindParam(1, $this->category);
        try {
            $stmt->execute();
            $last_id = $this->conn->lastInsertId();
            $this->outputChange($last_id,$this->category);
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          } 
    }

    public function update(){

        $result=$this->checkCategory();
        if ($result == true){
         $query ='UPDATE '. $this->table .'
              SET category = ?
                WHERE id = ?';
            
            $stmt = $this->conn->prepare($query);

         $this->category = htmlspecialchars(strip_tags($this->category));

            $stmt->bindParam(1, $this->category);
            $stmt->bindParam(2, $this->id);

         try {
             $stmt->execute();
              $this->outputChange($this->id,$this->category);
            } catch (Exception $e) {
                echo json_encode(array('message'=>$e));
            }
        }
    }

    public function delete(){

        $result=$this->checkCategory();
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

    public function checkCategory(){
        
        $query = 'Select * 
                    from categories
                    where id= :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
    
        if ($stmt->rowCount()==0){
            echo json_encode(array('message'=>'categoryId Not Found'));
           return false;
           }
        else{
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return true;
        }
    }

    public function outputChange($changeId, $changeCategory){
        $change_arr = array(
            'id' => $changeId, 
            'category' => $changeCategory
        );
        echo json_encode($change_arr);
    }
}