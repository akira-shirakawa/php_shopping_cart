<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$sale = new Db('sales');
$item = new Db('items');


if($_POST['page_id'] ?? false){
    $sql = "select * from sales where item_id = ".$_POST['item_id']." and cart_id = ".$_POST['page_id'];
    $stmt = $sale->dbc()->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        $sql = 'update sales set amount = amount+1 where item_id = ? and cart_id = ?';
        $stmt = $sale->dbc()->prepare($sql);
        $stmt->execute([$_POST['item_id'],$_POST['page_id']]);
    }else{
        $sale->create(['item_id'=>$_POST['item_id'],'amount'=>1,'cart_id'=>$_POST['page_id']]);
        $timestamp =date("Y-m-d H:i:s", time());

        $sql = "update carts set updated_at = '$timestamp' where id = ".$_POST['page_id'];       
        $stmt = $sale->dbc()->prepare($sql);
        $stmt->execute();
    }
    
    header('Location:../../View/edit_cart.php?id='.$_POST['page_id']);
    return;
}
if($sale->getData($_POST['item_id'],'item_id')){
    if($sale->cartIdNull($_POST['item_id'])){
        $sql = 'update sales set amount = amount+1 where item_id = ?';
        $stmt = $sale->dbc()->prepare($sql);
        $stmt->execute([$_POST['item_id']]);
    }else{ 
        $item = $item->show($_POST['item_id'])['price'];     
        $sale->create(['item_id'=>$_POST['item_id'],'amount'=>1]);
    }
   
}else{
    $item = $item->show($_POST['item_id'])['price'];
    $sale->create(['item_id'=>$_POST['item_id'],'amount'=>1]);
}



header('Location:../../View/index.php');
return;