<?php
require_once("php/functions.php");
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
if ($stmt->rowCount() != 1) {
    header("location: 404.php");
}
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
require("templates/header.php");
?>
<div class="container-fluid minheight100 px-3 py-3 row row-cols-1 row-cols-md-2 gx-0 product content-wrapper">
    <div class="col">
        <div class="card cbg py-2 px-2 mx-2">
            <div class="card-body px-3 py-3">
                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <?php if($images == null):?>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/image-not-found.png" class="img-fluid rounded" alt="<?=$product[0]['name']?>">
                            </div>
                        </div>
                    <?php elseif (count($images) == 1):?>
                        <div class="carousel-inner">
                            <?php foreach ($images as $image) {
                                print('<div class="carousel-item active">');
                                    print('<img src="product_img/'.$image['img'].'" class="img-fluid rounded" alt="'.$product[0]['name'].'">');
                                print('</div>');
                            } ?>
                        </div>
                    <?php elseif (count($images) != 1):?>
                        <div class="carousel-indicators">
                            <?php $i = 0; foreach ($images as $image) {
                                if ($i == 0) {
                                    print('<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Img 1"></button>');
                                }
                                else {
                                    print('<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="'.$i.'" aria-label="Img'.$i.'"></button>');
                                }
                                $i++;
                            } ?>
                        </div>
                        <div class="carousel-inner">
                            <?php $i = 1; foreach ($images as $image) {
                                if ($i == 1) {
                                    print('<div class="carousel-item active" data-bs-interval="10000">');
                                        print('<img src="product_img/'.$image['img'].'" class="img-fluid rounded" alt="'.$product[0]['name'].'">');
                                    print('</div>');
                                }
                                else {
                                    print('<div class="carousel-item" data-bs-interval="10000">');
                                        print('<img src="product_img/'.$image['img'].'" class="img-fluid rounded" alt="'.$product[0]['name'].'">');
                                    print('</div>');
                                }
                                $i++;
                            } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    <?php endif;?>              
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card cbg py-2 px-2 mx-2">
            <div class="card-body px-3 py-3">
                <div class="row">
                    <div>
                        <h1 class="ctext"><?=$product[0]['name']?></h1>
                        <span class="ctext col">Preis: <?=$product[0]['price']?>&euro;</span> 
                        <?php if ($product[0]['rrp'] > 0): ?>
                            <span class="ctext col">UVP <?=$product[0]['rrp']?>&euro;</span>
                        <?php endif; ?>
                        <?php if ($product[0]['visible'] == 0):?>
                            <h2 class="text-danger my-2">Das Produkt aktuell nicht bestellbar!</h2>
                        <?php elseif ($product[0]['quantity'] >= 20):?>
                            <h2 class="text-success my-2">Auf Lager</h2>
                        <?php elseif ($product[0]['quantity'] > 5 && $product[0]['quantity'] < 20):?>
                            <h2 class="text-warning my-2">Nur noch <?=$product[0]['quantity']?> auf Lager!</h2>
                        <?php elseif ($product[0]['quantity'] == 0):?>
                            <h2 class="text-danger my-2">Das Produkt ist ausverkauft!</h2>
                        <?php else: ?>
                            <h2 class="text-danger my-2">Nur noch <?=$product[0]['quantity']?> auf Lager!</h2>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($product[0]['visible'] == 1 && $product[0]['quantity'] != 0):?>
                <div class="row">
                    <div class="cart">
                        <form action="cart.php" method="post">
                            <div class="input-group">
                                <span class="input-group-text">Anzahl:</span>
                                <input type="number" value="<?=$product[0]['id']?>" name="productid" style="display: none;" required>
                                <input type="number" value="1" min="1" max="<?=$product[0]['quantity']?>" class="form-control" name="quantity" required>
                                <button class="btn btn-outline-primary" type="submit" name="action" value="add">Hinzufügen</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                <p class="ctext"><?=$product[0]['desc']?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
include_once("templates/footer.php")
?>
