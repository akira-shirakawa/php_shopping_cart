<?php
require_once '../../Class/Dbc.php';
$cart = new Db('carts');
$sale = new Db('sales');
$cart->create(['comment'=>$_POST['comment']]);
$first = $cart->getFirstIdNew()['id'];

$sql = "update sales set cart_id =".$first." where cart_id is null";
$stmt = $sale->dbc()->prepare($sql);
$stmt->execute();

header('Location:../../View/index.php');