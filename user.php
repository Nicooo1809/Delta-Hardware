<?php
require_once("php/functions.php");
$user = check_user();
error_log(print_r($_POST, true));
if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if(isset($_POST['userid']) and isset($_POST['quantity']) and !empty($_POST['userid']) and !empty($_POST['quantity'])) {

            $stmt = $pdo->prepare('SELECT *, users.quantity as maxquantity FROM users, user1_list where user1_list.user1_id = users.id and user1_id = ? and users.id in (SELECT user1_id FROM user1_list where list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)) and user1_list.list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
            $stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
            $stmt->execute();
            $user1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            #error_log(print_r($user1, true));

            if (isset($user1[0])) {
                if ($_POST['quantity'] + $user1[0]['quantity'] > $user1[0]['maxquantity']) {
                    $quantity = $user1[0]['maxquantity'];
                } else {
                    $quantity = $_POST['quantity'] + $user1[0]['quantity'];
                }
                if ($quantity < 1) {
                    $quantity = 1;
                }
                $stmt = $pdo->prepare('UPDATE user1_list SET quantity = ? WHERE id = ?');
                $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
                $stmt->bindValue(2, $user1[0]['id'], PDO::PARAM_INT);
                $stmt->execute();
                header("location: user.php");
                exit;
            } else {
                $stmt = $pdo->prepare('SELECT * FROM users where users.id = ?');
                $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
                $stmt->execute();
                $user1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                #print_r($user1);
                if ($_POST['quantity'] > $user1[0]['quantity']) {
                    $quantity = $user1[0]['quantity'];
                } else {
                    $quantity = $_POST['quantity'];
                }
                if ($quantity < 1) {
                    $quantity = 1;
                }
                $stmt = $pdo->prepare('INSERT INTO user1_list (list_id, user1_id, quantity) VALUES ((select id from orders where kunden_id = ? and ordered = 0 and sent = 0), ?, ?)');
                $stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
                $stmt->bindValue(2, $_POST['userid']);
                $stmt->bindValue(3, $quantity, PDO::PARAM_INT);
                $stmt->execute();
                header("location: user.php");
                exit;
            }
            
            
        } else {
            error('Some informations are missing!');
        }
    }
    if($_POST['action'] == 'del') {
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
                    header('Location: user.php');
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    header('Location: user.php');
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
        if(isset($_GET['save'])) {
            $save = $_GET['save'];
            $stmt = $pdo->prepare('SELECT * FROM users where users.id = ?');
            $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            $user1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($save == 'personal_data') {
                $vorname = trim($_POST['vorname']);
                $nachname = trim($_POST['nachname']);
                
                if($vorname == "" || $nachname == "") {
                    error( "Bitte Vor- und Nachname ausfüllen.");
                } else {
                    $statement = $pdo->prepare("UPDATE users SET vorname = :vorname, nachname = :nachname, updated_at=NOW() WHERE id = :userid");
                    $result = $statement->execute(array('vorname' => $vorname, 'nachname'=> $nachname, 'userid' => $_POST['userid'] ));
                    $user1[0]['vorname'] = $vorname;
                    $user1[0]['nachname'] = $nachname;
                    header("location: user.php");
                    exit;
                }
            } else if($save == 'email') {
                $passwort = $_POST['passwort'];
                $email = trim($_POST['email']);
                $email2 = trim($_POST['email2']);
                
                if($email != $email2) {
                    error("Die eingegebenen E-Mail-Adressen stimmten nicht überein.");
                } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    error("Bitte eine gültige E-Mail-Adresse eingeben.");
                } else if(!password_verify($passwort, $user1[0]['passwort'])) {
                    error("Bitte korrektes Passwort eingeben.");
                } else {
                    $statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = :userid");
                    $result = $statement->execute(array('email' => $email, 'userid' => $_POST['userid'] ));
                    $user1[0]['email'] = $email;
                    header("location: user.php");
                    exit;
                }
                
            } else if($save == 'passwort') {
                $passwortAlt = $_POST['passwortAlt'];
                $passwortNeu = trim($_POST['passwortNeu']);
                $passwortNeu2 = trim($_POST['passwortNeu2']);
                
                if($passwortNeu != $passwortNeu2) {
                    error("Die eingegebenen Passwörter stimmten nicht überein.");
                } else if($passwortNeu == "") {
                    error("Das Passwort darf nicht leer sein.");
                } else if(!password_verify($passwortAlt, $user1[0]['passwort'])) {
                    error("Bitte korrektes Passwort eingeben.");
                } else {
                    $passwort_hash = password_hash($passwortNeu, PASSWORD_DEFAULT);
                        
                    $statement = $pdo->prepare("UPDATE users SET passwort = :passwort WHERE id = :userid");
                    $result = $statement->execute(array('passwort' => $passwort_hash, 'userid' => $_POST['userid'] ));
                    header("location: user.php");
                    exit;
                }
                
            }
        }
        include("templates/header.php");
        ?>

        <div class="text-white minheight100 mx-3 my-3">
            <h1>Einstellungen</h1>

            <div>
                <!-- Persönliche Daten-->
                <h2 onclick="toggleData(data)">Persönliche Daten</h2>
                <script>
                    function toggleData() {
                        var x = document.getElementById("data");
                        if (x.style.display === "none") {
                            x.style.display = "block";
                        } else {
                            x.style.display = "none";
                        }
                    }
                </script>
                <div id="data" style="display: none;">
                    <br>
                    <form action="?save=personal_data" method="post">
                        <label for="inputVorname">Vorname</label>
                        <input id="inputVorname" name="vorname" type="text" value="<?php echo htmlentities($user1[0]['vorname']); ?>" required>

                        <label for="inputNachname">Nachname</label>
                        <input id="inputNachname" name="nachname" type="text" value="<?php echo htmlentities($user1[0]['nachname']); ?>" required>

                    <button type="submit" class="btn btn-outline-primary">Speichern</button>
                    </form>
                </div>

                <!-- <h2 onclick="toggle(document.getElementById('email'))">E-Mail-Adresse</h2> -->
                <h2 onclick="toggleEmail()">E-Mail-Adresse</h2>
                <script>
                    function toggleEmail() {
                        var x = document.getElementById("email");
                        if (x.style.display === "none") {
                            x.style.display = "block";
                        } else {
                            x.style.display = "none";
                        }
                    }
                </script>
                <!-- Änderung der E-Mail-Adresse -->
                <div id="email" style="display: none;">
                    <br>
                    <p>Zum Änderen deiner E-Mail-Adresse gib bitte dein aktuelles Passwort sowie die neue E-Mail-Adresse ein.</p>
                    <form action="?save=email" method="post">
                        <label for="inputPasswort">Passwort</label>
                        <input id="inputPasswort" name="passwort" type="password" required>

                        <label for="inputEmail">E-Mail</label>
                    <input id="inputEmail" name="email" type="email" value="<?php echo htmlentities($user1[0]['email']); ?>" required>

                        <label for="inputEmail2">E-Mail (wiederholen)</label>
                    <input id="inputEmail2" name="email2" type="email"  required>

                    <button type="submit" class="btn btn-outline-primary">Speichern</button>
                    </form>
                </div>

                <h2 onclick="togglePassword()">Passworts</h2>
                <script>
                    function togglePassword() {
                        var x = document.getElementById("passwort");
                        if (x.style.display === "none") {
                            x.style.display = "block";
                        } else {
                            x.style.display = "none";
                        }
                    }
                </script>
                <!-- Änderung des Passworts -->
                <div id="passwort" style="display: none;">
                    <br>
                    <p>Zum Änderen deines Passworts gib bitte dein aktuelles Passwort sowie das neue Passwort ein.</p>
                    <form action="?save=passwort" method="post">
                        <label for="inputPasswort">Altes Passwort</label>
                        <input id="inputPasswort" name="passwortAlt" type="password" required>

                        <label for="inputPasswortNeu">Neues Passwort</label>
                        <input id="inputPasswortNeu" name="passwortNeu" type="password" required>

                        <label for="inputPasswortNeu2">Neues Passwort (wiederholen)</label>
                        <input id="inputPasswortNeu2" name="passwortNeu2" type="password"  required>

                    <button type="submit" class="btn btn-outline-primary">Speichern</button>

                    </form>
                </div>
            </div>
        </div>
        <?php 
        include_once("templates/footer.php");
        exit;

        if(isset($_POST['userid']) and !empty($_POST['userid'])) {
            $stmt = $pdo->prepare('select *, users.quantity as maxquantity from users, user1_list where users.id = user1_list.user1_id and user1_list.id = ?');
            $stmt->bindValue(1, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            $user1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($_POST['quantity'] > $user1[0]['maxquantity']) {
                $quantity = $user1[0]['maxquantity'];
            } else {
                $quantity = $_POST['quantity'];
            }
            if ($quantity < 1) {
                $quantity = 1;
            }
            $stmt = $pdo->prepare('UPDATE user1_list SET quantity = ? WHERE id = ? and list_id = (select id from orders where kunden_id = ? and ordered = 0 and sent = 0)');
            $stmt->bindValue(1, $quantity, PDO::PARAM_INT);
            $stmt->bindValue(2, $_POST['userid'], PDO::PARAM_INT);
            $stmt->bindValue(3, $_POST['userid'], PDO::PARAM_INT);
            $stmt->execute();
            header('Location: user.php');
            exit;
        } else {
            error('Some informations are missing!');
        }
    }
}

