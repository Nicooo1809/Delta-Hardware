<?php
require_once("php/functions.php");
$user = check_user();

if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if(isset($_POST['productid']) and isset($_POST['quantity']) and !empty($_POST['productid']) and !empty($_POST['quantity'])) {

            $stmt = $pdo->prepare('SELECT *, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and product_id = ? and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $_POST['productid'], PDO::PARAM_INT);
            $stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
            #error_log(print_r($product, true));

            if (isset($product[0])) {
                if ($_POST['quantity'] + $product[0]['quantity'] > $product[0]['maxquantity']) {
                    $quantity = $product[0]['maxquantity'];
                } else {
                    $quantity = $_POST['quantity'] + $product[0]['quantity'];
                }
                if ($quantity < 1) {
                    $quantity = 1;
                }
                $stmt = $pdo->prepare('UPDATE product_list SET quantity = ? WHERE id = ?');
                $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
                $stmt->bindValue(2, $product[0]['id'], PDO::PARAM_INT);
                $stmt->execute();
                header("location: cart.php");
                exit;
            } else {
                $stmt = $pdo->prepare('SELECT * FROM products where products.id = ?');
                $stmt->bindValue(1, $_POST['productid'], PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
                #print_r($product);
                if ($_POST['quantity'] > $product[0]['quantity']) {
                    $quantity = $product[0]['quantity'];
                } else {
                    $quantity = $_POST['quantity'];
                }
                if ($quantity < 1) {
                    $quantity = 1;
                }
                $stmt = $pdo->prepare('INSERT INTO product_list (list_id, product_id, quantity) VALUES ((select id from orders where kunden_id = ? and ordered = 0 and sent = 0), ?, ?)');
                $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $_POST['productid']);
                $stmt->bindValue(3, $quantity, PDO::PARAM_INT);
                $stmt->execute();
                header("location: cart.php");
                exit;
            }
            
            
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
            $stmt = $pdo->prepare('select *, products.quantity as maxquantity from products, product_list where products.id = product_list.product_id and product_list.id = ?');
            $stmt->bindValue(1, $_POST['listid'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($_POST['quantity'] > $product[0]['maxquantity']) {
                $quantity = $product[0]['maxquantity'];
            } else {
                $quantity = $_POST['quantity'];
            }
            if ($quantity < 1) {
                $quantity = 1;
            }
            $stmt = $pdo->prepare('UPDATE product_list SET quantity = ? WHERE id = ? and list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
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
$summprice = 0;
foreach ($products as $product) {
    $summprice = $summprice + ($product['price'] * $product['quantity']);
}
?>

<div class="container minheight100 products content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 bg-dark rounded">
            <h1>Warenkorb</h1>
            <p><?php print($total_products); ?> Produkt(e)</p>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <div class="bg-black rounded">
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Produkt</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase">Preis</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase">Menge</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase"></div>
                                </th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; foreach ($products as $product): ?>
                            <tr>
                                <th scope="row" class="border-0">
                                    <div class="p-2">
                                        <?php if (empty($product['image'])) {
                                            print('<img src="images/image-not-found.png" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                        } else {
                                            print('<img src="product_img/' . $product['image'] . '" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                        }?>
                                        <div class="ml-3 d-inline-block align-middle">
                                            <h5 class="mb-0"> 
                                                <a href="product.php?id=<?=$product['product_id']?>" class="text-white d-inline-block align-middle"><?=$product['name']?></a>
                                            </h5>
                                        </div>
                                    </div>
                                </th>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$product['price']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$product['quantity']?></strong>
                                </td>
                                <td class="border-0 align-middle actions">
                                    <form action="cart.php me-2" method="post" class="row">
                                        <div class="col px-3 input-group">
                                            <input type="number" value="<?=$product['id']?>" name="listid" style="display: none;" required>
                                            <input class="form-control" type="number" value="<?=$product['quantity']?>" min="1" max="<?=$product['maxquantity']?>" class="form-control form-control-sm" name="quantity" required>
                                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Speichern</button>
                                        </div>
                                        <div class="col-3 px-3">
                                            <input type="number" value="<?=$product['id']?>" name="listid" style="display: none;" required>
                                            <button type="submit" name="action" value="del" class="btn btn-outline-primary">Löschen</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>         
            <p class="">Summe: <?=$summprice?></p>
        </div>
    </div>
</div> 

<?php
include_once("templates/footer.php")
?>