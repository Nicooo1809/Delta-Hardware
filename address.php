<?php
chdir ($_SERVER['DOCUMENT_ROOT']);
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if ($user['showProduct'] != 1) {
    error('Permission denied!');
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'mod') {

    }
    if($_POST['action'] == 'add') {
        
    }
    if ($_POST['action'] == 'cancel') {
        echo("<script>location.href='address.php'</script>");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM products_types, products where products.product_type_id = products_types.id ORDER BY products.id;');
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container minheight100 users content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 cbg ctext rounded">
            <h1>Produktverwaltung</h1>
            <form action="product.php" method="post">
                <div>
                    <button type="submit" name="action" value="add" class="btn btn-outline-primary">Hinzufügen</button>
                </div>
            </form>
            <p><?php print($total_products); ?> Produkt<?=($total_products==1 ? '':'e')?></p>
            <div class="table-responsive">
                <table class="table align-middle table-borderless table-hover">
                    <thead>
                        <tr>
                            <div class="cbg ctext rounded">
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">#</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Name</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Producttype</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">RRP</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Preis</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase ctext">Quantity</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase ctext">Created</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase ctext">Visible</div>
                                </th>
                                <?php if ($user['modifyProduct'] == 1) {
                                    print('<th scope="col" class="border-0"></th>');
                                } ?>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="border-0 text-center">
                                    <strong><?=$product['id']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['name']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['type']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['rrp']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['price']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['quantity']?></strong>
                                </td>
                                <td class="border-0">
                                    <strong><?=$product['created_at']?></strong>
                                </td>
                                <td class="border-0">
                                    <strong><input type="checkbox" class="form-check-input" <?=($product['visible']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 actions text-center">
                                <?php if ($user['modifyProduct'] == 1) {?>
                                    <form action="address.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div>
                                            <input type="number" value="<?=$product['id']?>" name="productid" style="display: none;" required>
                                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Editieren</button>
                                        </div>
                                    </form>
                                <?php }?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>         
        </div>
    </div>
</div> 

<?php
include_once("templates/footer.php")
?>