// SELECT * ,(SELECT img From user1_images WHERE user1_images.user1_id=users.id ORDER BY id LIMIT 1) as image FROM users_types, users where users.user1_type_id = users_types.id and users_types.type = 'Test' ORDER BY users.name DESC;
// Select users ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM users ORDER BY id');
$stmt->execute();
// Get the total number of users
$total_users = $stmt->rowCount();
// Fetch the users from the database and return the result as an Array
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($users);
#$stmt->debugDumpParams();
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
                                    <div class="p-2 px-3 text-uppercase">Vorname</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase">Nachname</div>
                                </th>
                                <th scope="col" class="border-0 text-center">
                                    <div class="p-2 px-3 text-uppercase">E-Mail</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Created</div>
                                </th>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user1): ?>
                            <tr>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['id']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['vorname']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['nachname']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><a href="mailto:<?=$user1['email']?>"><?=$user1['email']?></a></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$user1['created_at']?></strong>
                                </td>
                                <td class="border-0 align-middle actions">
                                    <form action="user.php" method="post" class="row me-2">
                                        <div class="col px-3">
                                            <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                            <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Editieren</button>
                                        </div>
                                        <div class="col-7 px-3">
                                            <input type="number" value="<?=$user1['id']?>" name="userid" style="display: none;" required>
                                            <button type="submit" name="action" value="del" class="btn btn-outline-primary">Löschen</button>
                                        </div>
                                    </form>
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