<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$sale = new Db('sales');
var_dump($_POST);
$sql = 'update sales set amount = ? where id = ?';

$stmt = $sale->dbc()->prepare($sql);
$stmt->execute([$_POST['amount'],$_POST['item_id']]);

header('Location:../../View/index.php');
return;