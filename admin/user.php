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
    if ($_POST['action'] == 'deleteconfirm') {
        if ($user['deleteUser'] != 1) {
            error('Permission denied!');
        }
        if(isset($_POST['userid']) and !empty($_POST['userid'])) {
            $stmt = $pdo->prepare('DELETE FROM securitytokens WHERE user_id = ?');
            $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $pdo->prepare('DELETE FROM orders WHERE kunden_id = ?');
            $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            echo("<script>location.href='admin/user.php'</script>");
            exit;
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
            #error_log(pdo_debugStrParams($stmt));
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
            echo("<script>location.href='admin/user.php'</script>");
            #header("location: admin/user.php");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 py-3">
            <h1>Einstellungen</h1>
            <div>
                <form action="admin/user.php" method="post">
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputVorname">Vorname</span>
                        <input class="form-control" id="inputVorname" name="vorname" type="text" value="<?=$user1[0]['vorname']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputNachname">Nachname</span>
                        <input class="form-control" id="inputNachname" name="nachname" type="text" value="<?=$user1[0]['nachname']?>" required>
                    </div>
                    <div class="input-group py-2">    
                        <span class="input-group-text" for="inputEmail">E-Mail</span>
                        <input class="form-control" id="inputEmail" name="email" type="email" value="<?=$user1[0]['email']?>" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputPasswortNeu">Neues Passwort</span>
                        <input class="form-control" id="inputPasswortNeu" name="passwortNeu" type="password">
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputPasswortNeu2">Neues Passwort (wiederholen)</span>
                        <input class="form-control" id="inputPasswortNeu2" name="passwortNeu2" type="password">
                    </div>
                    <?php if ($user['modifyUserPerms'] == 1) {?>
                        <div class="input-group py-2">
                            <span class="input-group-text" for="permissions">Permissions</span>
                            <select class="form-select" id="permissions" name="permissions">
                                <?php foreach ($permissions as $permission) {
                                    if ($permission['id'] == $user1[0]['permission_group']) {
                                        print('<option class="text-dark" value="' . $permission['id'] . '" selected>' . $permission['name'] . '</option>');
                                    } else { 
                                        print('<option class="text-dark" value="' . $permission['id'] . '">' . $permission['name'] . '</option>');
                                    }
                                }?>
                            </select>
                        </div>
                    <?php }?>
                    <input type="number" value="<?=$_POST['userid']?>" name="userid" style="display: none;" required>
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
        echo("<script>location.href='admin/user.php'</script>");
        #header("location: admin/user.php");
        exit;
    }
}

// SELECT * ,(SELECT img From user1_images WHERE user1_images.user1_id=users.id ORDER BY id LIMIT 1) as image FROM users_types, users where users.user1_type_id = users_types.id and users_types.type = 'Test' ORDER BY users.name DESC;
// Select users ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM permission_group, users where users.permission_group = permission_group.id ORDER BY users.id');
$stmt->execute();
// Get the total number of users
$total_users = $stmt->rowCount();
// Fetch the users from the database and return the result as an Array
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($users);
#$stmt->debugDumpParams();
?>

<div class="container minheight100 users content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 cbg ctext rounded">
            <h1>Benutzerverwaltung</h1>
            <a href="register.php">Benutzer hinzufügen</a>
            <p><?php print($total_users); ?> Benutzer</p>
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
                        <?php foreach ($users as $user1): ?>
                            <tr>
                                <td class="border-0 text-center">
                                    <strong><?=$user1['id']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$user1['vorname']?></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$user1['nachname']?></strong>
                                </td>
                                <td class="border-0 bl-400 text-center"">
                                    <strong><a href="mailto:<?=$user1['email']?>"><?=$user1['email']?></a></strong>
                                </td>
                                <td class="border-0 text-center">
                                    <strong><?=$user1['name']?></strong>
                                </td>
                                <td class="border-0">
                                    <strong><?=$user1['created_at']?></strong>
                                </td>
                                <td class="border-0 actions text-center">
                                <?php if ($user['modifyUser'] == 1 or $user['deleteUser'] == 1) {?>
                                    <form action="admin/user.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <?php if ($user['modifyUser'] == 1) {?>
                                        <div class="">
                                            <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Editieren</button>
                                        </div>
                                        <?php }?>
                                        <?php if ($user['deleteUser'] == 1) {?>
                                        <div class="">
                                            <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                            <button class="btn btn-outline-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas<?=$user1['id']?>" aria-controls="offcanvas<?=$user1['id']?>">Löschen</button>
                                                <div class="offcanvas offcanvas-end cbg" data-bs-scroll="true" tabindex="-1" id="offcanvas<?=$user1['id']?>" aria-labelledby="offcanvas<?=$user1['id']?>Label">
                                                    <div class="offcanvas-header">
                                                        <h2 class="offcanvas-title ctext" id="offcanvas<?=$user1['id']?>Label">Wirlich Löschen?</h2>
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
