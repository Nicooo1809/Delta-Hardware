<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and product_list.list_id = ?');
$stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['confirm'])) {
    if($_POST['confirm'] == 'yes') {
        $stmt = $pdo->prepare('UPDATE orders SET sent = 1, sent_date = now() WHERE id = ? and ordered = 1');
        $stmt->bindValue(1, $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
		echo("<script>location.href='internal.php'</script>");
        #error_log(print_r($product, true));
    }
    if($_POST['confirm'] == 'no') {
        echo("<script>location.href='internal.php'</script>");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM users, orders where users.id = orders.kunden_id AND orders.id = ?');
$stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                <h1>Bestellen bearbeiten</h1>
                <p>Bitte packe folgende<?=($total_products>1 ? ' '.$total_products:'s')?> Produkt<?=($total_products>1 ? 'e':'')?> für den Kunden ein und versehen das Packet mit folgendem Addressaufkleber:</p>
				<p><?=$customer[0]['gender'].' '.$customer[0]['vorname'].' '.$customer[0]['nachname']?></p></br>
				<p><?=$customer[0]['streetHouseNr']?></p></br>
				<p><?=$customer[0]['city']?></p>
				<form action="orde.php" method="post" class="row me-2">
					<input type="number" value="<?=$_GET['id']?>" name="id" style="display: none;" required>
                    <button type="submit" name="confirm" value="yes" class="btn btn-outline-primary">Erledigt</button>
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
					<h1>Bestellen bearbeiten</h1>
					<p>Bitte packe folgende<?=($total_products>1 ? ' '.$total_products:'s')?> Produkt<?=($total_products>1 ? 'e':'')?> für den Kunden ein und versehen das Packet mit folgendem Addressaufkleber:</p>
					<p><?=$customer[0]['gender'].' '.$customer[0]['vorname'].' '.$customer[0]['nachname']?></p></br>
					<p><?=$customer[0]['streetHouseNr']?></p></br>
					<p><?=$customer[0]['city']?></p>
					<form action="orde.php" method="post" class="row me-2">
						<input type="number" value="<?=$_GET['id']?>" name="id" style="display: none;" required>
						<button type="submit" name="confirm" value="yes" class="btn btn-outline-primary">Erledigt</button>
						<button type="submit" name="confirm" value="no" class="btn btn-outline-primary">Abbrechen</button>
					</form>
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