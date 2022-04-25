<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if(isset($_POST['productid']) and isset($_POST['quantity']) and !empty($_POST['productid']) and !empty($_POST['quantity'])) {

            $stmt = $pdo->prepare('SELECT *, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and product_id = ? and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $_POST['productid'], PDO::PARAM_INT);
            $stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                $result = $stmt->execute();
                if (!$result) {
                    error('Database error', pdo_debugStrParams($stmt));
                }                
                echo("<script>location.href='cart.php'</script>");
                exit;
            } else {
                $stmt = $pdo->prepare('SELECT * FROM products where products.id = ?');
                $stmt->bindValue(1, $_POST['productid'], PDO::PARAM_INT);
                $result = $stmt->execute();
                if (!$result) {
                    error('Database error', pdo_debugStrParams($stmt));
                }                
                $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                $result = $stmt->execute();
                if (!$result) {
                    error('Database error', pdo_debugStrParams($stmt));
                }                
                echo("<script>location.href='cart.php'</script>");
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
                    $result = $stmt->execute();
                    if (!$result) {
                        error('Database error', pdo_debugStrParams($stmt));
                    }                    
                    echo("<script>location.href='cart.php'</script>");
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    echo("<script>location.href='cart.php'</script>");
                    exit;
                }
            } else {
                require_once("templates/header.php");
                ?>
                    <div class="container-fluid">
                        <div class="row no-gutter">
                            <div class="minheight100 col py-4 px-3">
                                <div class="card cbg text-center mx-auto" style="width: 75%;">
                                    <div class="card-body">
                                        <h1 class="card-title mb-2 text-center">Wirklich Löschen?</h1>
                                        <p class="text-center">
                                            <div>
                                            <form action="cart.php" method="post">
                                                <input type="number" value="<?=$_POST['listid']?>" name="listid" style="display: none;" required>
                                                <input type="text" value="del" name="action" style="display: none;" required>
                                                <button class="btn btn-outline-primary mx-2" type="submit" name="confirm" value="yes">Ja</button>
                                                <a href="cart.php"><button class="btn btn-outline-primary mx-2" type="button">Nein</button></a>
                                            </form>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }            
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
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }            
            echo("<script>location.href='cart.php'</script>");
            exit;
        } else {
            error('Some informations are missing!');
        }
    }
}

// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products_types, products, product_list where product_list.product_id = products.id and products.product_type_id = products_types.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$summprice = 0;
foreach ($products as $product) {
    $summprice = $summprice + ($product['price'] * $product['quantity']);
}
?>
<?php if (!isMobile()): ?>
    <div class="container minheight100 products content-wrapper py-3 px-3">
        <div class="row">
            <div class="py-3 px-3 cbg ctext rounded">
                <h1>Warenkorb</h1>
                <p><?php print($total_products); ?> Produkt<?php if ($total_products > 1) { print('e'); } ?> im Warenkorb</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <div class="ctext rounded">
                                    <th scope="col" class="border-0">
                                        <div class="p-2 px-3 text-uppercase ctext">Produkt</div>
                                    </th>
                                    <th scope="col" class="border-0 text-center">
                                        <div class="p-2 px-3 text-uppercase ctext">Preis</div>
                                    </th>
                                    <th scope="col" class="border-0 text-center">
                                        <div class="p-2 px-3 text-uppercase ctext">Menge</div>
                                    </th>
                                    <th scope="col" class="border-0">
                                        <div class="p-2 px-3 text-uppercase"></div>
                                    </th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <th scope="row" class="border-0">
                                        <div class="p-2 row">
                                            <div class="col-md-6">
                                                <?php if (empty($product['image'])) {
                                                    print('<img src="images/image-not-found.png" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                                } else {
                                                    print('<img src="product_img/' . $product['image'] . '" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                                }?>
                                            </div>
                                            <div class="col-md-6 text-wrap">
                                                <a href="product.php?id=<?=$product['product_id']?>" class="ctext d-inline-block align-middle text-wrap"><?=$product['name']?></a>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="border-0 align-middle text-center ctext">
                                        <span><?=$product['price']?>&euro;</span>
                                    </td>
                                    <td class="border-0 align-middle text-center ctext">
                                        <span><?=$product['quantity']?></span>
                                    </td>
                                    <td class="border-0 align-middle actions">
                                        <form action="cart.php" method="post" class="row me-2">
                                            <div class="col px-3 input-group">
                                                <span class="input-group-text">Menge:</span>
                                                <input class="form-control" type="number" value="<?=$product['id']?>" name="listid" style="display: none;" required>
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
                <strong>Summe: <?=$summprice?>&euro;</strong>
                <?php
                if ($total_products > 0) {
                    print('<a href="placeorder.php"><button class="btn btn-outline-primary mx-2 my-2" type="button">Bestellen</button></a>');
                } ?>
            </div>
        </div>
    </div> 
<?php else: ?>
    <div class="container minheight100 products content-wrapper py-3 px-3">
        <div class="row row-cols-1 row-cols-md-1 g-3">
            <div class="col">
                <div class="card mx-auto cbg">
                    <div class="card-body">
                        <h2 class="card-title name">Warenkorb</h2>
                        <p class="card-text"><?php print($total_products); ?> Produkt<?php if ($total_products > 1) { print('e'); } ?> im Warenkorb</p>
                    </div>
                </div>
            </div>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card mx-auto cbg">
                        <div class="card-body">
                            <?php if (empty($product['image'])) {
                                print('<img src="images/image-not-found.png" class="card-img-top rounded mb-3" alt="' . $product['name'] . '">');
                            } else {
                                print('<img src="product_img/' . $product['image'] . '" class="card-img-top rounded mb-3" alt="' . $product['name'] . '">');
                            }?>
                            <h4 class="card-title name text-wrap"><?=$product['name']?></h4>
                            <span class="card-text price">
                                Preis: &euro;<?=$product['price']?><br>
                                Menge: <?=$product['quantity']?>
                            </span>
                            <form action="cart.php" method="post" class="pt-2">
                                <div class="mx-auto pb-3 input-group">
                                    <span class="input-group-text">Menge:</span>
                                    <input class="form-control" type="number" value="<?=$product['id']?>" name="listid" style="display: none;" required>
                                    <input class="form-control" type="number" value="<?=$product['quantity']?>" min="1" max="<?=$product['maxquantity']?>" class="form-control form-control-sm" name="quantity" required>
                                    <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Speichern</button>
                                </div>
                                <div class="row mx-auto">
                                    <input type="number" value="<?=$product['id']?>" name="listid" style="display: none;" required>
                                    <button type="submit" name="action" value="del" class="btn btn-outline-primary">Löschen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col">
                <div class="card mx-auto cbg">
                    <div class="card-body">
                        <h2 class="card-title name">Summe:</h2>
                        <strong class="card-text"><?=$summprice?>&euro;</strong>
                        <?php
                        if ($total_products > 0) {
                            print('<a href="placeorder.php"><button class="btn btn-outline-primary mx-2 my-2" type="button">Bestellen</button></a>');
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
include_once("templates/footer.php")
?>