<?php 
session_start();
require_once("php/mysql.php");
require_once("php/functions.php");
include("templates/header.php")
?>
<div>
<h1>Registrierung</h1>
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
	$error = false;
	$vorname = trim($_POST['vorname']);
	$nachname = trim($_POST['nachname']);
	$email = trim($_POST['email']);
	$passwort = $_POST['passwort'];
	$passwort2 = $_POST['passwort2'];
	
	if(empty($vorname) || empty($nachname) || empty($email)) {
		echo 'Bitte alle Felder ausfüllen<br>';
		$error = true;
	}
  
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
		$error = true;
	} 	
	if(strlen($passwort) == 0) {
		echo 'Bitte ein Passwort angeben<br>';
		$error = true;
	}
	if($passwort != $passwort2) {
		echo 'Die Passwörter müssen übereinstimmen<br>';
		$error = true;
	}
	
	//Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
	if(!$error) { 
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();
		
		if($user !== false) {
			echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
			$error = true;
		}	
	}
	
	//Überprüfe, ob die DSGVO akzeptiert wurde
	if(!$error) { 
		if(!(isset($_POST['dsgvo']))) {
			echo 'Sie müssen die Datenschutzerklärung akzeptieren!<br>';
			$error = true;
		}	
	}

	//Überprüfe, ob die AGBs akzeptiert wurden
	if(!$error) { 
		if(!(isset($_POST['agb']))) {
			echo 'Sie müssen die AGBs akzeptieren!<br>';
			$error = true;
		}	
	}

	//Keine Fehler, wir können den Nutzer registrieren
	if(!$error) {	
		$passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
		
		$statement = $pdo->prepare("INSERT INTO users (email, passwort, vorname, nachname) VALUES (:email, :passwort, :vorname, :nachname)");
		$result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname));
		
		if($result) {		
			echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
			$showFormular = false;
		} else {
			echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
		}
	} 
}
 
if($showFormular) {
?>

<form action="?register=1" method="post">

<div>
<label for="inputVorname">Vorname:</label>
<input type="text" value="TEST" id="inputVorname" size="40" maxlength="250" name="vorname" required>
</div>

<div>
<label for="inputNachname">Nachname:</label>
<input type="text" value="<?=$_GET["nachname"]?>" id="inputNachname" size="40" maxlength="250" name="nachname" required>
</div>

<div>
<label for="inputEmail">E-Mail:</label>
<input type="email" value="<?=$_GET["email"]?>" id="inputEmail" size="40" maxlength="250" name="email" required>
</div>

<div>
<label for="inputPasswort">Dein Passwort:</label>
<input type="password" value="<?=$_GET["passwort"]?>" id="inputPasswort" size="40"  maxlength="250" name="passwort" required>
</div> 

<div>
<label for="inputPasswort2">Passwort wiederholen:</label>
<input type="password" value="<?=$_GET[""]?>" id="inputPasswort2" size="40" maxlength="250" name="passwort2" required>
</div> 
<div>
<input type="checkbox" name="dsgvo" value="gelesen"> Ich habe die <a href="dsgvo.php">Datenschutzerklärung</a> gelesen und akzeptiere diese.
</div>
<div>
<input type="checkbox" name="agb" value="gelesen"> Ich habe die <a href="agb.php">AGBs</a> gelesen und akzeptiere diese.
</div>
<button type="submit">Registrieren</button>
</form>
 
<?php
} //Ende von if($showFormular)
	

?>
</div>
<?php 
include("templates/footer.php")
?>
