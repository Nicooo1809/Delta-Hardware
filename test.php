<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");

print_r($_POST);

$allowTypes = array('jpg','png','jpeg','gif');
if(isset($_POST["submit"])){
    if(!empty($_FILES["file"]["name"][0])){
        // Allow certain file formats
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
                    $stmt->bindValue(2, 1, PDO::PARAM_INT);
                    $stmt->execute();
                    if(!$stmt){
                        $statusMsg = "File upload failed, please try again.";
                    } 
                }else{
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            }else{
                $statusMsg = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.';
            }
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }
}
// Display status message
if (isset($statusMsg)) {
    echo $statusMsg;
}
?>

<form action="test.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <input type="file" name="file[]" accept="image/png, image/gif, image/jpeg" multiple>
    <input type="checkbox" class="form-check-input" value="1" name="test0">
    <input type="checkbox" class="form-check-input" value="2" name="test">
    <input type="checkbox" class="form-check-input" value="3" name="test">
    <input type="submit" name="submit" value="Upload">

</form>

<?php
require_once("templates/footer.php");
?>