<?php
require_once("php/mysql.php");
require_once("php/functions.php");
require "templates/header.php";
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
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
$type = "";
if (isset($_GET["type"])) {
    $type = "and products_types.type = '" . $_GET["type"] . "' ";
}
// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products_types, products where products.product_type_id = products_types.id ' . $type . $_SESSION["sortsql"]);
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
?>

<div class="container-fluid products content-wrapper">
    <h1>Products</h1>
    <form action="products.php" method="get">
        <select class="form-select py-3" name="sortby">
            <option value="name">Name</option>
            <option value="price">Preis</option>
            <option value="rrp">UVP</option>
            <option value="created_at">Date</option>
        </select>
        <?php foreach (array_keys($_GET) as $getindex) {
            if ($getindex != "order" && $getindex != "sortby") {
                print('<input type=text name="' . $getindex . '" value="' . $_GET[$getindex] . '" hidden>');
        } } ?>
        <input class="btn btn-outline-primary" type="Submit" value="Aufsteigend" name="order"></input>
        <input class="btn btn-outline-primary" type="Submit" value="Absteigend" name="order"></input>
    </form>
    <p><?php print($total_products); ?> Products</p>
    <div class="products-wrapper row">
        <?php foreach ($products as $product): ?>
            <div class="card px-3 py-3 mx-2 my-2 bg-dark" style="width: 20rem;">
                <a href="product.php?id=<?=$product['id']?>" class="product stretched-link stretched-link">
                    <img src="product_img/<?=$product['image']?>" class="rounded" style="width: 200px;" alt="<?=$product['name']?>">
                    <span class="name"><br><?=$product['name']?></span>
                    <span class="price"><br>Preis: 
                        &euro;<?=$product['price']?>
                        <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp"><br>UVP: &euro;<?=$product['rrp']?></span>
                        <?php endif; ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
include_once("templates/footer.php")
?>
