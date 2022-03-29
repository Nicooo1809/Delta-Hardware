<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
#error_log(print_r($user,true));
if ($user['showProduct'] != 1) {
    error('Permission denied!');
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'mod') {
        if ($user['modifyProduct'] != 1) {
            error('Permission denied!');
        }
        $stmt = $pdo->prepare('SELECT * FROM products where products.id = ?');
        $stmt->bindValue(1, $_POST['productid'], PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare('SELECT * FROM products_types where not products_types.parent_id = 0');
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(isset($_POST['vorname']) and isset($_POST['nachname']) and isset($_POST['email']) and isset($_POST['passwortNeu']) and isset($_POST['passwortNeu2']) and !empty($_POST['vorname']) and !empty($_POST['nachname']) and !empty($_POST['email'])) {
            
            $stmt = $pdo->prepare("UPDATE products SET email = ?, vorname = ?, nachname = ?, updated_at = now() WHERE products.id = ?");
            $stmt->bindValue(1, $_POST['email']);
            $stmt->bindValue(2, $_POST['vorname']);
            $stmt->bindValue(3, $_POST['nachname']);
            $stmt->bindValue(4, $_POST['productid'], PDO::PARAM_INT);
            $stmt->execute();

            #error_log(pdo_debugStrParams($stmt));
            echo("<script>location.href='produc.php'</script>");
            #header("location: produc.php");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 py-3">
            <h1>Einstellungen</h1>
            <div>
                <form action="produc.php" method="post">
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputName">Name</span>
                        <input class="form-control" id="inputName" name="name" type="text" value="<?=$product[0]['name']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputPrice">Preis</span>
                        <input class="form-control" id="inputPrice" name="price" type="text" value="<?=$product[0]['price']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputRrp">UVP</span>
                        <input class="form-control" id="inputRrp" name="rrp" type="text" value="<?=$product[0]['rrp']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputQuantity">UVP</span>
                        <input class="form-control" id="inputQuantity" name="quantity" type="text" value="<?=$product[0]['quantity']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputDesk">Description</span>
                        <textarea  class="form-control" name="desk" id="inputDesk" value="<?=$product[0]['desk']?>" required></textarea> 
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputVisible">Visible</span>
                        <input type="checkbox" class="form-check-input" id="inputVisible" name="visible" <?=($product[0]['visible']==1 ? 'checked':'')?>>
                    </div>
                    <select class="form-select" id="categorie" name="categorie">
                        <?php foreach ($types as $type) {
                            if ($type['id'] == $product[0]['product_type_id']) {
                                print('<option class="text-dark" value="' . $type['id'] . '" selected>' . $type['type'] . '</option>');
                            } else {
                                print('<option class="text-dark" value="' . $type['id'] . '">' . $type['type'] . '</option>');
                            }
                        }
                        ?>
                    </select>
                    <input type="number" value="<?=$_POST['productid']?>" name="productid" style="display: none;" required>
                    <button type="submit" name="action" value="mod" class="py-2 btn btn-outline-success">Speichern</button>
                    <button type="submit" name="action" value="cancel" class="py-2 btn btn-outline-danger">Abrechen</button>
                </form>
            </div>
        </div>
        <?php 
        include_once("templates/footer.php");
        exit;
        } 
    }
    if ($_POST['action'] == 'cancel') {
        echo("<script>location.href='produc.php'</script>");
        #header("location: produc.php");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM products_types, products where products.product_type_id = products_types.id ORDER BY products.id;');
$stmt->execute();
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
?>

<div class="container minheight100 users content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 cbg ctext rounded">
            <h1>Produktverwaltung</h1>
            <form action="produc.php" method="post">
                <div>
                    <button type="submit" name="action" value="add" class="btn btn-outline-primary">Editieren</button>
                </div>
            </form>
            <a href="register.php">Produkt hinzufügen</a>
            <p><?php print($total_products); ?> Benutzer</p>
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
                                    <form action="produc.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
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