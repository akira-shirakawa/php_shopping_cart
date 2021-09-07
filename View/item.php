<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$item = new Db('items');
$result = $item->getMessage();
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
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <a class="navbar-item" href="index.php">
    <i class="fas fa-home"></i></a>
    </a>
</nav>
<div class="columns">
    <div class="column"></div>
    <div class="column is-half">
        <p class="is-size-3 has-text-centered">商品登録</p>
        <div class="box">
            <form enctype="multipart/form-data" action="../Main/Item/create_item.php" method="post">
                <p>商品名</p>
                <input type="text" class="input" id="js-text1" name="name" required>
                <p>キャプション</p>
                <input type="text" class="input" id="js-text2" name="caption" required>
                <p>値段</p>
                <input type="number" class="input" id="js-number1" name="price" required>
                <div class="file is-boxed">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image" id="file" >
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-images"></i>
                        </span>
                        <span class="file-label">
                            画像を選択(任意)
                        </span>
                        </span>
                    </label>
                </div>
                <input type="submit" value="送信" class="button">
            </form>       
        </div>
        <p class="is-size-3 has-text-centered">商品一覧</p>
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
                    <a class="button is-success is-full-width has-text-centered" href="edit_item.php?id=<?php echo $value['id']?>">edit item</a>
                    <button class="<?php echo $value['id'] ?> button is-danger js-delete-target"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        <?php endforeach ;?>   
        </div>
    </div>
    <div class="column">
        <div class="preview">
            <p class="is-size-4 has-text-centered">プレビュー</p>
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image" id="js-image-target">
                    </figure>
                </div>
                <div class="card-content">
                    <p class="is-size-4" id="js-text1-target">商品名</p>
                    <p id="js-text2-target">こちらは商品の説明ランニなります</p>
                    <p class="has-text-centered has-text-danger" id="js-number1-target">1800</p>
                    <button class="button is-success is-full-width has-text-centered">Add to cart</button>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="../Main/Item/delete_item.php" method="post" class="form-js-delete-target">
    <input type="hidden" name="id" value="" class="input-js-delete-target">
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="js/item.js"></script>  
</body>
</html>