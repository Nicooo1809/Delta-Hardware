<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if (!isset($_GET['id'])) {
    echo("<script>location.href='internal.php'</script>");
}

$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and id = ?)) and product_list.list_id = (select id from orders where kunden_id = ? and id = ?)');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $_GET['id'], PDO::PARAM_INT);
$stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(4, $_GET['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($total_products > 0) {
    if(isset($_POST['action'])) {
        if($_POST['action'] == 'edit') {
            $stmt = $pdo->prepare('UPDATE orders SET rechnungsadresse = 1, lieferadresse = ? WHERE id = ? AND kunden_id = ? AND ordered = 1 AND NOT sent = 1');
            $stmt->bindValue(1, $_GET['rechnugsaddresse'], PDO::PARAM_INT);
            $stmt->bindValue(2, $_POST['lieferaddresse'], PDO::PARAM_INT);
            $stmt->bindValue(3, $_POST['id'], PDO::PARAM_INT);
            $stmt->bindValue(4, $user['id'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
            echo("<script>location.href='/internal.php'</script>");
        }
        if($_POST['action'] == 'del') {
            foreach ($products as $product) {
                $stmt = $pdo->prepare('UPDATE products SET products.quantity = products.quantity + ? WHERE id = ?');
                $stmt->bindValue(1, $product['quantity'], PDO::PARAM_INT);
                $stmt->bindValue(2, $product['product_id'], PDO::PARAM_INT);
                $result = $stmt->execute();
                if (!$result) {
                    error('Database error', pdo_debugStrParams($stmt));
                }
            }
            $stmt = $pdo->prepare('DELETE FROM product_list WHERE list_id = ?');
            $stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
            $stmt = $pdo->prepare('DELETE FROM orders WHERE id = ? AND kunden_id = ? AND ordered = 1 AND NOT sent = 1');
            $stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
            echo("<script>location.href='/internal.php'</script>");
        }
    }
} else {
    error('Wrong ID!');
}
if ($total_products < 1) {
    error('Permission denied!');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM orders where kunden_id = ? and id = ?');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $_GET['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
$summprice = 0;
foreach ($products as $product) {
    $summprice = $summprice + ($product['price'] * $product['quantity']);
}

$stmt = $pdo->prepare('SELECT * FROM citys, `address` where `address`.`citys_id` = citys.id AND `address`.`id` = ?');
$stmt->bindValue(1, $order[0]['rechnungsadresse'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$rechnungsadresse = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM citys, `address` where `address`.`citys_id` = citys.id AND `address`.`id` = ?');
$stmt->bindValue(1, $order[0]['lieferadresse'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$lieferadresse = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM `citys`, `address` where address.citys_id = citys.id and user_id = ?');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php if (!isMobile()): ?>
    <div class="container minheight100 products content-wrapper py-3 px-3">
        <div class="row">
            <div class="py-3 px-3 cbg ctext rounded">
                <h1>Bestellung</h1>
                <p><?=$total_products?> Produkt<?=($total_products>1 ? 'e':'')?></p>
                <p>Bestelldatum: <?=$order[0]['ordered_date']?></p>
                <?php if ($order[0]['sent']==1): ?>
                    <p>Versanddatum: <?=$order[0]['sent_date']?></p>
                <?php endif ?>
                <?php if ($order[0]['sent']!=1): ?>
                    <form action="?id=<?=$_GET['id']?>" method="post" class="d-flex justify-content-end">
                        <select class="form-select border-0 ps-4 text-dark fw-bold" id="inputRechnugsaddresse" name="rechnugsaddresse">
                            <?php foreach ($addresses as $address): ?>
                                <?php if ($address['default'] == 1): ?>
                                    <option class="text-dark" value="<?=$address['id']?>" selected><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                <?php else:?>
                                    <option class="text-dark" value="<?=$address['id']?>" ><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <label class="text-dark fw-bold" for="inputRechnugsaddresse">Rechnungsadresse</label>
                        <select class="form-select border-0 ps-4 text-dark fw-bold" id="inputLieferaddresse" name="lieferaddresse">
                            <?php foreach ($addresses as $address): ?>
                                <?php if ($address['default'] == 1): ?>
                                    <option class="text-dark" value="<?=$address['id']?>" selected><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                <?php else:?>
                                    <option class="text-dark" value="<?=$address['id']?>" ><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <label class="text-dark fw-bold" for="inputLieferaddresse">Lieferadresse</label>
                        <div class="">
                            <button class="btn btn-outline-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas">Bestellung stornieren</button>
                            <div class="offcanvas offcanvas-end cbg" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
                                <div class="offcanvas-header">
                                    <h2 class="offcanvas-title ctext" id="offcanvasLabel">Wirlich Löschen?</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <button class="btn btn-outline-success mx-2" type="submit" name="action" value="del">Ja</button>
                                    <button class="btn btn-outline-danger mx-2" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Nein</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="action" value="edit" class="py-2 btn btn-outline-success me-2">Speichern</button>
                    </form>
                <?php else: ?>
                <div class="row mb-2">
                    <div class="col-6">
                        <h2>Rechnungsaddresse</h2>
                        <div class="card cbg2 mx-auto py-2 px-2">
                            <p class="mb-0"><?=$user['vorname'].' '.$user['nachname']?></br>
                            <?=$rechnungsadresse[0]['street']?> <?=$rechnungsadresse[0]['number']?></br>
                            <?=$rechnungsadresse[0]['PLZ']?> <?=$rechnungsadresse[0]['city']?></br>
                        </div>
                    </div>
                    <div class="col-6">
                        <h2>Lieferaddresse</h2>
                        <div class="card cbg2 mx-auto py-2 px-2">
                            <p class="mb-0"><?=$user['vorname'].' '.$user['nachname']?></br>
                            <?=$lieferadresse[0]['street']?> <?=$lieferadresse[0]['number']?></br>
                            <?=$lieferadresse[0]['PLZ']?> <?=$lieferadresse[0]['city']?></br>
                        </div>
                    </div>
                </div>
                <?php endif ?>
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
                                                    <a href="product.php?id=<?=$product['product_id']?>" class="ctext d-inline-block align-middle text-wrap"><?=$product['name']?></a>
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
                <button class="py-2 ms-2 btn btn-outline-danger" type="button" onclick="window.location.href = '/internal.php';">Abbrechen</button>
            </div>
        </div>
    </div> 
<?php else: ?>
    <div class="container minheight100 products content-wrapper py-3 px-3">
        <div class="row row-cols-1 row-cols-md-1 g-3">
            <div class="col">
                <div class="card mx-auto cbg">
                    <div class="card-body">
                    <h1>Bestellen</h1>
                    <p><?=$total_products?> Produkt<?=($total_products>1 ? 'e':'')?></p>
                    <p>Bestelldatum: <?=$order[0]['ordered_date']?></p>
                    <?php if ($order[0]['sent']==1): ?>
                        <p>Versanddatum: <?=$order[0]['sent_date']?></p>
                    <?php endif ?>
                    </div>
                </div>
                <div class="card mx-auto my-2 cbg">
                    <?php if ($order[0]['sent']!=1): ?>
                        <form action="?id=<?=$_GET['id']?>" method="post" class="d-flex justify-content-end">
                            <select class="form-select border-0 ps-4 text-dark fw-bold" id="inputRechnugsaddresse" name="rechnugsaddresse">
                                <?php foreach ($addresses as $address): ?>
                                    <?php if ($address['default'] == 1): ?>
                                        <option class="text-dark" value="<?=$address['id']?>" selected><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                    <?php else:?>
                                        <option class="text-dark" value="<?=$address['id']?>" ><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <label class="text-dark fw-bold" for="inputRechnugsaddresse">Rechnungsadresse</label>
                            <select class="form-select border-0 ps-4 text-dark fw-bold" id="inputLieferaddresse" name="lieferaddresse">
                                <?php foreach ($addresses as $address): ?>
                                    <?php if ($address['default'] == 1): ?>
                                        <option class="text-dark" value="<?=$address['id']?>" selected><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                    <?php else:?>
                                        <option class="text-dark" value="<?=$address['id']?>" ><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <label class="text-dark fw-bold" for="inputLieferaddresse">Lieferadresse</label>
                            <button type="submit" name="action" value="del" class="py-2 btn btn-outline-success me-2">Bestellung stornieren</button>
                            <button type="submit" name="action" value="edit" class="py-2 btn btn-outline-success me-2">Speichern</button>
                        </form>
                    <?php else: ?>
                        <div class="card-body">
                            <h2>Rechnungsaddresse</h2>
                            <div class="card-text">
                                <p class="mb-0"><?=$user['vorname'].' '.$user['nachname']?></br>
                                <?=$rechnungsadresse[0]['street']?> <?=$rechnungsadresse[0]['number']?></br>
                                <?=$rechnungsadresse[0]['PLZ']?> <?=$rechnungsadresse[0]['city']?></br>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2>Lieferaddresse</h2>
                            <div class="card-text">
                                <p class="mb-0"><?=$user['vorname'].' '.$user['nachname']?></br>
                                <?=$lieferadresse[0]['street']?> <?=$lieferadresse[0]['number']?></br>
                                <?=$lieferadresse[0]['PLZ']?> <?=$lieferadresse[0]['city']?></br>
                            </div>
                        </div>
                    <?php endif ?>
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
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col">
                <div class="card mx-auto cbg">
                    <div class="card-body">
                        <h2 class="card-title name">Summe:</h2>
                        <strong class="card-text"><?=$summprice?>&euro;</strong>
                        <button class="py-2 ms-2 btn btn-outline-danger" type="button" onclick="window.location.href = '/internal.php';">Abbrechen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
include_once("templates/footer.php")
?>


<!-- 





 -->