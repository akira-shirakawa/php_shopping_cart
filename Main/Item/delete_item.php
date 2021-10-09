<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$log = new Db('logs');
$item = new Db('items');
$sale = new Db('sales');
$price = (int)$item->show($_POST['id'])['price'];
$item->delete($_POST['id']);
$sql = "delete from sales where cart_id = ?";
$stmt = $sale->dbc()->prepare($sql);
$stmt->execute($_POST['id']);
$log->create(['price_old'=>$price,'statue'=>'deleted','cart_id'=>$_POST['id']]);
header('Location:../../View/item.php');
return;