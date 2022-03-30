<?php
require_once("php/functions.php");

// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products where visible = 1 ORDER BY created_at DESC LIMIT 12');
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


require_once("templates/header.php");
?>
<script src="/js/slider.js"></script>

<main>
    <div class="view bg">
        <div class="mask rgba-black-light align-items-center">
            <div class="container">
                <div class="d-flex flex-row minimum-vh justify-content-start align-items-center">
                    <div class="col-md-12 mt-1 text-white text-start">
                        <a href="products.php?search=RTX">
                            <h1 class="h1-reponsive text-uppercase fw-bold mb-0 pt-md-5 pt-5 index-rtx-text text-primary">GEFORCE RTX 30-SERIE</h1>
                            <h2 class="h2-responsive text-white fw-bold">DIE ULTIMATIVE WAHL</h2>
                            <hr class="hr-light my-3">
                            <h5 class="text-uppercase mb-4 text-white me-5">
                                Die Grafikprozessoren der GeForce RTX™ 30-Serie liefern die ultimative Leistung für Gamer und Kreative.
                            </h5>
                        </a>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    
    <div class="container my-3">
        <div id="newproductcarousel"class="carousel slide text-center" data-bs-ride="carousel">
            <div class="carousel-inner py-4">
                <?php $i = 0; foreach ($products as $product): ?>
                    <?php if ($i % 4 == 0 && $i != 0):?>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="5000">
                            <div class="container">
                                <div class="row">
                    <?php endif;?>
                    <?php if ($i == 0): ?>
                        <div class="carousel-item active" data-bs-interval="5000">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="card cbg prodcard">
                                            <?php if (empty($product['image'])) {
                                                print('<img src="images/image-not-found.png" class="card-img-top" alt="' . $product['name'] . '">');
                                            } else {
                                                print('<img src="product_img/' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">');
                                            }?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?=$product['name']?></h5>
                                                <p class="card-text"><?=$product['desc']?></p>
                                                <a href="product.php?id=<?=$product['id']?>" class="btn btn-primary">Mehr erfahren</a>
                                            </div>
                                        </div>
                                    </div>
                    <?php else: ?>
                        <div class="col<?php if ($i % 4 != 0) {print(' d-none d-lg-block');} ?>">
                            <div class="card cbg prodcard">
                                <?php if (empty($product['image'])) {
                                    print('<img src="images/image-not-found.png" class="card-img-top" alt="' . $product['name'] . '">');
                                } else {
                                    print('<img src="product_img/' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">');
                                }?>
                                <div class="card-body">
                                    <h5 class="card-title"><?=$product['name']?></h5>
                                    <p class="card-text"><?=$product['desc']?></p>
                                    <a href="product.php?id=<?=$product['id']?>" class="btn btn-primary">Mehr erfahren</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; $i++;?>
                <?php endforeach; ?>                            
            </div>
        </div>
    </div>
</main>




<?php
include_once("templates/footer.php")
?>
