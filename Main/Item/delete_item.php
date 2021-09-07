<?php
ini_set('display_errors', 1);
require_once '../../Class/Dbc.php';
$item = new Db('items');
$item->delete($_POST['id']);
header('Location:../../View/item.php');
return;