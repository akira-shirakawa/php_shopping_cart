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
    $item->create(['name'=>$_POST['name'],'caption'=>$_POST['caption'],'file_name'=>$new_file_name,'file_path'=>$_POST['file_path'],'price'=>$_POST['price']]);
   
    $new_item_data = (int)$item->getFirstIdNew()['id'];
    $log->create(['price'=>$_POST['price'],'statue'=>'created','cart_id'=>$new_item_data]);
}else{
    $new_file_name ='none_image32310901.png';
    $item->create(['name'=>$_POST['name'],'caption'=>$_POST['caption'],'file_name'=>$new_file_name,'price'=>$_POST['price']]);
    $new_item_data = (int)$item->getFirstIdNew()['id'];
    $log->create(['price'=>$_POST['price'],'statue'=>'created','cart_id'=>$new_item_data]);
}
header('Location:../../View/item.php');
return;