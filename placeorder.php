<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
$stmt = $pdo->prepare('SELECT *, (SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) AS image, products.quantity as maxquantity FROM products, product_list where product_list.product_id = products.id and products.id in (SELECT product_id FROM product_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and product_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($total_products < 1) {
    echo("<script>location.href='cart.php'</script>");
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM `citys`, `address` where address.citys_id = citys.id and user_id = ?');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['confirm'])) {
    if($_POST['confirm'] == 'yes') {
        if (!isset($_POST['rechnugsaddresse']) and !isset($_POST['lieferaddresse']) and empty($_POST['rechnugsaddresse']) and empty($_POST['lieferaddresse'])) {
            error('Keine Addresse ausgewählt! Tipp: In den Einstellungen können sie eine Standardaddresse hinterlegen');
        }
        $msg = '';
        foreach ($products as $product) {
            $stmt = $pdo->prepare('SELECT * from  products WHERE id = ?');
            $stmt->bindValue(1, $product['product_id'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
            $product1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($product['quantity'] > $product1[0]['quantity']) {
                $msg = '<p class="mb-0 text-danger">Wir haben von mindestens einem der bestellten Artikel weniger als bestellt auf lager. <br>Deine Bestellung könnte sich deshalb eventuell ein wenig verzögern.</p>';
            }
            $stmt = $pdo->prepare('UPDATE products SET quantity = quantity - ? WHERE id = ?');
            $stmt->bindValue(1, $product['quantity'], PDO::PARAM_INT);
            $stmt->bindValue(2, $product['product_id'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
        }
        $stmt = $pdo->prepare('UPDATE orders SET rechnungsadresse = ?, lieferadresse = ?, ordered = 1, ordered_date = now() WHERE kunden_id = ? and ordered = 0');
        $stmt->bindValue(1, $_POST['rechnugsaddresse'], PDO::PARAM_INT);
        $stmt->bindValue(2, $_POST['lieferaddresse'], PDO::PARAM_INT);
        $stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
        $result = $stmt->execute();
        if (!$result) {
            error('Database error', pdo_debugStrParams($stmt));
        }
        $stmt = $pdo->prepare("INSERT INTO `orders` (`kunden_id`, `ordered`, `sent`) VALUES (?, 0, 0)");
        $stmt->bindValue(1, $user['id']);
        $result = $stmt->execute();
        if (!$result) {
            error('Database error', pdo_debugStrParams($stmt));
        }
        require_once("templates/header.php");
        ?>
        <div class="container minheight100 py-3 px-3">
            <div class="row">
                <div class="py-3 px-3 cbg ctext rounded">
                    <div>
                        <h1 class="mb-0 text-success text-center">Die Bestellung wurde erfolgreich aufgegeben und wird in kürze bei Ihnen sein.</h1>
                        <?php print($msg); ?>
                        <button class="btn btn-outline-primary" onclick="window.location.href = '/products.php';">Zurück zum Sortiment</button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        $error = true;
    }
    if($_POST['confirm'] == 'no') {
        echo("<script>location.href='cart.php'</script>");
        exit;
    }
}
// SELECT * ,(SELECT img From product_images WHERE product_images.product_id=products.id ORDER BY id LIMIT 1) as image FROM products_types, products where products.product_type_id = products_types.id and products_types.type = 'Test' ORDER BY products.name DESC;
// Select products ordered by the date added

$summprice = 0;
foreach ($products as $product) {
    $summprice = $summprice + ($product['price'] * $product['quantity']);
}
?>
<?php if (!isMobile()): ?>
    <div class="container minheight100 py-3 px-3">
        <div class="row">
            <div class="py-3 px-3 cbg ctext rounded">
                <h1>Bestellen</h1>
                <p>Sie sind im Begriff folgende<?=($total_products>1 ? ' '.$total_products:'s')?> Produkt<?=($total_products>1 ? 'e':'')?> kostenpflichtig zu bestellen. Sind Sie Sicher?</p>
                <form action="placeorder.php" method="post" class="">
                    <div class="row d-flex justify-content-between">
                        <div class="col-5 mx-1">
                            <div class="input-group mb-3">
                                <label class="text-dark input-group-text" for="inputRechnugsaddresse">Rechnungsadresse</label>
                                <select class="form-select border-0 text-dark fw-bold" id="inputRechnugsaddresse" name="rechnugsaddresse">
                                    <?php foreach ($addresses as $address): ?>
                                        <?php if ($address['default'] == 1): ?>
                                            <option class="text-dark" value="<?=$address['id']?>" selected><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                        <?php else:?>
                                            <option class="text-dark" value="<?=$address['id']?>" ><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-5 mx-1">
                            <div class="input-group mb-3">
                                <label class="text-dark input-group-text" for="inputLieferaddresse">Lieferadresse</label>
                                <select class="form-select border-0 text-dark fw-bold" id="inputLieferaddresse" name="lieferaddresse">
                                    <?php foreach ($addresses as $address): ?>
                                        <?php if ($address['default'] == 1): ?>
                                            <option class="text-dark" value="<?=$address['id']?>" selected><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                        <?php else:?>
                                            <option class="text-dark" value="<?=$address['id']?>" ><?=$address['street']?> <?=$address['number']?> - <?=$address['PLZ']?>, <?=$address['city']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success mx-1" type="submit" name="confirm" value="yes">Kostenpflichtig bestellen</button>
                    <button class="btn btn-danger mx-1" type="button" onclick="window.location.href = 'cart.php';">Abbrechen</button>
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
                                    <th scope="col" class="border-0 text-center" style="width: 10%;">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </symbol>
                                    </svg>
                                    <td class="border-0 align-middle text-center ctext">
                                    <?=($product['maxquantity'] < $product['quantity'] ? '
                                        <button type="button" class="btn btn-danger d-flex justify-content-center" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="<h5>Hardware nicht vollständig auf Lager!</h5>">
                                            <svg class="bi flex-shrink-0 me-0" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        </button>' : "")?>
                                        <script>
                                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                                return new bootstrap.Tooltip(tooltipTriggerEl)
                                            })
                                        </script>
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
                        <h1>Bestellen</h1>
                        <p>Sie sind im Begriff folgende<?=($total_products>1 ? ' '.$total_products:'s')?> Produkt<?=($total_products>1 ? 'e':'')?> kostenpflichtig zu bestellen. Sind Sie Sicher?</p>
                        <form action="placeorder.php" method="post" class="d-flex justify-content-center">
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
                            <button class="btn btn-success mx-1 my-2" type="submit" name="confirm" value="yes">Kostenpflichtig bestellen</button>
                            <button class="btn btn-danger mx-1 my-2" type="button" onclick="window.location.href = 'cart.php';">Abbrechen</button>
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


<!-- 





 -->