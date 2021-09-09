<?php
ini_set('display_errors', 1);
require_once dirname(__FILE__).'/../env.php';

Class Db{
    protected $table_name;
    function __construct($table_name){
        $this->table_name = $table_name;
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
        $stmt = $this->dbc()->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }
    public function show($id){
        $sql = "select * from ".$this->table_name." where id=?";
        $arr=[];
        $arr[]=$id;
        $stmt = $this->dbc()->prepare($sql);
        $stmt->execute($arr);   
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    
    }
   public function getData($id,$column){
        $sql = "select * from ".$this->table_name." where $column =?"; 
        $stmt = $this->dbc()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
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
        $stmt = $this->dbc()->prepare($sql);
        var_dump($value);
        $result = $stmt->execute($value);
        return $result;       
    }
    public function delete($id){
        $sql = "delete from ".$this->table_name." where id = ?";
        $stmt = $this->dbc()->prepare($sql);
        $stmt->execute([$id]);
       
    }
    
    
}
