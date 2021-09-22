<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$sale = new Db('sales');
$items = new Db('items');
$sql = 'update sales set amount = ? where id = ?';
$stmt = $sale->dbc()->prepare($sql);
$stmt->execute([$_POST['amount'],$_POST['item_id']]);
$timestamp =date("Y-m-d H:i:s", time());

$sql = "update carts set updated_at = '$timestamp' where id = ".$_POST['page_id'];
var_dump($sql);
$stmt = $items->dbc()->prepare($sql);
$stmt->execute();
header('Location:../../View/edit_cart.php?id='.$_POST['page_id']);
return;