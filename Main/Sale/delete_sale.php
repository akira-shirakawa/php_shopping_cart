<?php
require_once '../../Class/Dbc.php';
$sale = new Db('sales');
if($_POST['item_id']){
    $sale->delete($_POST['item_id']);
    header('Location:../../View/index.php');
    return;
}else{
    $sale->delete($_POST['item_ide']);
    header('Location:../../view/edit_cart.php?id='.$_POST['page']);
    return;
}
