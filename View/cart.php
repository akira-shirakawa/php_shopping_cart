<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
session_start();
$cart = new Db('carts');
$sale = new Db('sales');
$result = $cart->getMessage();
$triger = $_GET ?? '';
$min =   -10000000;
$max =   1111111111;
$count_min = -100000;
$count_max =  10000000;
if($triger){
    $selected_result = $cart->selectCarts($_GET);
    $_SESSION['comment'] = $_GET['comment'];
    $_SESSION['created_at_from'] = $_GET['created_at_from'];
    $_SESSION['created_at_to'] = $_GET['created_at_to'];
    $_SESSION['updated_at_from'] = $_GET['updated_at_from'];
    $_SESSION['updated_at_to'] = $_GET['updated_at_to'];
    $_SESSION['count_from'] = $_GET['count_from'];
    $_SESSION['count_to'] = $_GET['count_to'];
    $_SESSION['sum_from'] = $_GET['sum_from'];
    $_SESSION['sum_to'] = $_GET['sum_to'];
    $min = $_GET['sum_from'] ?: -10000000;
    $max = $_GET['sum_to'] ?:10000202;
    $count_min = $_GET['count_from'] ?: -10000000;
    $count_max = $_GET['count_to'] ?:10000202;
}
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
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <a class="navbar-item" href="index.php">
    <i class="fas fa-home"></i></a>
    </a>
</nav>
<div class="columns">
    <div class="column"></div>
    <div class="column is-8">
        <article class="message">
            <div class="message-header">データ検索</div>
            <div class="message-body">
                <form action="" method="get">
                    <div class="columns">
                        <div class="column">
                            <p>comment</p>
                            <input type="text" name="comment" class="input" value="<?php echo $_SESSION['comment'] ?>">
                            
                            
                            <div class="columns">
                                <div class="column">
                                    <p>作成日で絞り込み　</p>
                                <input type="datetime-local" name="created_at_from">
                                <p>更新日時で絞り込み</p>
                                <input type="datetime-local" name="updated_at_from">
                                </div>
                                <div class="column">
                                    <p>to</p>
                                <input type="datetime-local" name="created_at_to">
                                    <p>to</p>
                                <input type="datetime-local" name="updated_at_to">
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            
                            <div class="columns">
                                <div class="column">
                                        <p>集計数(from)</p>
                                    <input type="number" name="count_from" class="input" value="<?php echo $_SESSION['count_from'] ?>">
                                        <p>集計結果(from)</p>
                                    <input type="number" name="sum_from" class="input" value="<?php echo $_SESSION['sum_from'] ?>">
                                </div>
                                <div class="column">
                                    <p>集計数(to)</p>
                                        <input type="number" name="count_to" class="input" value="<?php echo $_SESSION['count_to'] ?>">
                                    <p>集計結果(to)</p>
                                        <input type="number" name="sum_to" class="input" value="<?php echo $_SESSION['sum_to'] ?>">
                                        <input type="submit" class="button" value="検索">
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </form>
            </div>
        </article>
        <table class="table is-fullwidth">
                <tr><th>コメント</th><th>集計数</th><th>集計結果</th><th>作成日時</th><th>更新日時</th><th></th></tr>
                <?php foreach($selected_result ?? $result as $value) :?>
                    <?php if ($min < $sale->sumSales($value['id']) && $max > $sale->sumSales($value['id']) && $count_min <count($sale->getData($value['id'],'cart_id')) && $count_max > count($sale->getData($value['id'],'cart_id'))) :?>
                <tr>
                    <td><?php echo $value['comment']  ?></td>
                    <td><?php echo count($sale->getData($value['id'],'cart_id'))  ?></td>
                    <td><?php echo $sale->sumSales($value['id'])  ?></td>
                    <td><?php echo $value['created_at']  ?></td>
                    
                    <td><?php echo $value['updated_at']  ?></td>
                    <td><button class="<?php echo $value['id'] ?> button is-danger js-delete-target">delete</button>
                   <a href="edit_cart.php?id=<?php echo $value['id'] ?>" class="button is-info">update</a></td>
                   
                    
                </tr>
                <?php endif;?>
                <?php endforeach; ?>
                
            </table>
    </div>
    <div class="column"></div>
</div>
<form action="../Main/Cart/delete_cart.php" method="post" class="form-js-delete-target">
    <input type="hidden" name="cart_id" class="input-js-delete-target">
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="js/cart.js"></script>  
</body>
</html>