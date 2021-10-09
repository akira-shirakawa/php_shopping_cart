<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
if($_POST['comment']){
    $cart = new Db('carts');
    $sql = 'update carts set comment = ? where id = ?';
    $stmt = $cart->dbc()->prepare($sql);
    $stmt->execute([$_POST['comment'],$_POST['cart_id']]);
    header('Location:../../View/edit_cart.php?id='.$_POST['cart_id']);
    return;
}else{
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


    $cart = new Db('carts');
    $sql = "select sum(price*amount),sum(amount) from sales where cart_id=?";
    $stmt = $sale->dbc()->prepare($sql);
    $stmt->execute([$_POST['page_id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $sum = (int)$result['sum(price*amount)'];
    $count = (int)$result['sum(amount)'];
    var_dump([$sum,$count]);
    $sql = "update carts set sum =?,count=? where id=?";
    $stmt = $cart->dbc()->prepare($sql);
    $stmt->execute([$sum,$count,$_POST['page_id']]);
}

header('Location:../../View/edit_cart.php?id='.$_POST['page_id']);
return;