<?php
if (!isset($_GET["search"])) {
    header("location: products.php");
}

require_once("php/mysql.php");
require_once("php/functions.php");
require "templates/header.php";

if (!isset($_SESSION["sortsql"])) {
    $_SESSION["sortsql"] = "";
}
if (isset($_GET["sortby"])) {
    $order = "";
    if ($_GET["order"] == "Absteigend"){
        $order = " DESC";
    }
    $_SESSION["sortsql"] = "ORDER BY products." . $_GET["sortby"] . $order;
}

// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products_types, products where products.product_type_id = products_types.id and lower(name) like lower(?) ' . $type . $_SESSION["sortsql"]);
$stmt->bindValue(1, '%' . $_GET["search"] . '%');
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
?>

<div class="container-fluid px-3 py-3 products content-wrapper">
    <h1 class="text-white">Products</h1>
    <form action="products.php" method="get" class="mx-0">
        <select class="form-select me-2" name="sortby">
            <option value="name" <?php if ($_GET["sortby"] == 'name') { print('selected="selected"');} ?>>Name</option>
            <option value="price" <?php if ($_GET["sortby"] == 'price') { print('selected="selected"');} ?>>Preis</option>
            <option value="rrp" <?php if ($_GET["sortby"] == 'rrp') { print('selected="selected"');} ?>>UVP</option>
            <option value="created_at" <?php if ($_GET["sortby"] == 'created_at') { print('selected="selected"');} ?>>Date</option>
        </select>
        <?php foreach (array_keys($_GET) as $getindex) {
            if ($getindex != "order" && $getindex != "sortby") {
                print('<input type=text name="' . $getindex . '" value="' . $_GET[$getindex] . '" hidden>');
        } } ?>
        <input class="btn btn-outline-primary my-2 me-2" type="Submit" value="Aufsteigend" name="order"></input>
        <input class="btn btn-outline-primary my-2 me-2" type="Submit" value="Absteigend" name="order"></input>
    </form>
    <p class="text-white"><?php print($total_products); ?> Products</p>
    <div class="products-wrapper row row-cols-1 row-cols-md-5 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card prodcard bg-dark">
                    <a href="product.php?id=<?=$product['id']?>" class="product stretched-link">
                        <div class="card-body text-white">
                            <?php if (empty($product['image'])) {
                                print('<img src="product_img/image-not-found.png" class="card-img-top rounded mb-3" alt="' . $product['name'] . '">');
                            } else {
                                print('<img src="images/' . $product['image'] . '" class="card-img-top rounded mb-3" alt="' . $product['name'] . '">');
                            }?>
                            <h4 class="card-title name"><?=$product['name']?></h4>
                            <p class="card-text price">Preis: 
                                &euro;<?=$product['price']?>
                                <?php if ($product['rrp'] > 0): ?>
                                <span class="rrp"><br>UVP: &euro;<?=$product['rrp']?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
include_once("templates/footer.php")
?>
