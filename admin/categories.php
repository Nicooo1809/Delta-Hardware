<?php
chdir ($_SERVER['DOCUMENT_ROOT']);
require_once("php/functions.php");
$user = require_once("templates/header.php");
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if ($user['showCategories'] != 1) {
    error('Permission denied!');
}
if(isset($_POST['action'])) {
    if($_POST['action'] == 'add') {
        if ($user['modifyCategories'] != 1) {
            error('Permission denied!');
        }
        if (isset($_POST['categoriesname']) and isset($_POST['parentcategorie'])) {
            $stmt = $pdo->prepare('INSERT INTO products_types (type, parent_id) VALUES (?,?)');
            $stmt->bindValue(1, $_POST['categoriesname']);
            $stmt->bindValue(2, $_POST['parentcategorie']);
            $result = $stmt->execute();
            if (!$result) {
                error('Database error', pdo_debugStrParams($stmt));
            }
            
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
                    $stmt = $pdo->prepare('UPDATE products SET product_type_id = ? WHERE product_type_id = ?');
                    $stmt->bindValue(1, $_POST['newparentcategorie'], PDO::PARAM_INT);
                    $stmt->bindValue(2, $_POST['categoriesid'], PDO::PARAM_INT);
                    $result = $stmt->execute();
                    if (!$result) {
                        error('Database error', pdo_debugStrParams($stmt));
                    }

                    $stmt = $pdo->prepare('DELETE FROM products_types WHERE id = ?');
                    $stmt->bindValue(1, $_POST['categoriesid'], PDO::PARAM_INT);
                    $result = $stmt->execute();
                    if (!$result) {
                        error('Database error', pdo_debugStrParams($stmt));
                    }
                    

                    echo("<script>location.href='categories.php'</script>");
                    exit;
                } else {
                    // User clicked the "No" button, redirect them back to the read page
                    echo("<script>location.href='categories.php'</script>");
                    exit;
                }
            } else {
                $stmt = $pdo->prepare('SELECT * from products_types WHERE NOT parent_id = 0');
                $result = $stmt->execute();
                if (!$result) {
                    error('Database error', pdo_debugStrParams($stmt));
                }
                $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = $pdo->prepare('SELECT * from products_types WHERE id = ?');
                $stmt->bindValue(1, $_POST['categoriesid'], PDO::PARAM_INT);
                $result = $stmt->execute();
                if (!$result) {
                    error('Database error', pdo_debugStrParams($stmt));
                }
                $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                    <div class="container-fluid">
                        <div class="row no-gutter">
                            <div class="minheight100 col py-4 px-3">
                                <div class="card cbg text-center mx-auto" style="width: 75%;">
                                    <div class="card-body">
                                        <h1 class="card-title mb-2 text-center">Wirklich Löschen?</h1>
                                        <?php if ($tmp[0]['parent_id'] != 0) { ?>
                                            <h2 class="card-title mb-2 text-center">Alle Produkte werden in folgende Gruppe verschoben!</h2>
                                        <?php } ?>
                                        <p class="text-center">
                                            <form action="categories.php" method="post">
                                                <?php if ($tmp[0]['parent_id'] != 0) { ?>
                                                    <select class="form-select" id="newparentcategorie" name="newparentcategorie">
                                                        <?php foreach ($cats as $cat) {
                                                            print('<option class="text-dark" value="' . $cat['id'] . '">' . $cat['type'] . '</option>');
                                                        }
                                                        ?>
                                                    </select>
                                                <?php } else {
                                                    print('<input type="number" value="0" name="newparentcategorie" style="display: none;" required>');
                                                } ?>
                                                <input type="number" value="<?=$_POST['categoriesid']?>" name="categoriesid" style="display: none;" required>
                                                <input type="text" value="del" name="action" style="display: none;" required>
                                                <button class="btn btn-outline-primary mx-2" type="submit" name="confirm" value="yes">Ja</button>
                                                <a href="categories.php"><button class="btn btn-outline-primary mx-2" type="button">Nein</button></a>
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

        $stmt = $pdo->prepare("UPDATE products_types SET type = ?, parent_id = ? WHERE id = ?");
        $stmt->bindValue(1, $_POST['categoriesname']);
        $stmt->bindValue(2, $_POST['parentcategories'], PDO::PARAM_INT);
        $stmt->bindValue(3, $_POST['categoriesid'], PDO::PARAM_INT);
        $result = $stmt->execute();
        if (!$result) {
            error('Database error', pdo_debugStrParams($stmt));
        }
        echo("<script>location.href='categories.php'</script>");
        exit;
    }
    if ($_POST['action'] == 'cancel') {
        echo("<script>location.href='categories.php'</script>");
        exit;
    }
}

$stmt = $pdo->prepare('SELECT *,(SELECT COUNT(*) FROM products WHERE products_types.id = products.product_type_id) as products from products_types');
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare('SELECT * from products_types where parent_id = 0');
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                <th scope="col" class="border-0" style="width: 15%">
                                </th>
                                <?php }?>
                            </div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $categorie): ?>
                            <?php if ($user['modifyCategories'] == 1) {?> 
                                <tr>
                                    <form action="categories.php" method="post" class="">
                                        <td class="border-0 align-middle">
                                            <strong><?=$categorie['id']?></strong>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <input class="form-control" id="categoriesname" name="categoriesname" type="text" value="<?=$categorie['type']?>" required>
                                        </td>
                                        <td class="border-0 align-middle text-center">
                                            <select class="form-select" id="parentcategories" name="parentcategories">
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
                                                <button type="submit" name="action" value="mod" class="btn btn-outline-success">Speichern</button>
                                            </div>
                                            <div class="px-1 py-1">
                                                <button type="submit" name="action" value="del" class="btn btn-outline-danger">Löschen</button>
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