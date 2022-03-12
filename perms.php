<?php
require_once("php/functions.php");
$user = check_user();
if ($user['showUserPerms'] != 1) {
    error('Permission denied!');
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if ($user['modifyUserPerms'] != 1) {
            error('Permission denied!');
        }
        if (isset($_POST['permsname'])) {
            $stmt = $pdo->prepare('INSERT INTO permission_group (name) VALUES (?)');
            $stmt->bindValue(1, $_POST['permsname']);
            $stmt->execute();
        } else {
            error('Some informations are missing!');
        }
    }

    if($_POST['action'] == 'del') {
        if ($user['modifyUserPerms'] != 1) {
            error('Permission denied!');
        }
        if(isset($_POST['permsid']) and !empty($_POST['permsid'])) {
            if (isset($_POST['confirm']) and !empty($_POST['confirm'])) {
                if ($_POST['confirm'] == 'yes') {
                    // User clicked the "Yes" button, delete record
                    $stmt = $pdo->prepare('UPDATE users SET permission_group = ? WHERE permission_group = ?');
                    $stmt->bindValue(1, 1, PDO::PARAM_INT);
                    $stmt->bindValue(2, $_POST['permsid'], PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt = $pdo->prepare('DELETE FROM permission_group WHERE id = ?');
                    $stmt->bindValue(1, $_POST['permsid'], PDO::PARAM_INT);
                    $stmt->execute();

                    header('Location: perms.php');
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    header('Location: perms.php');
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
                                        <h2 class="card-title mb-2 text-center">Alle Benutzer in dieser Gruppe werden in Default verschoben!</h2>
                                        <p class="text-center">
                                            <form action="perms.php" method="post">
                                                <input type="number" value="<?=$_POST['permsid']?>" name="permsid" style="display: none;" required>
                                                <input type="text" value="del" name="action" style="display: none;" required>
                                                <button class="btn btn-outline-primary mx-2" type="submit" name="confirm" value="yes">Ja</button>
                                                <button class="btn btn-outline-primary mx-2" type="submit" name="confirm" value="no">Nein</button>
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
        if ($user['modifyUserPerms'] != 1) {
            error('Permission denied!');
        }

        $stmt = $pdo->prepare("UPDATE permission_group SET showUser = ?, modifyUser = ?, deleteUser = ?, modifyUserPerms = ?, showUserPerms = ?, createProduct = ?, modifyProduct = ? WHERE permission_group.id = ?");
        $stmt->bindValue(1, (isset($_POST['showUser']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(2, (isset($_POST['modifyUser']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(3, (isset($_POST['deleteUser']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(4, (isset($_POST['modifyUserPerms']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(5, (isset($_POST['showUserPerms']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(6, (isset($_POST['createProduct']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(7, (isset($_POST['modifyProduct']) ? "1" : "0"), PDO::PARAM_INT);
        $stmt->bindValue(8, $_POST['permsid'], PDO::PARAM_INT);
        $stmt->execute();

        error_log(pdo_debugStrParams($stmt));
        header("location: perms.php");
        exit;
    }
    if ($_POST['action'] == 'cancel') {
        header("location: perms.php");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM permission_group');
$stmt->execute();
$permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($permissiontypes);
require_once("templates/header.php");
?>
<div class="container minheight100 users content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 cbg rounded">
            <h1>Rechteverwaltung</h1>
            <form action="perms.php" method="post" class="">
                <input type="text" name="permsname" required>
                <button type="submit" name="action" value="add" class="btn btn-outline-primary">Hinzufügen</button>
            </form>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <div class="cbg rounded">
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">#</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Name</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Show User</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Modify User</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Delete User</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Show User Permission</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Modify User Permission</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Create Product</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Modify Product</div>
                                </th>
                                <?php if ($user['modifyUserPerms'] == 1) {?>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase"></div>
                                </th>
                                <?php }?>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permissions as $perms): ?>
                            <?php if ($user['modifyUserPerms'] == 1) {?>
                                <tr>
                                    <form action="perms.php" method="post" class="">
                                        <td class="border-0 align-middle">
                                            <strong><?=$perms['id']?></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><?=$perms['name']?></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="showUser" <?=($perms['showUser']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="modifyUser" <?=($perms['modifyUser']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="deleteUser" <?=($perms['deleteUser']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="showUserPerms" <?=($perms['showUserPerms']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="modifyUserPerms" <?=($perms['modifyUserPerms']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="createProduct" <?=($perms['createProduct']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><input type="checkbox" class="form-check-input" name="modifyProduct" <?=($perms['modifyProduct']==1 ? 'checked':'')?>></strong>
                                        </td>
                                        
                                        <td class="border-0 align-middle actions">
                                            <div class="px-1 py-1">
                                                <input type="number" value="<?=$perms['id']?>" name="permsid" style="display: none;" required>
                                                <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Speichern</button>
                                            </div>
                                            <?php if ($perms['id'] != 1){?>
                                            <div class="px-1 py-1">
                                                <button type="submit" name="action" value="del" class="btn btn-outline-primary">Löschen</button>
                                            </div>
                                            <?php }?>
                                        </td>
                                    </form>
                                </tr>

                            <?php } else {?>
                            <tr>
                                <td class="border-0 align-middle">
                                    <strong><?=$perms['id']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$perms['name']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="showUser" <?=($perms['showUser']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="modifyUser" <?=($perms['modifyUser']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="deleteUser" <?=($perms['deleteUser']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="showUserPerms" <?=($perms['showUserPerms']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="modifyUserPerms" <?=($perms['modifyUserPerms']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="createProduct" <?=($perms['createProduct']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><input type="checkbox" class="form-check-input" name="modifyProduct" <?=($perms['modifyProduct']==1 ? 'checked':'')?> disabled></strong>
                                </td>
                            </tr>
                            <?php }?>
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