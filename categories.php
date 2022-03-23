<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if ($user['showCategories'] == 1) { #PERMISSION edit
    error('Permission denied!');
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if ($user['modifyCategories'] == 1) { #PERMISSION
            error('Permission denied!');
        }
        if (isset($_POST['categoriesname']) and isset($_POST['parentcategorie'])) {
            $stmt = $pdo->prepare('INSERT INTO products_types (type, parent_id) VALUES (?,?)');
            $stmt->bindValue(1, $_POST['categoriesname']);
            $stmt->bindValue(2, $_POST['parentcategorie']);
            $stmt->execute();
            echo("<script>location.href='categories.php'</script>");
        } else {
            error('Some informations are missing!');
        }
    }

    if($_POST['action'] == 'del') {
        if ($user['modifyCategories'] != 1) {
            error('Permission denied!');
        }
        if(isset($_POST['categoriesid']) and !empty($_POST['categoriesid'])) {
            if (isset($_POST['confirm']) and !empty($_POST['confirm'])) {
                if ($_POST['confirm'] == 'yes') {
                    // User clicked the "Yes" button, delete record
                    $stmt = $pdo->prepare('UPDATE users SET permission_group = ? WHERE permission_group = ?');
                    $stmt->bindValue(1, 1, PDO::PARAM_INT);
                    $stmt->bindValue(2, $_POST['categoriesid'], PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt = $pdo->prepare('DELETE FROM permission_group WHERE id = ?');
                    $stmt->bindValue(1, $_POST['categoriesid'], PDO::PARAM_INT);
                    $stmt->execute();
                    echo("<script>location.href='categories.php'</script>");
                    #header('Location: categories.php');
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    echo("<script>location.href='categories.php'</script>");
                    #header('Location: categories.php');
                    exit;
                }
            } else {
                ?>
                    <div class="container-fluid">
                        <div class="row no-gutter">
                            <div class="minheight100 col py-4 px-3">
                                <div class="card cbg text-center mx-auto" style="width: 75%;">
                                    <div class="card-body">
                                        <h1 class="card-title mb-2 text-center">Wirklich Löschen?</h1>
                                        <h2 class="card-title mb-2 text-center">Alle Benutzer in dieser Gruppe werden in Default verschoben!</h2>
                                        <p class="text-center">
                                            <form action="categories.php" method="post">
                                                <input type="number" value="<?=$_POST['categoriesid']?>" name="categoriesid" style="display: none;" required>
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
        if ($user['modifyCategories'] != 1) {
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
        $stmt->bindValue(8, $_POST['categoriesid'], PDO::PARAM_INT);
        $stmt->execute();

        #error_log(pdo_debugStrParams($stmt));
        echo("<script>location.href='categories.php'</script>");
        #header("location: categories.php");
        exit;
    }
    if ($_POST['action'] == 'cancel') {
        echo("<script>location.href='categories.php'</script>");
        #header("location: categories.php");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT *,(SELECT COUNT(*) FROM products WHERE products_types.id = products.product_type_id) as products from products_types');
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare('SELECT * from products_types where parent_id = 0');
$stmt->execute();
$cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($permissiontypes);
?>
<div class="container minheight100 users content-wrapper py-3 px-3">
    <div class="row">
        <div class="py-3 px-3 cbg rounded">
            <h1>Menüverwaltung</h1>
            <form action="categories.php" method="post" class="">
                <div class="input-group">
                    <input type="text" name="categoriesname" class="form-control" required>
                    <select class="form-select" id="parentcategorie" name="parentcategorie">
                        <?php foreach ($cats as $cat) {
                            print('<option class="text-dark" value="' . $cat['id'] . '">' . $cat['type'] . '</option>');
                        }
                        print('<option class="text-dark" value="0">ROOT</option>');
                        ?>
                    </select>
                    <button type="submit" name="action" value="add" class="btn btn-outline-primary">Hinzufügen</button>
                </div>
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
                                    <div class="p-2 px-3 text-uppercase">Parrent Categorie</div>
                                </th>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase">Products</div>
                                </th>
                                <?php if ($user['modifyCategories'] == 1) {?>
                                <th scope="col" class="border-0">
                                    <div class="p-2 px-3 text-uppercase"></div>
                                </th>
                                <?php }?>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $categorie): ?>
                            <?php if ($user['modifyCategories'] != 1) { #PERMISSIONS?> 
                                <tr>
                                    <form action="categories.php" method="post" class="">
                                        <td class="border-0 align-middle">
                                            <strong><?=$categorie['id']?></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <input class="form-control" id="categoriesname" name="categoriesname" type="text" value="<?=$categorie['type']?>" required>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <select class="form-select" id="permissions" name="permissions">
                                                <?php foreach ($cats as $cat) {
                                                    if ($cat['id'] == $categorie['parent_id']) {
                                                        print('<option class="text-dark" value="' . $cat['id'] . '" selected>' . $cat['type'] . '</option>');
                                                    } else {
                                                        print('<option class="text-dark" value="' . $cat['id'] . '">' . $cat['type'] . '</option>');
                                                    }
                                                }
                                                if ($categorie['parent_id'] == 0) {
                                                    print('<option class="text-dark" value="0" selected>ROOT</option>');
                                                } else {
                                                    print('<option class="text-dark" value="0">ROOT</option>');
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <strong><a><?=$categorie['products']?></a></strong>
                                        </td>
                                        
                                        <td class="border-0 align-middle actions">
                                            <div class="px-1 py-1">
                                                <input type="number" value="<?=$categorie['id']?>" name="categoriesid" style="display: none;" required>
                                                <button type="submit" name="action" value="mod" class="btn btn-outline-primary">Speichern</button>
                                            </div>
                                            <div class="px-1 py-1">
                                                <button type="submit" name="action" value="del" class="btn btn-outline-primary">Löschen</button>
                                            </div>
                                        </td>
                                    </form>
                                </tr>

                            <?php } else {?>
                            <tr>
                                <td class="border-0 align-middle">
                                    <strong><?=$categorie['id']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><?=$categorie['type']?></strong>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <?php foreach ($cats as $cat) {
                                        if ($cat['id'] == $categorie['parent_id']) {
                                            print('<a value="' . $cat['id'] . '">' . $cat['type'] . '</a>');
                                        }
                                    }
                                    if ($categorie['parent_id'] == 0) {
                                        print('<a value="0">ROOT</a>');
                                    }
                                    ?>
                                </td>
                                <td class="border-0 align-middle text-center">
                                    <strong><a><?=$categorie['products']?></a></strong>
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