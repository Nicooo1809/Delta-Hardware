<?php
chdir ($_SERVER['DOCUMENT_ROOT']);
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if ($user['showOrders'] != 1) {
    error('Permission denied!');
}
if (!isset($_GET['id']) or empty($_GET['id'])) {
    echo("<script>location.href='/internal.php'</script>");
}
$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and product_list.list_id = ?');
$stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['confirm'])) {
    if($_POST['confirm'] == 'yes') {
		if ($user['markOrders'] != 1) {
			error('Permission denied!');
		}
        $stmt = $pdo->prepare('UPDATE orders SET sent = 1, sent_date = now() WHERE id = ? and ordered = 1');
        $stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
		echo("<script>location.href='/internal.php'</script>");
        #error_log(print_r($product, true));
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
                <h1>Bestellung bearbeiten</h1>
                <p>Bitte folgende<?=($total_products>1 ? ' '.$total_products:'s')?> Produkt<?=($total_products>1 ? 'e':'')?> für den Kunden einpacken und das Packet mit folgendem Addressaufkleber versehen:</p>
				<p><?=$customer[0]['vorname'].' '.$customer[0]['nachname']?></br>
				<?=$customer[0]['streetHouseNr']?></br>
				<?=$customer[0]['city']?></p>
                <?php if ($user['markOrders'] == 1) { ?>
                    <form action="?id=<?=$_GET['id']?>" method="post" class="d-flex justify-content-end mb-2">
                        <button type="submit" name="confirm" value="yes" class="py-2 btn btn-outline-success me-2">Erledigt</button>
                        <button class="py-2 ms-2 btn btn-outline-danger" type="button" onclick="window.location.href = '/internal.php';">Abbrechen</button>
                    </form>
                <?php } ?>
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
                                                print('<img src="/images/image-not-found.png" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                            } else {
                                                print('<img src="/product_img/' . $product['image'] . '" width="150" class="img-fluid rounded shadow-sm" alt="' . $product['name'] . '">');
                                            }?>
                                            <div class="ms-3 d-inline-block align-middle">
                                                <h5 class="mb-0"> 
                                                    <a href="/product.php?id=<?=$product['product_id']?>" class="ctext d-inline-block align-middle"><?=$product['name']?></a>
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
    <div class="container minheight100 products content-wrapper py-2 px-2">
        <div class="card mx-auto my-2 cbg">
            <div class="card-body">
                <h2 class="card-title name">Bestellung bearbeiten</h2>
                <p class="card-text">Bitte folgende<?=($total_products>1 ? ' '.$total_products:'s')?> Produkt<?=($total_products>1 ? 'e':'')?> für den Kunden einpacken und das Packet mit folgendem Addressaufkleber versehen:</p>
            </div>
        </div>
        <div class="card mx-auto my-2 cbg">
            <div class="card-body">
                <p class="card-text">
                    <?=$customer[0]['vorname'].' '.$customer[0]['nachname']?></br>
                    <?=$customer[0]['streetHouseNr']?></br>
                    <?=$customer[0]['city']?>
                </p>
            </div>
        </div>
        <?php if ($user['markOrders'] == 1) { ?>
            <div class="card mx-auto my-2 cbg">
                <div class="card-body">
                    <form action="?id=<?=$_GET['id']?>" method="post" class="d-flex justify-content-between">
                        <button type="submit" name="confirm" value="yes" class="py-2 btn btn-outline-success">Erledigt</button>
                        <button class="py-2 btn btn-outline-danger" type="button" onclick="window.location.href = '/internal.php';">Abbrechen</button>
                    </form>
                </div>
            </div>
        <?php } ?>
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card mx-auto my-2 cbg">
                    <?php if (empty($product['image'])) {
                        print('<img src="/images/image-not-found.png" class="card-img-top img-fluid" alt="' . $product['name'] . '">');
                    } else {
                        print('<img src="/product_img/' . $product['image'] . '" class="card-img-top img-fluid" alt="' . $product['name'] . '">');
                    }?>
                        <div class="card-body">
                        <h4 class="card-title name"><?=$product['name']?></h4>
                        <span class="card-text price">
                            Preis: &euro;<?=$product['price']?><br>
                            Menge: <?=$product['quantity']?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="card mx-auto my-2 cbg">
            <div class="card-body">
                <h2 class="card-title name">Summe:</h2>
                <strong class="card-text"><?=$summprice?>&euro;</strong>
            </div>
        </div>
    </div>
<?php endif;?>

<?php
include_once("templates/footer.php")
?>