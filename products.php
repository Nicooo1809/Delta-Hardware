<?php
require_once("php/mysql.php");
require_once("php/functions.php");
require "templates/header.php";
// The amounts of products to show on each page
$num_products_on_each_page = 4;
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
    $_SESSION["sortsql"] = "ORDER BY " . $_GET["sortby"] . $order;
}
$type = "";
if (isset($_GET["type"])) {
    $type = "and products_types.name = '" . $_GET["type"] . "' ";
}
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM products, products_types where products.product_id = products_types.id ' . $type . $_SESSION["sortsql"] . ' LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->debugDumpParams();
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products, products_types where products.product_id = products_types.id ' . $type)->rowCount();
?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <form action="products.php?<?php print(http_build_query($_GET)); ?>" method="get">
        <select name="sortby" id="sortby">
            <option value="name">Name</option>
            <option value="price">Preis</option>
            <option value="rrp">UVP</option>
            <option value="created_at">Date</option>
        </select>
    <input type="Submit" value="Aufsteigend" id="order" name="order"></input>
    <input type="Submit" value="Absteigend" id="order" name="order"></input>
    </form>
    <p><?php print($total_products); ?> Products</p>
    <div class="products-wrapper">
    <?php print_r($products); ?>
        <?php foreach ($products as $product): ?>
            <?php print('Test'); ?>
        <a href="product.php?id=<?=$product['products.id']?>" class="product">
            <img src="imgs/<?=$product['products.img']?>" width="200" height="200" alt="<?=$product['products.name']?>">
            <span class="name"><?=$product['products.name']?></span>
            <span class="price">
                &dollar;<?=$product['products.price']?>
                <?php if ($product['products.rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['products.rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="products.php?p=<?php print($current_page-1 . '&type=' . $_GET['type']); ?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
        <a href="products.php?p=<?php print($current_page+1 . '&type=' . $_GET['type']); ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
<?php
require "templates/footer.html";
?>
