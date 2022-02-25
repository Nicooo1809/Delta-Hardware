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
$stmt->bindValue(1, '%' . $_GET["search"] . '%', PDO::PARAM_INT);
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <form action="products.php" method="get">
        <select name="sortby">
            <option value="name">Name</option>
            <option value="price">Preis</option>
            <option value="rrp">UVP</option>
            <option value="created_at">Date</option>
        </select>
        <?php foreach (array_keys($_GET) as $getindex) {
            if ($getindex != "order" && $getindex != "sortby") {
                print('<input type=text name="' . $getindex . '" value="' . $_GET[$getindex] . '" hidden>');
        } } ?>
        <input type="Submit" value="Aufsteigend" name="order"></input>
        <input type="Submit" value="Absteigend" name="order"></input>
    </form>
    <p><?php print($total_products); ?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="product.php?id=<?=$product['id']?>" class="product">
            <img src="product_img/<?=$product['image']?>" width="200" alt="<?=$product['name']?>">
            <span class="name"><?=$product['name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
require "templates/footer.html";
?>
