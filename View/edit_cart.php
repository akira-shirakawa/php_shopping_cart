<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$id = $_GET['id'];
$item = new Db('items');
$sale= new Db('sales');
$cart = new Db('carts');
$result = $item->getMessage();
$sale_result = $sale->getData($id,'cart_id');
$cart_result=$cart->show($id);
$sum =0 ;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" defer ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css" />
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head> 
<body>
<div class="modal" id="delete-modal">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="notification has-text-centered">
        本当に削除しますか？</br>
        <button id="yes" class="button is-danger">はい</button>
        <button id="no" class="button" >いいえ</button>
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>
<div class="modal" id="edit-modal">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="box">

        <form action="../Main/Cart/edit_cart.php" method="post" id="js-edit-amount">
            <p class="is-size-3">個数を変更</p>
            <input type="number" value="" class="input js-sale-edit-target" name="amount" required>
            <input type="hidden" name="item_id" class="js-item_id" value="">
            <input type="hidden" name="page_id" value="<?php echo $id ?>">
            <input type="submit" value="送信" class="button">
        </form>
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>
<div class="modal" id="cart-modal">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="box">

        <form action="../Main/Cart/create_cart.php" method="post">
            <p class="is-size-3">カートに登録する前にコメントを入れてください</p>
            <input type="text" name="comment" class="input" required>
          
            <input type="submit" value="送信" class="button">
        </form>
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <a class="navbar-item" href="index.php">
    <i class="fas fa-home"></i></a>
    </a>
    <a class="navbar-item" href="cart.php">
       カート一覧・編集・削除
    </a>
</nav>
<div class="columns">
    <div class="column"></div>
    <div class="column is-half">
    <p class="is-size-3 has-text-centered">カート編集</p>
        <div class="wrapper">           
            <?php foreach ($result as $value) :?>
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img src="../Images/<?php echo($value['file_name']) ?>" alt="Placeholder image">
                        </figure>
                    </div>
                    <div class="card-content">
                        <p class="is-size-4"><?php echo $value['name'] ?></p>
                        <p><?php echo $value['caption'] ?></p>
                        <p class="has-text-centered has-text-danger"><?php echo $value['price'] ?>円</p>
                        <button class="<?php echo $value['id'] ?> button is-success is-fullwidth has-text-centered js-add-target">add to cart<i class="fas fa-shopping-cart"></i></button>
                        
                    </div>
                </div>
            <?php endforeach ;?>   
        </div>
        <table class="table is-fullwidth">
            <tr><th>商品名</th><th>数量</th><th>単価</th><th>合計</th><th></th></tr>
            <?php foreach($sale_result as $value) :?>
            <tr>
                <td><?php echo $item->show($value['item_id'])['name']  ?></td>
                <td><?php echo $value['amount']  ?></td>
                <td><?php echo $item->show($value['item_id'])['price'] ?></td>
                <td><?php echo $value['amount']*$item->show($value['item_id'])['price'] ?></td>
                <td><button class="<?php echo $value['id'] ?> button is-success js-edit-target">編集</button><button class="<?php echo $value['id'] ?> button is-danger js-delete-target">消去</button></td>
                <?php $sum+=$value['amount']*$item->show($value['item_id'])['price'] ?>
            </tr>
            <?php endforeach; ?>
            <tr><td></td><td></td><td>カート合計</td><td><?php echo '¥'.number_format($sum) ?></td><td></td></tr>
            <form action="../Main/Cart/edit_cart.php" method="post">
            <tr><td></td><td></td><td>コメント</td> <td><input type="submit" class="button" value="送信" required></td>
             <td>
                 
                     <input type="text" name="comment" class="input" value="<?php echo $cart_result['comment'] ?>">
                    <input type="hidden" name ="cart_id" value="<?php echo $id ?>">
                
            </td></tr>
            </form>
           
           
        </table>
    </div>
    <div class="column"></div>
    <form action="../Main/Sale/create_sale.php" method="post" id="item">
        <input type="hidden" name="item_id" value="" id="item_id">
        <input type="hidden" name="page_id" value="<?php echo $id ?>">
    </form>
    <form action="../Main/Sale/delete_sale.php" method="post" class="form-js-delete-target">
        <input type="hidden" name="item_ide" class="input-js-delete-target" value="" >
        <input type="hidden" name="page" value="<?php echo $id ?>">
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>  
</body>
</html>