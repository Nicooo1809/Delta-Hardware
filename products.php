<?php
require_once("php/functions.php");
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$type = "";
$search = "";
$type = "";
$sortsql = "";

if (isset($_GET["sortby"])) {
    $order = "";
    if ($_GET["order"] == "Absteigend"){
        $order = " DESC";
    }
    $sortsql = "ORDER BY products." . $_GET["sortby"] . $order;
}

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
require_once("templates/header.php");
?>

<div class="container-fluid minheight100 py-3 products content-wrapper">
    <h1 class="ctext my-2">Produkte</h1>
    <form action="products.php" method="get" class="my-2">
        <div class="input-group">
            <select class="form-select" name="sortby">
                <option class="text-dark" value="name" <?php if (isset($_GET["sortby"]) and $_GET["sortby"] == 'name') { print('selected="selected"');} ?>>Name</option>
                <option class="text-dark" value="price" <?php if (isset($_GET["sortby"]) and $_GET["sortby"] == 'price') { print('selected="selected"');} ?>>Preis</option>
                <option class="text-dark" value="rrp" <?php if (isset($_GET["sortby"]) and $_GET["sortby"] == 'rrp') { print('selected="selected"');} ?>>UVP</option>
                <option class="text-dark" value="created_at" <?php if (isset($_GET["sortby"]) and $_GET["sortby"] == 'created_at') { print('selected="selected"');} ?>>Date</option>
            </select>
            <?php foreach (array_keys($_GET) as $getindex) {
                if ($getindex != "order" && $getindex != "sortby") {
                    print('<input type=text name="' . $getindex . '" value="' . $_GET[$getindex] . '" hidden>');
            } } ?>
            <input class="btn btn-outline-primary" type="Submit" value="Aufsteigend" name="order"></input>
            <input class="btn btn-outline-primary" type="Submit" value="Absteigend" name="order"></input>
        </div>
    </form>
    <p class="my-2"><?php print($total_products); ?> Produkte</p>
    <div class="products-wrapper row row-cols-1 row-cols-md-4 g-4">
        <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card prodcard cbg">
                        <a href="product.php?id=<?=$product['id']?>" class="product stretched-link">
                            <div class="card-body">
                                <?php if (empty($product['image'])) {
                                    print('<img src="images/image-not-found.png" class="card-img-top rounded mb-3" alt="' . $product['name'] . '">');
                                } else {
                                    print('<img src="product_img/' . $product['image'] . '" class="card-img-top rounded mb-3" alt="' . $product['name'] . '">');
                                }?>
                                <h4 class="card-title name"><?=$product['name']?></h4>
                                <p class="card-text ctext price">Preis: 
                                    <?=$product['price']?>&euro;
                                    <?php if ($product['rrp'] > 0): ?>
                                    <span class="rrp ctext"><br>UVP: <?=$product['rrp']?> &euro;</span>
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
