<?php
require_once '../../Class/Dbc.php';

$cart = new Db('carts');
$cart->delete($_POST['cart_id']);

header('Location:../../View/cart.php');