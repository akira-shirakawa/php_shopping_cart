<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$sale = new Db('sales');
if($sale->getData($_POST['item_id'],'item_id')){
    $sql = 'update sales set amount = amount+1 where item_id = ?';
    $stmt = $sale->dbc()->prepare($sql);
    $stmt->execute([$_POST['item_id']]);
}else{
    $sale->create(['item_id'=>$_POST['item_id'],'amount'=>1]);
}


header('Location:../../View/index.php');
return;