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
        $stmt = $pdo->prepare('SELECT * FROM `citys`, `address` where address.citys_id = citys.id and user_id = ? and `address.id` = ?');
        $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
        $stmt->bindValue(1, $_POST['addressid'], PDO::PARAM_INT);
        $result = $stmt->execute();
        if (!$result) {
            error('Database error', pdo_debugStrParams($stmt));
        }
        $address = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(isset($_POST['addressid']) and isset($_POST['street']) and isset($_POST['number']) and isset($_POST['PLZ']) and isset($_POST['city']) and !empty($_POST['addressid']) and !empty($_POST['street']) and !empty($_POST['number']) and !empty($_POST['PLZ']) and !empty($_POST['city'])) {

            $stmt = $pdo->prepare("UPDATE `address` SET street = ?, `number` = ?, PLZ = ?, city = ?, updated_at = now() WHERE `address.id` = ?");
            $stmt->bindValue(1, $_POST['street']);
            $stmt->bindValue(2, $_POST['number']);
            $stmt->bindValue(3, $_POST['PLZ']);
            $stmt->bindValue(4, $_POST['city']);
            $stmt->bindValue(5, $_POST['address'], PDO::PARAM_INT);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }

            echo("<script>location.href='address.php'</script>");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 my-3">
            <div>
                <h1>Adresse anpassen</h1>
                <div>
                    <form action="product.php" method="post" enctype="multipart/form-data">
                        <div class="input-group py-2" style="max-width: 50rem;">
                            <span style="width: 150px;" class="input-group-text" for="inputStreet">Straße</span>
                            <input class="form-control" id="inputStreet" name="street" type="text" value="<?=$address[0]['street']?>" required>
                        </div>
                        <div class="input-group py-2" style="max-width: 50rem;">
                            <span style="width: 150px;" class="input-group-text" for="inputNumber">Hausnummer</span>
                            <input class="form-control" id="inputNumber" name="number" type="text" value="<?=$address[0]['number']?>" required>
                        </div>
                        <div class="input-group py-2" style="max-width: 50rem;">
                            <span style="width: 150px;" class="input-group-text" for="inputPlz">PLZ</span>
                            <input class="form-control" id="inputPlz" name="PLZ" type="text" value="<?=$address[0]['PLZ']?>">
                        </div>
                        <div class="input-group py-2" style="max-width: 50rem;">
                            <span style="width: 150px;" class="input-group-text" for="inputCity">Stadt</span>
                            <input class="form-control" id="inputCity" name="city" type="text" value="<?=$address[0]['city']?>" required>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                                <input type="number" value="<?=$_POST['addressid']?>" name="addressid" style="display: none;" required>
                                <button class="btn btn-success mx-1" type="submit" name="action" value="mod">Speichern</button>
                                <button class="btn btn-danger mx-1" type="button" onclick="window.location.href = '/address.php';">Abbrechen</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <?php 
        include_once("templates/footer.php");
        exit;
        } 
    }
    if($_POST['action'] == 'add') {
        
    }
    if ($_POST['action'] == 'cancel') {
        echo("<script>location.href='address.php'</script>");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM `citys`, `address` where address.citys_id = citys.id and user_id = ?');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_addresses = $stmt->rowCount();
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
            <p><?php print($total_addresses); ?> Adresse<?=($total_addresses==1 ? '':'n')?></p>
            <div class="table-responsive">
                <table class="table align-middle table-borderless table-hover">
                    <thead>
                        <tr>
                            <div class="cbg ctext rounded">
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">#</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Straße</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Hausnummer</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">PLZ</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase ctext">Ort</div>
                                </th>
                                    <th scope="col" class="border-0"></th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($addresses as $address): ?>
                            <tr>
                                <td class="border-0 text-center">
                                    <strong><?=$address['id']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$address['street']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$address['number']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$address['PLZ']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$address['city']?></strong>
                                </td>
                                <td class="border-0 actions text-center">
                                <?php if ($user['modifyProduct'] == 1) {?>
                                    <form action="address.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <div>
                                            <input type="number" value="<?=$address['id']?>" name="addressid" style="display: none;" required>
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