<?php
require_once '../../Class/Dbc.php';
session_start();
$cart = new Db('carts');
$sale = new Db('sales');
$log = new Db('logs');
$cart->create(['comment'=>$_POST['comment']]);

//original price登録
$sql = "select sum(price*amount),sum(amount) from sales where cart_id is null";
$stmt = $sale->dbc()->prepare($sql);
$stmt->execute(); 
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$sum = (int)$result['sum(price*amount)'];
$count = (int)$result['sum(amount)'];
$first = $cart->getFirstIdNew()['id'];
$sql = "update carts set sum=$sum , count=$count where id=$first";
$stmt = $cart->dbc()->prepare($sql);
$stmt->execute();
$sql = "update sales set cart_id =".$first." where cart_id is null";
$stmt = $sale->dbc()->prepare($sql);
$stmt->execute();


$_SESSION['is_success'] = 'Resistered successfully !';
header('Location:../../View/index.php');