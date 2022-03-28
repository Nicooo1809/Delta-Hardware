<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");






$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = "uploads/" . $fileName;

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif');
    if(in_array(pathinfo($targetFilePath,PATHINFO_EXTENSION), $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $stmt = $pdo->prepare("INSERT into product_images (img, product_id) VALUES ( ? , ? )");
            $stmt->bindValue(1, $fileName);
            $stmt->bindValue(2, 1, PDO::PARAM_INT);
            $stmt->execute();
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;





?>

<form action="test.php" method="post" enctype="multipart/form-data">
    Select Image File to Upload:
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
</form>

<?php
require_once("templates/footer.php");
?>