<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if(isset($_POST['confirm'])) {
    if($_POST['confirm'] == 'yes') {
        $stmt = $pdo->prepare('UPDATE orders SET ordered = 1, ordered_date = now() WHERE kunden_id = ? and ordered = 0');
        $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare('SELECT * FROM product_list where product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
        $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            $stmt = $pdo->prepare('SELECT * from  products WHERE id = ?');
            $stmt->bindValue(1, $product['product_id'], PDO::PARAM_INT);
            $stmt->execute();
            $product1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($product['quantity'] > $product1['quantity']) {
                require_once("templates/header.php");
                print('Entschuldigen sie es gibt nur noch ' . $product1['quantity'] . ' ' . $product1['name'] . 'Bitte passen sie Ihre Bestellmenge an oder warten noch mit Ihrer Bestellung');
                $error = true;
            } else {
                $stmt = $pdo->prepare('UPDATE products SET quantity = quantity - ? WHERE id = ?');
                $stmt->bindValue(1, $product['quantity'], PDO::PARAM_INT);
                $stmt->bindValue(2, $product1['id'], PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        $stmt = $pdo->prepare("INSERT INTO `orders` (`kunden_id`, `ordered`, `sent`) VALUES (?, 0, 0)");
        $stmt->bindValue(1, $user['id']);
        $stmt->execute();

        #error_log(print_r($product, true));
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 py-3">
            <h1>Vielen Dank für Ihre Bestellung</h1>
            <div>
                <p>Die Bestellung wurde erfolgreich aufgegeben und wird in kürze bei Ihnen sein.</p>
                <a href="products.php">Zurück zum Sortiment</a>
            </div>
        </div>
        <?php 
        $error = true;

    }
    if($_POST['confirm'] == 'no') {
        echo("<script>location.href='cart.php'</script>");
    }
}
if (isset($error) and $error = true) {
    include_once("templates/footer.php");
    exit;
}
// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products_types, products, product_list where product_list.product_id = products.id and products.product_type_id = products_types.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
$stmt->execute();
// Get the total number of products
$total_products = $stmt->rowCount();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
$summprice = 0;
foreach ($products as $product) {
    $summprice = $summprice + ($product['price'] * $product['quantity']);
}
?>
<?php if (!isMobile()): ?>
    <div class="container minheight100 products content-wrapper py-3 px-3">
        <div class="row">
            <div class="py-3 px-3 cbg ctext rounded">
                <h1>Bestellen</h1>
                <p>Sie sind im Begriff folgende <?php print($total_products); ?> Produkt<?php if ($total_products > 1) { print('e'); } ?> kostenpflichtig zu bestellen. Sind Sie Sicher?</p>
                <form action="order.php" method="post" class="row me-2">
                    <button type="submit" name="confirm" value="yes" class="btn btn-outline-primary">Kostenpflichtig bestellen</button>
                    <button type="submit" name="confirm" value="no" class="btn btn-outline-primary">Abbrechen</button>
                </form>
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
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <th scope="row" class="border-0">
                                        <div class="p-2">
                                            <?php if (empty($product['image'])) {
                                                print('<img src="images/image-not-found.png" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                            } else {
                                                print('<img src="product_img/' . $product['image'] . '" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                            }?>
                                            <div class="ms-3 d-inline-block align-middle">
                                                <h5 class="mb-0"> 
                                                    <a href="product.php?id=<?=$product['product_id']?>" class="ctext d-inline-block align-middle"><?=$product['name']?></a>
                                                </h5>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="border-0 align-middle text-center ctext">
                                        <span><?=$product['price']?>&euro;</span>
                                    </td>
                                    <td class="border-0 align-middle text-center ctext">
                                        <span><?=$product['quantity']?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>         
                <strong>Summe: <?=$summprice?>&euro;</strong>
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
                            <h4 class="card-title name"><?=$product['name']?></h4>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
include_once("templates/footer.php")
?>