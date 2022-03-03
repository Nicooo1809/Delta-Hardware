<?php
session_start();
require_once("php/mysql.php");
require_once("php/functions.php");

//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
$user = check_user();

include("templates/header.php");

if(isset($_GET['save'])) {
	$save = $_GET['save'];
	
	if($save == 'personal_data') {
		$vorname = trim($_POST['vorname']);
		$nachname = trim($_POST['nachname']);
		
		if($vorname == "" || $nachname == "") {
			$error_msg = "Bitte Vor- und Nachname ausfüllen.";
		} else {
			$statement = $pdo->prepare("UPDATE users SET vorname = :vorname, nachname = :nachname, updated_at=NOW() WHERE id = :userid");
			$result = $statement->execute(array('vorname' => $vorname, 'nachname'=> $nachname, 'userid' => $user['id'] ));
			$user['vorname'] = $vorname;
			$user['nachname'] = $nachname;

			$success_msg = "Daten erfolgreich gespeichert.";
		}
	} else if($save == 'email') {
		$passwort = $_POST['passwort'];
		$email = trim($_POST['email']);
		$email2 = trim($_POST['email2']);
		
		if($email != $email2) {
			$error_msg = "Die eingegebenen E-Mail-Adressen stimmten nicht überein.";
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error_msg = "Bitte eine gültige E-Mail-Adresse eingeben.";
		} else if(!password_verify($passwort, $user['passwort'])) {
			$error_msg = "Bitte korrektes Passwort eingeben.";
		} else {
			$statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = :userid");
			$result = $statement->execute(array('email' => $email, 'userid' => $user['id'] ));
			$user['email'] = $email;
			
			$success_msg = "E-Mail-Adresse erfolgreich gespeichert.";
		}
		
	} else if($save == 'passwort') {
		$passwortAlt = $_POST['passwortAlt'];
		$passwortNeu = trim($_POST['passwortNeu']);
		$passwortNeu2 = trim($_POST['passwortNeu2']);
		
		if($passwortNeu != $passwortNeu2) {
			$error_msg = "Die eingegebenen Passwörter stimmten nicht überein.";
		} else if($passwortNeu == "") {
			$error_msg = "Das Passwort darf nicht leer sein.";
		} else if(!password_verify($passwortAlt, $user['passwort'])) {
			$error_msg = "Bitte korrektes Passwort eingeben.";
		} else {
			$passwort_hash = password_hash($passwortNeu, PASSWORD_DEFAULT);
				
			$statement = $pdo->prepare("UPDATE users SET passwort = :passwort WHERE id = :userid");
			$result = $statement->execute(array('passwort' => $passwort_hash, 'userid' => $user['id'] ));
				
			$success_msg = "Passwort erfolgreich gespeichert.";
		}
		
	}
}
?>

<div class="text-white mx-3 my-3">
	<h1>Einstellungen</h1>
	<?php 
	if(isset($success_msg) && !empty($success_msg)) {
		echo $success_msg;
	}
	?>
	<?php 
	if(isset($error_msg) && !empty($error_msg)) {
		echo $error_msg;
	}
	?>

	<div>
		<!-- Persönliche Daten-->
		<h2 onclick="toggle2(data)">Persönliche Daten</h2>
		<div id="data" style="display: none;">
			<br>
			<form action="?save=personal_data" method="post">
				<label for="inputVorname">Vorname</label>
				<input id="inputVorname" name="vorname" type="text" value="<?php echo htmlentities($user['vorname']); ?>" required>

				<label for="inputNachname">Nachname</label>
				<input id="inputNachname" name="nachname" type="text" value="<?php echo htmlentities($user['nachname']); ?>" required>

			<button type="submit" class="btn btn-outline-primary">Speichern</button>
			</form>
	</div>

<script>
	function toggle2(elementee) {
		var x = document.getElementById(elementee);
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
</script>

		<h2 onclick="toggle(document.getElementById('email'))">E-Mail-Adresse</h2>
		<!-- Änderung der E-Mail-Adresse -->
		<div id="email" style="display: none;">
			<br>
			<p>Zum Änderen deiner E-Mail-Adresse gib bitte dein aktuelles Passwort sowie die neue E-Mail-Adresse ein.</p>
			<form action="?save=email" method="post">
				<label for="inputPasswort">Passwort</label>
				<input id="inputPasswort" name="passwort" type="password" required>

				<label for="inputEmail">E-Mail</label>
			<input id="inputEmail" name="email" type="email" value="<?php echo htmlentities($user['email']); ?>" required>

				<label for="inputEmail2">E-Mail (wiederholen)</label>
			<input id="inputEmail2" name="email2" type="email"  required>

			<button type="submit" class="btn btn-outline-primary">Speichern</button>
			</form>
		</div>
		
		<h2 onclick="toggle(document.getElementById('passwort'))">Passworts</h2>
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
include_once("templates/footer.html")
?>
