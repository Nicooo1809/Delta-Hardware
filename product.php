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
<div class="container-fluid products content-wrapper">
    <h1 class="text-white"><?=$product[0]['name']?></h1>
    <div class="row">
        <div class="col">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $i = 1; foreach ($images as $image) {
                        if ($i == 1) {
                            print('<div class="carousel-item active">');
                            print('<img src="product_img/'.$image['img'].'" class="img-fluid" alt="'.$product[0]['name'].'">');
                            print('</div>');
                        }
                        else {
                            print('<div class="carousel-item">');
                            print('<img src="product_img/'.$image['img'].'" class="d-block w-45" alt="'.$product[0]['name'].'">');
                            print('</div>');
                        }
                        $i++;
                    } 
                    if (!isset($image)) {
                        print('<div class="carousel-item active">');
                        print('<img src="images/image-not-found.png" class="d-block w-45" alt="'.$product[0]['name'].'">');
                        print('</div>');
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col">
            <div class="products-wrapper">
                <div class="product">
                    <span class="price">
                        &euro;<?=$product[0]['price']?>
                        <?php if ($product[0]['rrp'] > 0): ?>
                        <span class="rrp">UVP &euro;<?=$product[0]['rrp']?></span>
                        <?php endif; ?>
                        <?php if ($product[0]['quantity'] <= 5): ?>
                            <i class="fa-solid fa-exclamation"></i><span class="amount"> Nur noch <?=$product[0]['quantity']?> auf Lager, jetzt bestellen</span>
                        <?php endif; ?>
                    </span>
                    <span class="desc"><?=$product[0]['desc']?></span>
                </div>
            </div>
            <div class="buttons">
                <div class="cart">
                    <form action="cart.php" method="post">
                        <label for="inputAmount">Anzahl:</label>
                        <input type="number" value="<?=$product[0]['id']?>" name="productid" style="display: none;" required>
                        <input type="number" value="1" size="40" maxlength="80" min=1 max="<?=$product[0]['quantity']?>" name="quantity" required>
                        <button type="submit" name="action" value="add" class="btn btn-outline-primary">Zum Warenkorb Hinzufügen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("templates/footer.php")
?>
