<?php
require_once '../../Class/Dbc.php';
$sale = new Db('sales');
$sale->delete($_POST['item_id']);
header('Location:../../View/index.php');