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
                    echo("<script>location.href='user.php'</script>");
                    #header('Location: user.php');
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    echo("<script>location.href='user.php'</script>");
                    #header('Location: user.php');
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
                                        <p class="text-center">
                                            <form action="user.php" method="post">
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
            echo("<script>location.href='user.php'</script>");
            #header("location: user.php");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 py-3">
            <h1>Einstellungen</h1>
            <div>
                <form action="user.php" method="post">
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
        echo("<script>location.href='user.php'</script>");
        #header("location: user.php");
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
                                    <form action="user.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <?php if ($user['modifyUser'] == 1) {?>
                                        <div class="">
                                            <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Editieren</button>
                                        </div>
                                        <?php }?>
                                        <?php if ($user['deleteUser'] == 1) {?>
                                        <div class="">
                                            <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                            <button type="submit" name="action" value="del" class="btn btn-outline-danger">Löschen</button>
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