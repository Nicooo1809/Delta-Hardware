<?php
require_once("php/functions.php");

// Per SQL Befehl werden die neuesten Produkte aus der Datenbank ausgewählt
$stmt = $pdo->prepare('SELECT *, substring(products.desc, 1, 35) as shortdesc ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products where visible = 1 ORDER BY created_at DESC LIMIT 12');
$stmt->execute();
// Anzahl der Produkte bekommen
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
// Die aus der Datenbank gezogenen Produkte werden in ein Array returned
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


require_once("templates/header.php");
?>
<script src="/js/slider.js"></script>
<!-- Hauptteil bzw die eigentliche Website -->
<main>
    <!-- Titelbild + Text ganz oben auf der Startseite einfügen -->
    <div class="view bg">
        <div class="mask rgba-black-light align-items-center">
            <div class="container">
                <div class="d-flex flex-row minimum-vh justify-content-start align-items-center">
                    <div class="col-md-12 mt-1 text-white text-start">
                        <a href="products.php?search=RTX">
                            <h1 class="h1-reponsive text-uppercase fw-bold mb-0 pt-md-5 pt-5 index-rtx-text text-primary text-center">HERZLICH WILLKOMMEN</h1>
                            <hr class="hr-light my-3">
                            <h2 class="h2-responsive text-white fw-bold text-center">Delta-Hardware, dein Hardware Onlinehandel</h2>
                        </a>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <!-- Neuerscheinungen werden als Slider/Carousel angezeigt -->
    <!-- Die mit dem oben geschriebenen PHP-Code geholten Dateien werden ein einer Reihe angezeigt
    dabei sieht man immer nur 4 Produkte für 5 Sekunden und geht dann zu den nächsten 4.
    Es werden maximal 12 Produkte angezeigt (12 neuste) -->
    <div class="container my-3">
        <h1 class="h1-reponsive text-uppercase fw-bold pt-md-3 pt-3 index-rtx-text text-primary text-center">NEU
            ERSCHEINUNGEN</h1>
        <hr class="hr-light my-3">
        <div id="newproductcarousel"class="carousel slide text-center" data-bs-ride="carousel">
            <div class="carousel-inner py-4">
                <?php $i = 0; $first = true; foreach ($products as $product): ?>
                    <?php if ($i % 4 == 0):?>
                        <?php if ($first != true):?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif;?>
                    <?php if ($i % 4 == 0):?>
                        <?php if ($first == true):?>
                            <div class="carousel-item active" data-bs-interval="5000">
                                <div class="container">
                                    <div class="row">
                        <?php else: ?>
                            <div class="carousel-item" data-bs-interval="5000">
                                <div class="container">
                                    <div class="row">
                        <?php endif;?>
                    <?php endif;?>
                    <div class="col">
                        <div class="card cbg prodcard">
                            <!-- Bild wird aus der Datenbank gezogen, falls keins vorhanden ist wird ein Platzhalter angezeigt -->
                            <?php if (empty($product['image'])): ?>
                                <img src="images/image-not-found.png" class="card-img-top" alt="<?=$product['name']?>">
                            <?php else: ?>
                                <img src="product_img/<?=$product['image']?>" class="card-img-top" alt="<?=$product['name']?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?=$product['name']?></h5>
                                <p class="card-text"><?=$product['shortdesc']?></p>
                                <a href="product.php?id=<?=$product['id']?>" class="btn btn-primary">Mehr erfahren</a>
                            </div>
                        </div>
                    </div>
                    <?php $first = false; $i++;?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>




<?php
include_once("templates/footer.php")
?>
