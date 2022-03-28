<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
#error_log(print_r($user,true));
if ($user['showUser'] != 1) {
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
        
        $stmt = $pdo->prepare('SELECT * FROM permission_group');
        $stmt->execute();
        $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(isset($_POST['vorname']) and isset($_POST['nachname']) and isset($_POST['email']) and isset($_POST['passwortNeu']) and isset($_POST['passwortNeu2']) and !empty($_POST['vorname']) and !empty($_POST['nachname']) and !empty($_POST['email'])) {
            
            $stmt = $pdo->prepare("UPDATE products SET email = ?, vorname = ?, nachname = ?, updated_at = now() WHERE products.id = ?");
            $stmt->bindValue(1, $_POST['email']);
            $stmt->bindValue(2, $_POST['vorname']);
            $stmt->bindValue(3, $_POST['nachname']);
            $stmt->bindValue(4, $_POST['productid'], PDO::PARAM_INT);
            $stmt->execute();
            #error_log(pdo_debugStrParams($stmt));
            echo("<script>location.href='product.php'</script>");
            #header("location: product.php");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 py-3">
            <h1>Einstellungen</h1>
            <div>
                <form action="product.php" method="post">
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputVorname">Vorname</span>
                        <input class="form-control" id="inputVorname" name="vorname" type="text" value="<?=$product[0]['vorname']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputNachname">Nachname</span>
                        <input class="form-control" id="inputNachname" name="nachname" type="text" value="<?=$product[0]['nachname']?>" required>
                    </div>
                    <div class="input-group py-2">    
                        <span class="input-group-text" for="inputEmail">E-Mail</span>
                        <input class="form-control" id="inputEmail" name="email" type="email" value="<?=$product[0]['email']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputPasswortNeu">Neues Passwort</span>
                        <input class="form-control" id="inputPasswortNeu" name="passwortNeu" type="password">
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputPasswortNeu2">Neues Passwort (wiederholen)</span>
                        <input class="form-control" id="inputPasswortNeu2" name="passwortNeu2" type="password">
                    </div>
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
        echo("<script>location.href='product.php'</script>");
        #header("location: product.php");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM permission_group, products where products.permission_group = permission_group.id ORDER BY products.id');
$stmt->execute();
$total_products = $stmt->rowCount();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($products);
#$stmt->debugDumpParams();
?>

<div class="container minheight100 users content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 cbg ctext rounded">
            <h1>Benutzerverwaltung</h1>
            <a href="register.php">Benutzer hinzufügen</a>
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
                                    <div class="p-2 px-3 text-uppercase ctext">Vorname</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Nachname</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">E-Mail</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Rechte</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase ctext">Erstellt</div>
                                </th>
                                <th scope="col" class="border-0" style="width: 15%"></th>
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
                                    <strong><?=$product['vorname']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['nachname']?></strong>
                                </td>
                                <td class="border-0 bl-400 text-center"">
                                    <strong><a href="mailto:<?=$product['email']?>"><?=$product['email']?></a></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$product['name']?></strong>
                                </td>
                                <td class="border-0">
                                    <strong><?=$product['created_at']?></strong>
                                </td>
                                <td class="border-0 actions text-center">
                                <?php if ($user['modifyProduct'] == 1 or $user['deleteUser'] == 1) {?>
                                    <form action="product.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <?php if ($user['modifyProduct'] == 1) {?>
                                        <div class="">
                                            <input type="number" value="<?=$product['id']?>" name="productid" style="display: none;" required>
                                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Editieren</button>
                                        </div>
                                        <?php }?>
                                        <?php if ($user['deleteUser'] == 1) {?>
                                        <div class="">
                                            <input type="number" value="<?=$product['id']?>" name="productid" style="display: none;" required>
                                            <button class="btn btn-outline-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas<?=$product['id']?>" aria-controls="offcanvas<?=$product['id']?>">Löschen</button>
                                                <div class="offcanvas offcanvas-end cbg" data-bs-scroll="true" tabindex="-1" id="offcanvas<?=$product['id']?>" aria-labelledby="offcanvas<?=$product['id']?>Label">
                                                    <div class="offcanvas-header">
                                                        <h2 class="offcanvas-title ctext" id="offcanvas<?=$product['id']?>Label">Wirlich Löschen?</h2>
                                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                    </div>
                                                    <div class="offcanvas-body">
                                                        <button class="btn btn-outline-success mx-2" type="submit" name="action" value="deleteconfirm">Ja</button>
                                                        <button class="btn btn-outline-danger mx-2" type="button" data-bs-dismiss="offcanvas" aria-label="Close">Nein</button>
                                                    </div>
                                                </div>
                                            <!-- <button type="submit" name="action" value="del" class="btn btn-outline-danger">Löschen</button> -->
                                        </div>
                                        <?php }?>
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