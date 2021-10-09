<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$item = new Db('items');
$file = $_FILES['image'];
$log = new Db('logs');
if($file['tmp_name']){
    $file_name = $file['name'];
    $tmp_name = $file['tmp_name'];
    $new_file_name = date('YmdHis').$file_name;
    move_uploaded_file($tmp_name,'../../Images/'.$new_file_name);
    $sql = 'update items set name=?, caption=?, file_name=?, price=? where id=?';
    $stmt=$item->dbc()->prepare($sql);
    $stmt->execute([$_POST['name'],$_POST['caption'],$new_file_name,$_POST['price'],$_POST['id']]);
    
    $log->create(['price'=>$_POST['price'],'price_old'=>$_POST['price_old'],'statue'=>'updated','cart_id'=>$_POST['id']]);
    
}else{
    $sql = 'update items set name=?, caption=?, price=? where id=?';
    $stmt=$item->dbc()->prepare($sql);
    $stmt->execute([$_POST['name'],$_POST['caption'],$_POST['price'],$_POST['id']]);


    $log->create(['price'=>$_POST['price'],'price_old'=>$_POST['price_old'],'statue'=>'updated','cart_id'=>$_POST['id']]);
}
header('Location:../../View/item.php');
return;