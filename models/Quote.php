<?php
class Quote{
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $authorid;
    public $categoryid;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function read() {
        //Create query
        if ((empty($this->authorid)==false) && (empty($this->categoryid)==false)){
            $query = 'SELECT 
            id, quote, authorid, categoryid
            FROM quotes
            where authorid= ? and categoryid = ? ';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->authorid);
            $stmt->bindParam(2, $this->categoryid);
        }elseif(empty($this->authorid)==false){
            $query = 'SELECT 
            id, quote, authorid, categoryid
            FROM quotes
            where authorid= ?';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->authorid);
        }elseif(empty($this->categoryid)==false){
            $query = 'SELECT 
            id, quote, authorid, categoryid
            FROM quotes
            where categoryid= ?';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->categoryid);
        }else{
            $query = 'SELECT 
            id, quote, authorid, categoryid
            FROM quotes';
            $stmt = $this->conn->prepare($query);
        }
  
        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
        
        return $stmt;
        }
    
    //read a single category based on ?id=#
    public function read_single() {
        $query = 'SELECT 
            id, quote, authorid, categoryid
            FROM quotes
            where id= ? ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->quote = $row['quote'];
    }

    public function create(){
    
        $cresult=$this->checkRecord('categories','category',$this->categoryid);
        $aresult=$this->checkRecord('authors','author',$this->authorid);

                         
        if (($cresult == false) || ($aresult==false)){
            return false;
        }

      $query = 'INSERT INTO ' . $this->table . '
                SET
                quote =:quote,
                authorid =:authorid,
                categoryid =:categoryid';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorid', $this->authorid);
        $stmt->bindParam(':categoryid', $this->categoryid);
   
        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }
    }

    public function update(){

        $result=$this->checkRecord('quotes','quote',$this->id);
        $cresult=$this->checkRecord('categories','category',$this->categoryid);
        $aresult=$this->checkRecord('authors','author',$this->authorid);

                         
        if (($result == false) || ($cresult == false) || ($aresult==false)){
            return false;
        }
        
      $query = 'update ' . $this->table . '
                SET
                quote =:quoteinput,
                authorid =:authorid,
                categoryid =:categoryid
                where id=:id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quoteinput', $this->quoteinput);
        $stmt->bindParam(':authorid', $this->authorid);
        $stmt->bindParam(':categoryid', $this->categoryid);
        $stmt->bindParam(':id', $this->id);
   
        
       ////mysql catching 
        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }

    }


    public function checkRecord($checktable, $checkmessage, $checkid){
        $this->checktable = $checktable;
        $this->checkmessage = $checkmessage;
        $this->checkid = $checkid;

        $query = 'Select * 
                    from '. $this->checktable .'  
                    where id= ?';
     
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->checkid);

        try {
            $stmt->execute();
          } catch (Exception $e) {
            echo json_encode(array('message'=>$e));
          }

        if ($stmt->rowCount()==0){
            echo json_encode(array('message'=> $checkmessage . 'Id Not Found'));
           return false;
           }
        else{
            return true;
        }
    }

}