<?php
class Quote{
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $authorid;
    public $categoryid;
    public $author;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }


 //  select q.id, q.quote, a.author, c.category 
//  from quotes q
//   left join authors a on q.authorId=a.id
//   left join categories c on q.categoryId=c.id
//   where q.authorId = '1' and q.categoryId = '4'

    public function read() {
        //Create query
        if ((empty($this->authorid)==false) && (empty($this->categoryid)==false)){
            $query = 'SELECT 
            q.id, q.quote, a.author, c.category 
            FROM quotes q
            left join authors a on q.authorId=a.id
            left join categories c on q.categoryId=c.id
            where q.authorid= ? and q.categoryid = ? ';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->authorid);
            $stmt->bindParam(2, $this->categoryid);
        }elseif(empty($this->authorid)==false){
            $query = 'SELECT 
            q.id, q.quote, a.author, c.category 
            FROM quotes q
            left join authors a on q.authorId=a.id
            left join categories c on q.categoryId=c.id
            where q.authorid= ?';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->authorid);
        }elseif(empty($this->categoryid)==false){
            $query = 'SELECT 
            q.id, q.quote, a.author, c.category 
            FROM quotes q
            left join authors a on q.authorId=a.id
            left join categories c on q.categoryId=c.id
            where q.categoryid= ?';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->categoryid);
        }else{
            $query = 'SELECT 
            q.id, q.quote, a.author, c.category 
            FROM quotes q
            left join authors a on q.authorId=a.id
            left join categories c on q.categoryId=c.id';
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
            q.id, q.quote, a.author, c.category 
            FROM quotes q
            left join authors a on q.authorId=a.id
            left join categories c on q.categoryId=c.id
            where q.id= ? ';

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
        $this->author = $row['author'];
        $this->category = $row['category'];
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

    public function delete(){

       $result=$this->checkRecord('quotes','quote',$this->id);

        
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