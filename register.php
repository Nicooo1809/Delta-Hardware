<?php 
session_start();
require_once("php/mysql.php");
require_once("php/functions.php");
include("templates/header.php")
?>

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
		$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $stmt->execute(array('email' => $email));
		$user = $stmt->fetch();
		
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
		
		$stmt = $pdo->prepare("INSERT INTO users (email, passwort, vorname, nachname) VALUES (:email, :passwort, :vorname, :nachname)");
		$result = $stmt->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname));
		if ($result) {
			$stmt = $pdo->prepare("INSERT INTO `orders` (`kunden_id`, `ordered`, `delivered`) VALUES ((select id from users where email = ?), '0', '0')");
			$stmt->bindValue(1, $email);
			$result = $stmt->execute();
		}

		if($result) {
			$showFormular = false;
			?>
			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-xl-7 mx-auto my-5 py-3 px-5 text-center rounded bg-dark">
						<h1 class="text-success">REGISTRIERUNG ERFOLGREICH<i class="fa-solid fa-check"></i></h1>
						<p class="text-white">
						Du wirst automatisch in 5 Sekunden zum Login geleitet, solltest du nicht weitergeleitet werden klicke <a href="login">hier</a>.
						</p>
					</div>
				</div>
			</div>

			

		<?php
		} else {
			$showFormular = false;
			?>
			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-xl-7 mx-auto my-5 py-3 px-5 text-center rounded bg-dark">
						<h1 class="text-danger">Oops, das hat nicht geklappt!<br><i class="fa-solid fa-x"></i></h1>
						<p class="text-white">
						Beim Abspeichern ist leider ein Fehler aufgetreten, bitte versuche es später erneut.
						Du wirst automatisch in 5 Sekunden zurückgeleitet, solltest du nicht weitergeleitet werden klicke <a href="register">hier</a>.
						</p>
					</div>
				</div>
			</div>

			

		<?php
		}
	} 
}



if($showFormular) {
?>

<div class="container-fluid minheight100">
	<div class="row no-gutter">
		<div class="bg-custom-dark">
			<div class="register-register d-flex align-items-center py-5">
				<div class="container">
					<div class="row">
						<div class="col-lg-10 col-xl-7 mx-auto">


							<h3 class="display-4 text-white">Registrierung</h3>

							<?php 
							if(isset($error_msg) && !empty($error_msg)) {
								echo $error_msg;
							}
							?>
							<p class="text-white mb-4">Herzlich Willkommen!</p>

							<form action="?register=1" method="post">

								<div class="form-group mb-3">
									<label for="inputVorname" class="custom-control-label text-white">Vorname:</label>
									<input placeholder="Max" type="text" value="<?=$_POST["vorname"]?>" id="inputVorname" size="40" maxlength="250" name="vorname" class="form-control border-0 shadow-sm px-4 text-dark fw-bold" required>
								</div>
								<div class="form-group mb-3">
									<label for="inputNachname" class="custom-control-label text-white">Nachname:</label>
									<input placeholder="Mustermann" type="text" value="<?=$_POST["nachname"]?>" id="inputNachname" size="40" maxlength="250" name="nachname" class="form-control border-0 shadow-sm px-4 text-dark fw-bold" required>
								</div>
								<div class="form-group mb-3">
									<label for="inputEmail" class="custom-control-label text-white">E-Mail:</label>
									<input placeholder="max@mustermann.de" type="email" value="<?=$_POST["email"]?>" id="inputEmail" size="40" maxlength="250" name="email" class="form-control border-0 shadow-sm px-4 text-dark fw-bold" required>
								</div>
								<div class="form-group mb-3">
									<label for="inputPasswort" class="custom-control-label text-white">Dein Passwort:</label>
									<input placeholder="Passwort" type="password" value="<?=$_POST["passwort"]?>" id="inputPasswort" size="40"  maxlength="250" name="passwort" class="form-control border-0 shadow-sm px-4 text-dark fw-bold" required>
								</div>
								<div class="form-group mb-3">
									<label for="inputPasswort2" class="custom-control-label text-white">Passwort wiederholen:</label>
									<input placeholder="Passwort wiederholen" type="password" id="inputPasswort2" size="40" maxlength="250" name="passwort2" class="form-control border-0 shadow-sm px-4 text-dark fw-bold" required>
								</div>

								<div class="custom-control custom-checkbox mb-3">
									<input type="checkbox" id="customCheck1" name="dsgvo" value="gelesen" class="custom-control-input" required> 
									<label for="customCheck1" class="custom-control-label text-white">Ich habe die <a href="dsgvo.php">Datenschutzerklärung</a> gelesen und akzeptiere diese.</label>
								</div>
								<div class="custom-control custom-checkbox mb-3">
									<input type="checkbox" id="customCheck2" name="agb" value="gelesen" class="custom-control-input" required> 
									<label for="customCheck2" class="custom-control-label text-white"> Ich habe die <a href="agb.php">AGBs</a> gelesen und akzeptiere diese.</label>		
								</div>
								<button type="submit" class="btn btn-outline-primary btn-block text-uppercase mb-2 shadow-sm">Registrieren</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 
<?php
} //Ende von if($showFormular)
	

?>
<?php 
include_once("templates/footer.php")
?>
