<?php
require_once("php/mysql.php");
require_once("php/functions.php");
require "templates/header.php";
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
if (!isset($_GET["id"])) {
    header("location: products.php");
}
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM products where id = ?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, $_GET["id"], PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array

$product = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($product);
#$stmt->debugDumpParams();

$stmt = $pdo->prepare('SELECT * FROM product_images where product_id = ?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, $product[0]['id'], PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($images);
#$stmt->debugDumpParams();
?>
<div class="products content-wrapper">
    <h1><?=$product[0]['name']?></h1>
    <div class="products-wrapper">
        <div class="product">
            <?php foreach ($images as $image) {
                print('<img src="product_img/'.$image['img'].'" width="500" alt="'.$product[0]['name'].'">');
            } ?>
            <span class="price">
                &dollar;<?=$product[0]['price']?>
                <?php if ($product[0]['rrp'] > 0): ?>
                <span class="rrp">UVP &euro;<?=$product[0]['rrp']?></span>
                <?php endif; ?>
                <span class="amount">Anzahl: <?=$product[0]['quantity']?></span>
            </span>
            <span class="desc"><?=$product[0]['desc']?></span>
        </div>
    </div>
    <div class="buttons">
        <div class="cart">
            <span class="addtocart">Zum Warenkorb Hinzufügen</span>
        </div>
    </div>
</div>
<?php
require "templates/footer.html";
?>
