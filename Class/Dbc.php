<?php
ini_set('display_errors', 1);
require_once dirname(__FILE__).'/../env.php';

Class Db{
    protected $table_name;
    protected $pdo;
    function __construct($table_name){
        $this->table_name = $table_name;
        $this->pdo = $this->dbc();
    }
    public function dbc(){

        try{
            $host =DB_HOST;
            $user =DB_USER;
            $password = DB_PASS; 
            $dbname = DB_NAME;
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8;", $user, $password); 
            return $pdo;
    
        }catch(PDOException $e){
          
        }
        
    }
    public function getMessage(){
        $sql = "select * from ".$this->table_name;
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getSales(){
        $sql = "select * from ".$this->table_name." where cart_id is null";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC); 
        return $result;
    }
    public function show($id){
        $sql = "select * from ".$this->table_name." where id=?";
        $arr=[];
        $arr[]=$id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arr);   
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    
    }
    public function cartIdNull($id){
        $sql ="select * from ".$this->table_name." where item_id=? and cart_id is null";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result; 
    }
   public function getData($id,$column){
        $sql = "select * from ".$this->table_name." where $column =?"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;    
   }
   public function getFirstIdNew(){
        $sql = "select id from ".$this->table_name." order by id desc limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();   
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
   }
    public function create($array){
        $colum_name ='(';
        $value =[];
        $str='(';
        foreach ($array as $key=>$va){
            $colum_name = $colum_name.$key.',';
            $value[] = $va;
        }
        $colum_name = preg_replace("/.$/","",$colum_name);
        $colum_name = $colum_name.')';
        for($i=1;$i<=count($array);$i++){
            $str=$str.'?,';
        }
        $str = preg_replace("/.$/","",$str);
        $str = $str.')';
        $str = $colum_name.'values'.$str;
        $sql = "insert into $this->table_name".$str;
        var_dump($array);
        $stmt = $this->pdo->prepare($sql);
        var_dump($value);
        $result = $stmt->execute($value);
        return $result;       
    }
    public function delete($id){
        $sql = "delete from ".$this->table_name." where id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
       
    }
    public function sumSales($id){
        $sql = "SELECT cart_id ,sum(amount * price) FROM `sales` inner join carts on carts.id = sales.cart_id inner join items on items.id = sales.item_id where cart_id = $id group by cart_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
       
        return $result['sum(amount * price)'] ?? '';
    }
    public function selectCarts($get){
        $comment = $get['comment'] ?? '';
        $created_at_from = $get['created_at_from'] ?? '';
        $created_at_to = $get['created_at_to'] ?? '';
        $updated_at_from = $get['updated_at_from'] ?? '';
        $updated_at_to = $get['updated_at_to'] ?? '';
        $count_from = $get['count_from'] ?? '';
        $count_to = $get['count_to'] ?? '';
        $sum_from = $get['sum_from'] ?? '';
        $sum_to = $get['sum_to'] ?? '';

        $sql = "SELECT carts.id,carts.comment,carts.created_at,carts.updated_at,inko.sum,inko.count,inko.cart_id FROM carts left join (SELECT created_at,updated_at,comment,cart_id ,count(cart_id) as count,sum(amount * price) as sum FROM `sales` inner join carts on carts.id = sales.cart_id inner join items on items.id = sales.item_id group by cart_id,comment,created_at,updated_at) as inko on carts.id = inko.cart_id where 1 = 1";

        if($comment) $sql.=" and carts.comment like '%$comment%'";
        if($created_at_from) $sql.=" and carts.created_at >= '$created_at_from'";
        if($created_at_to) $sql.=" and carts.created_at <= '$created_at_to'";
        if($updated_at_from) $sql.=" and carts.updated_at >= '$updated_at_from'";
        if($updated_at_to) $sql.=" and carts.updated_at <= '$updated_at_to'";
        if($count_from) $sql.=" and count >= $count_from";
        if($count_to) $sql.=" and count <= $count_to";
        if($sum_from) $sql.=" and sum >= $sum_from";
        if($sum_to) $sql.=" and sum <= $sum_to ";
        
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;



    }
}
