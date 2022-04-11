<?php
chdir ($_SERVER['DOCUMENT_ROOT']);
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

        $stmt = $pdo->prepare('SELECT * FROM product_images where product_id = ?');
        $stmt->bindValue(1, $_POST['productid'], PDO::PARAM_INT);
        $stmt->execute();
        $imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($x = 0; $x < count($imgs); $x++) {
            $var = 'delImage-'.$x;
            if (isset($_POST[$var])) {
                #del
                $stmt = $pdo->prepare('DELETE FROM product_images where id = ? and product_id = ?');
                $stmt->bindValue(1, $_POST[$var], PDO::PARAM_INT);
                $stmt->bindValue(2, $_POST['productid'], PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        if (!empty($_FILES["file"]["name"][0])){
            $allowTypes = array('jpg','png','jpeg','gif');
            $fileCount = count($_FILES['file']['name']);
            for($i = 0; $i < $fileCount; $i++){
                $fileName = uniqid('image_') . '_' . basename($_FILES["file"]["name"][$i]);
                $targetFilePath = "product_img/" . $fileName;
                if(in_array(pathinfo($targetFilePath,PATHINFO_EXTENSION), $allowTypes)){
                    // Upload file to server
                    if(move_uploaded_file($_FILES["file"]["tmp_name"][$i], $targetFilePath)){
                        // Insert image file name into database
                        $stmt = $pdo->prepare("INSERT into product_images (img, product_id) VALUES ( ? , ? )");
                        $stmt->bindValue(1, $fileName);
                        $stmt->bindValue(2, $_POST['productid'], PDO::PARAM_INT);
                        $stmt->execute();
                        if(!$stmt){
                            error("File upload failed, please try again.");
                        } 
                    }else{
                        error("Sorry, there was an error uploading your file.");
                    }
                }else{
                    error('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
                }
            }
        }
        if(isset($_POST['name']) and isset($_POST['price']) and isset($_POST['rrp']) and isset($_POST['quantity']) and isset($_POST['desc']) and isset($_POST['productid']) and isset($_POST['categorie']) and !empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['rrp']) and !empty($_POST['desc']) and !empty($_POST['productid']) and !empty($_POST['categorie'])) {
            $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, rrp = ?, quantity = ?, `desc` = ?, visible = ?, product_type_id = ?, updated_at = now() WHERE products.id = ?");
            $stmt->bindValue(1, $_POST['name']);
            $stmt->bindValue(2, $_POST['price']);
            $stmt->bindValue(3, $_POST['rrp']);
            $stmt->bindValue(4, $_POST['quantity']);
            $stmt->bindValue(5, $_POST['desc']);
            $stmt->bindValue(6, (isset($_POST['visible']) ? "1" : "0"), PDO::PARAM_INT);
            $stmt->bindValue(7, $_POST['categorie'], PDO::PARAM_INT);
            $stmt->bindValue(8, $_POST['productid'], PDO::PARAM_INT);
            $stmt->execute();

            #error_log(pdo_debugStrParams($stmt));
            echo("<script>location.href='product.php'</script>");
            #header("location: product.php");
            exit;
        } else {
        require_once("templates/header.php");
        ?>
        <div class="minheight100 px-3 py-3">
            <div class="row">
                <h1>Einstellungen</h1>
                <div class="col">
                    <form action="product.php" method="post" enctype="multipart/form-data">
                        <div class="input-group py-2">
                            <span class="input-group-text" for="inputName" style="width: 300px;">Name</span>
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
                            <span class="input-group-text" for="inputQuantity">Menge</span>
                            <input class="form-control" id="inputQuantity" name="quantity" type="text" value="<?=$product[0]['quantity']?>" required>
                        </div>
                        <div class="input-group py-2">
                            <span class="input-group-text" for="inputDesc">Description</span>
                            <textarea  class="form-control" name="desc" id="inputDesc" required><?=$product[0]['desc']?></textarea> 
                        </div>
                        <div class="input-group py-2">
                            <span class="input-group-text" for="inputVisible">Visible</span>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="inputVisible" name="visible" <?=($product[0]['visible']==1 ? 'checked':'')?>>
                            </div>
                        </div>
                        <div class="input-group py-2">
                            <span class="input-group-text" for="inputCategorie">Type</span>
                            <select class="form-select" id="inputCategorie" name="categorie">
                                <?php foreach ($types as $type) {
                                    if ($type['id'] == $product[0]['product_type_id']) {
                                        print('<option class="text-dark" value="' . $type['id'] . '" selected>' . $type['type'] . '</option>');
                                    } else {
                                        print('<option class="text-dark" value="' . $type['id'] . '">' . $type['type'] . '</option>');
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <?php 
                        for ($x = 0; $x < count($imgs); $x++) {
                            ?>
                            <div class="input-group py-2">
                                <img src="/product_img/<?=$imgs[$x]['img']?>" class="img-fluid rounded" alt="<?=$imgs[$x]['id']?>">
                                <input type="checkbox" class="form-check-input" value="<?=$imgs[$x]['id']?>" name="<?='delImage-'.$x?>">

                            </div>
                            <?php
                        }
                        ?>
                        
                        <input type="file" name="file[]" accept="image/png, image/gif, image/jpeg" multiple>
                        <input type="number" value="<?=$_POST['productid']?>" name="productid" style="display: none;" required>
                        <button type="submit" name="action" value="mod" class="py-2 btn btn-outline-success">Speichern</button>
                        <button type="submit" name="action" value="cancel" class="py-2 btn btn-outline-danger">Abrechen</button>
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
        if ($user['createProduct'] != 1) {
            error('Permission denied!');
        }

        $stmt = $pdo->prepare('SELECT * FROM products_types where not products_types.parent_id = 0');
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(isset($_POST['name']) and isset($_POST['price']) and isset($_POST['rrp']) and isset($_POST['quantity']) and isset($_POST['desc']) and isset($_POST['categorie']) and !empty($_POST['name']) and !empty($_POST['price']) and !empty($_POST['rrp']) and !empty($_POST['desc']) and !empty($_POST['categorie'])) {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, rrp, quantity, `desc`, visible, product_type_id, updated_at, created_at) VALUE (?, ?, ?, ?, ?, ?, ?, now(), now())");
            $stmt->bindValue(1, $_POST['name']);
            $stmt->bindValue(2, $_POST['price']);
            $stmt->bindValue(3, $_POST['rrp']);
            $stmt->bindValue(4, $_POST['quantity']);
            $stmt->bindValue(5, $_POST['desc']);
            $stmt->bindValue(6, (isset($_POST['visible']) ? "1" : "0"), PDO::PARAM_INT);
            $stmt->bindValue(7, $_POST['categorie'], PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $pdo->prepare('SELECT * FROM products where name = ? and `desc` = ? order by id desc');
            $stmt->bindValue(1, $_POST['name']);
            $stmt->bindValue(2, $_POST['desc']);
            $stmt->execute();
            $productForImg = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($_FILES["file"]["name"][0])){
                $allowTypes = array('jpg','png','jpeg','gif');
                $fileCount = count($_FILES['file']['name']);
                for($i = 0; $i < $fileCount; $i++){
                    $fileName = uniqid('image_') . '_' . basename($_FILES["file"]["name"][$i]);
                    $targetFilePath = "product_img/" . $fileName;
                    if(in_array(pathinfo($targetFilePath,PATHINFO_EXTENSION), $allowTypes)){
                        // Upload file to server
                        if(move_uploaded_file($_FILES["file"]["tmp_name"][$i], $targetFilePath)){
                            // Insert image file name into database
                            $stmt = $pdo->prepare("INSERT into product_images (img, product_id) VALUES ( ? , ? )");
                            $stmt->bindValue(1, $fileName);
                            $stmt->bindValue(2, $productForImg[0]['id'], PDO::PARAM_INT);
                            $stmt->execute();
                            if(!$stmt){
                                error("File upload failed, please try again.");
                            } 
                        }else{
                            error("Sorry, there was an error uploading your file.");
                        }
                    }else{
                        error('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
                    }
                }
            }

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
                <form action="product.php" method="post" enctype="multipart/form-data">
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputName">Name</span>
                        <input class="form-control" id="inputName" name="name" type="text" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputPrice">Preis</span>
                        <input class="form-control" id="inputPrice" name="price" type="text" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputRrp">UVP</span>
                        <input class="form-control" id="inputRrp" name="rrp" type="text" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputQuantity">Menge</span>
                        <input class="form-control" id="inputQuantity" name="quantity" type="text" required>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputDesc">Description</span>
                        <textarea  class="form-control" name="desc" id="inputDesc" required></textarea> 
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputVisible">Visible</span>
                        <input type="checkbox" class="form-check-input" id="inputVisible" name="visible" checked>
                    </div>
                    <div class="input-group py-2">
                        <span class="input-group-text" for="inputCategorie">Type</span>
                        <select class="form-select" id="inputCategorie" name="categorie">
                            <?php foreach ($types as $type) {
                                
                                print('<option class="text-dark" value="' . $type['id'] . '">' . $type['type'] . '</option>');
                            }
                            ?>
                        </select>
                    </div>
                    <input type="file" name="file[]" accept="image/png, image/gif, image/jpeg" multiple>
                    <button type="submit" name="action" value="add" class="py-2 btn btn-outline-success">Speichern</button>
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
            <form action="product.php" method="post">
                <div>
                    <button type="submit" name="action" value="add" class="btn btn-outline-primary">Hinzufügen</button>
                </div>
            </form>
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
                                    <form action="product.php" method="post" class="d-grid gap-2 d-md-flex justify-content-md-end">
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