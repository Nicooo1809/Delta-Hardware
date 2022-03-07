<?php
require_once("php/mysql.php");
require_once("php/functions.php");
require_once "templates/header.php";

$user = check_user();

if(isset($_GET['action'])) {
    if($_GET['action'] = 'add') {
        if(isset($_GET['productid']) and isset($_GET['quantity']) and empty($_GET['productid']) and empty($_GET['quantity'])) {
            $stmt = $pdo->prepare('INSERT INTO product_list (list_id, product_id, quantity) VALUES ((select id from orders where kunden_id = ? and ordered = 0 and delivered = 0), ?, ?)');
            $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $_GET['productid']);
            $stmt->bindValue(3, $_GET['quantity'], PDO::PARAM_INT);
            $stmt->execute();
            if(!$result) {
                $error_msg = 'Fehler beim Abspeichern!';
            }
        } else {
            $error_msg = 'Some informations are missing!';
        }
        if(isset($error_msg)){
            error($error_msg);
        }
    }
}



// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT *,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products_types, products, product_list where product_list.product_id = products.id and products.product_type_id = products_types.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? )) and product_list.list_id = (select id from orders where kunden_id = ? )');
#$stmt = $pdo->prepare('SELECT *,(SELECT quantity From product_list WHERE product_list.product_id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? )) LIMIT 1) AS quantity,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image FROM products_types, products where products.product_type_id = products_types.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? ))');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
?>

<div class="products content-wrapper">
    <h1>Cart</h1>
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
            <span class="quantity"><?=$product['quantity']?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
include_once("templates/footer.php")
?>
