<?php
require_once("php/functions.php");
$user = check_user();
#error_log(print_r($user,true));
if ($user['showUser'] != 1) {
    error('Permission denied!');
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'del') {
        if ($user['deleteUser'] != 1) {
            error('Permission denied!');
        }
        if(isset($_POST['userid']) and !empty($_POST['userid'])) {
            if (isset($_POST['confirm']) and !empty($_POST['confirm'])) {
                if ($_POST['confirm'] == 'yes') {
                    // User clicked the "Yes" button, delete record
                    $stmt = $pdo->prepare('DELETE FROM securitytokens WHERE user_id = ?');
                    $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt = $pdo->prepare('DELETE FROM orders WHERE kunden_id = ?');
                    $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
                    $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
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
                                <div class="card bg-dark text-center mx-auto" style="width: 75%;">
                                    <div class="card-body">
                                        <h1 class="card-title mb-2 text-center">Wirklich Löschen?</h1>
                                        <p class="text-center">
                                            <div>
                                            <form action="perms.php" method="post">
                                                <input type="number" value="<?=$_POST['userid']?>" name="userid" style="display: none;" required>
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
        if ($user['modifyUser'] != 1) {
            error('Permission denied!');
        }
        $stmt = $pdo->prepare('SELECT * FROM users where users.id = ?');
        $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
        $stmt->execute();
        $user1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $pdo->prepare('SELECT * FROM permission_group');
        $stmt->execute();
        $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(isset($_POST['vorname']) and isset($_POST['nachname']) and isset($_POST['email']) and isset($_POST['passwortNeu']) and isset($_POST['passwortNeu2']) and !empty($_POST['vorname']) and !empty($_POST['nachname']) and !empty($_POST['email'])) {
            $stmt = $pdo->prepare("UPDATE users SET email = ?, vorname = ?, nachname = ?, updated_at = now() WHERE users.id = ?");
            $stmt->bindValue(1, $_POST['email']);
            $stmt->bindValue(2, $_POST['vorname']);
            $stmt->bindValue(3, $_POST['nachname']);
            $stmt->bindValue(4, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            error_log(pdo_debugStrParams($stmt));
            if($_POST['passwortNeu'] == $_POST['passwortNeu2']) {
                if (!empty($_POST['passwortNeu']) and !empty($_POST['passwortNeu2'])) {
                    $stmt = $pdo->prepare("UPDATE users SET passwort = ?, updated_at = now() WHERE users.id = ?");
                    $stmt->bindValue(1, password_hash($_POST['passwortNeu'], PASSWORD_DEFAULT));
                    $stmt->bindValue(2, $_POST['userid'], PDO::PARAM_INT);
                    $stmt->execute();
                }
            } else {
                error('Password not equal!');
            }
            if ($user['modifyUserPerms'] == 1) {
                if (isset($_POST['permissions']) and !empty($_POST['permissions'])) {
                    $stmt = $pdo->prepare("UPDATE users SET permission_group = ?, updated_at = now() WHERE users.id = ?");
                    $stmt->bindValue(1, $_POST['permissions'], PDO::PARAM_INT);
                    $stmt->bindValue(2, $_POST['userid'], PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            #error_log(pdo_debugStrParams($stmt));
            header("location: perms.php");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 mx-3 my-3">
            <h1>Einstellungen</h1>

            <div>
                    <form action="perms.php" method="post">
                        <label for="inputVorname">Vorname</label>
                        <input class="form-control" id="inputVorname" name="vorname" type="text" value="<?=$user1[0]['vorname']?>" required>
                        <label for="inputNachname">Nachname</label>
                        <input class="form-control" id="inputNachname" name="nachname" type="text" value="<?=$user1[0]['nachname']?>" required>
                        <label for="inputEmail">E-Mail</label>
                        <input class="form-control" id="inputEmail" name="email" type="email" value="<?=$user1[0]['email']?>" required>
                        <label for="inputPasswortNeu">Neues Passwort</label>
                        <input class="form-control" id="inputPasswortNeu" name="passwortNeu" type="password">
                        <label for="inputPasswortNeu2">Neues Passwort (wiederholen)</label>
                        <input class="form-control" id="inputPasswortNeu2" name="passwortNeu2" type="password">
                        <?php if ($user['modifyUserPerms'] == 1) {?>
                        <label for="permissions">Permissions</label>
                            <select class="form-select" id="permissions" name="permissions">
                                <?php foreach ($permissions as $permission) {
                                    if ($permission['id'] == $user1[0]['permission_group']) {
                                        print('<option value="' . $permission['id'] . '" selected>' . $permission['name'] . '</option>');
                                    } else {
                                        print('<option value="' . $permission['id'] . '">' . $permission['name'] . '</option>');
                                    }
                                }?>
                            </select>
                        <?php }?>
                        <div class="input-group">
                            <input type="number" value="<?=$_POST['userid']?>" name="userid" style="display: none;" required>
                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Speichern</button>
                            <button type="submit" name="action" value="cancel" class="btn btn-outline-primary">Abrechen</button>
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
        <div class="py-3 px-3 bg-dark rounded">
            <h1>Benutzerverwaltung</h1>
            <p><?php print($total_users); ?> Benutzer</p>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <div class="bg-black rounded">
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
                                    <div class="p-2 px-3 text-uppercase">Modify User Permission</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Delete User</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Create Product</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Modify Product</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Delete Product</div>
                                </th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permissions as $user1): ?>
                            <tr>
                                <td class="border-0 align-middle">
                                    <strong><?=$user1['id']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['name']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['showUser']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['modifyUser']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['modifyUserPerms']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['deleteUser']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['createProduct']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['modifyProduct']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['deleteProduct']?></strong>
                                </td>
                                </td>
                                <td class="border-0 align-middle actions">
                                <?php if ($user['modifyUser'] == 1 or $user['modifyUser'] == 1) {?>
                                        <form action="perms.php" method="post" class="">
                                            <?php if ($user['modifyUser'] == 1) {?>
                                            <div class="px-1 py-1">
                                                <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                                <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Editieren</button>
                                            </div>
                                            <?php }?>
                                            <?php if ($user['deleteUser'] == 1) {?>
                                            <div class="px-1 py-1">
                                                <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                                <button type="submit" name="action" value="del" class="btn btn-outline-primary">Löschen</button>
                                            <?php }?>
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