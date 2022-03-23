<?php
require_once("php/functions.php");
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
if (isset($_GET["sortby"])) {
    $order = "";
    if ($_GET["order"] == "Absteigend"){
        $order = " DESC";
    }
    $sortsql = "ORDER BY products." . $_GET["sortby"] . $order;
}
$type = "";
if (isset($_GET["type"])) {
    $type = "and products.product_type_id = '" . $_GET["type"] . "' ";
}
if (isset($_GET["search"])) {
    $search = 'and lower(products.name) like lower("%' . $_GET["search"] . '%") ';
}
// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products where visible = 1 ' . $type . $search . $sortsql);
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
if ($_GET["sortby"] == 'rrp'){
    print($_GET["sortby"]);
}

require_once("templates/header.php");
?>
<script src="/js/slider.js"></script>

<main>
    <div class="view bg">
        <div class="mask rgba-black-light align-items-center">
            <div class="container">
                <div class="d-flex flex-row minimum-vh justify-content-start align-items-center">
                    <div class="col-md-12 mt-1 text-white text-start">
                        <h1 class="h1-reponsive text-uppercase fw-bold mb-0 pt-md-5 pt-5 index-rtx-text text-primary">GEFORCE RTX 30-SERIE</h1>
                        <h2 class="h2-responsive text-white fw-bold">DIE ULTIMATIVE WAHL</h2>
                        <hr class="hr-light my-3">
                        <h5 class="text-uppercase mb-4 text-white me-5">
                            Die Grafikprozessoren der GeForce RTX™ 30-Serie liefern die ultimative Leistung für Gamer und Kreative.
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container my-3">

            <!--
        <a class="carousel-control-prev position-relative" href="#newproductcarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next position-relative" href="#newproductcarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
            -->

        <div id="newproductcarousel"class="carousel slide text-center" data-bs-ride="carousel">
            <div class="carousel-inner py-4">
                <div class="carousel-item active" data-bs-interval="5000">
                    <div class="container">
                        <div class="row">

                            <div class="col">
                                <div class="card cbg">
                                    <?php if (empty($product['image'])) {
                                        print('<img src="images/image-not-found.png" class="card-img-top" alt="' . $product['name'] . '">');
                                    } else {
                                        print('<img src="product_img/' . $product['image'] . '" class="card-img-top" alt="' . $product['name'] . '">');
                                    }?>
                                    <!-- <img src="https://w.wallhaven.cc/full/y8/wallhaven-y83o9x.jpg" class="card-img-top" alt="..."> -->
                                    <div class="card-body">
                                        <h5 class="card-title"><?=$product['name']?></h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/y8/wallhaven-y83o9x.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block ">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/y8/wallhaven-y83o9x.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block ">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/y8/wallhaven-y83o9x.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="carousel-item" data-bs-interval="5000">
                    <div class="container">
                        <div class="row">

                            <div class="col">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/z8/wallhaven-z839rg.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/z8/wallhaven-z839rg.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/z8/wallhaven-z839rg.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/z8/wallhaven-z839rg.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item" data-bs-interval="5000">
                    <div class="container">
                        <div class="row">

                            <div class="col">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/dp/wallhaven-dpmdq3.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/dp/wallhaven-dpmdq3.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/dp/wallhaven-dpmdq3.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col d-none d-lg-block">
                                <div class="card cbg">
                                    <img src="https://w.wallhaven.cc/full/dp/wallhaven-dpmdq3.jpg" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">
                                            Some quick example text to build on the card title and
                                            make up the bulk of the card's content.
                                        </p>
                                        <a href="#!" class="btn btn-primary">Mehr erfahren</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>




<?php
include_once("templates/footer.php")
?>
