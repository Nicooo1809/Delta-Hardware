<?php
require_once("php/functions.php");
$user = check_user();

if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if(isset($_POST['productid']) and isset($_POST['quantity']) and !empty($_POST['productid']) and !empty($_POST['quantity'])) {

            $stmt = $pdo->prepare('SELECT *, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            #$stmt = $pdo->prepare('SELECT * FROM product_list where product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($products as $product) {
                if($_POST['productid'] == $product['product_id']) {
                    if ($_POST['quantity'] + $product['quantity'] == 1) {

                    }
                }
            }
            
            $stmt = $pdo->prepare('INSERT INTO product_list (list_id, product_id, quantity) VALUES ((select id from orders where kunden_id = ? and ordered = 0 and sent = 0), ?, ?)');
            $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $_POST['productid']);
            $stmt->bindValue(3, $_POST['quantity'], PDO::PARAM_INT);
            $stmt->execute();
            #error_log(pdo_debugStrParams($stmt));
            header("location: cart.php");
            exit;
        } else {
            error('Some informations are missing!');
        }
    }
    if($_POST['action'] == 'del') {
        if(isset($_POST['listid']) and !empty($_POST['listid'])) {
            if (isset($_POST['confirm']) and !empty($_POST['confirm'])) {
                if ($_POST['confirm'] == 'yes') {
                    // User clicked the "Yes" button, delete record
                    $stmt = $pdo->prepare('DELETE FROM product_list WHERE id = ? and list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
                    $stmt->bindValue(1, $_POST['listid'], PDO::PARAM_INT);
                    $stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
                    $stmt->execute();
                    header('Location: cart.php');
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    header('Location: cart.php');
                    exit;
                }
            } else {
                require_once("templates/header.php");
                ?>
                <form action="cart.php" method="post">
                    <input type="number" value="<?=$_POST['listid']?>" name="listid" style="display: none;" required>
                    <input type="text" value="del" name="action" style="display: none;" required>
                    <button class="btn btn-outline-primary" type="submit" name="confirm" value="yes">Yes</button>
                    <button class="btn btn-outline-primary" type="submit" name="confirm" value="no">No</button>
                </form>
                <?php
                require_once("templates/footer.php");
                exit;
            }
        } else {
            error('Some informations are missing!');
        }
    }
    if($_POST['action'] == 'mod') {
        if(isset($_POST['listid']) and !empty($_POST['listid'])) {
            $stmt = $pdo->prepare('UPDATE product_list SET quantity = ? WHERE id = ? and list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $_POST['quantity'], PDO::PARAM_INT);
            $stmt->bindValue(2, $_POST['listid'], PDO::PARAM_INT);
            $stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
            $stmt->execute();
            header('Location: cart.php');
            exit;
        } else {
            error('Some informations are missing!');
        }
    }
}

// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products_types, products, product_list where product_list.product_id = products.id and products.product_type_id = products_types.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
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
require_once("templates/header.php");
?>

<div class="minheight100 products content-wrapper">
    <h1>Cart</h1>
    <p><?php print($total_products); ?> Products</p>


    <table>
        <thead>
            <tr>
                <td>Img</td>
                <td>Name</td>
                <td>Price</td>
                <td>Quantity</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><img src="product_img/<?=$product['image']?>" width="50" alt="<?=$product['name']?>"></td>
                <td><a href="product.php?id=<?=$product['product_id']?>"><?=$product['name']?></a></td>
                <td><?=$product['price']?></td>
                <td><?=$product['quantity']?></td>

                <td class="actions">
                    <form action="cart.php" method="post">
                        <input type="number" value="<?=$product['id']?>" name="listid" style="display: none;" required>
                        <input type="number" value="<?=$product['quantity']?>" min="1" max="<?=$product['maxquantity']?>" class="form-control" name="quantity" required>
                        <button type="submit" name="action" value="mod" class="fas fa-pen fa-xs"></button>
                        <button type="submit" name="action" value="del" class="fas fa-trash fa-xs"></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>




    <!--div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="product.php?id=<?=$product['product_id']?>" class="product">
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
    </div-->
</div>
<?php
include_once("templates/footer.php")
?>