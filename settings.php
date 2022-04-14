<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
if(isset($_GET['save'])) {
	$save = $_GET['save'];
	
	if($save == 'personal_data') {
		$vorname = trim($_POST['vorname']);
		$nachname = trim($_POST['nachname']);
		
		if($vorname == "" || $nachname == "") {
			$error_msg = "Bitte Vor- und Nachname ausfüllen.";
		} else {
			$stmt = $pdo->prepare("UPDATE users SET vorname = ?, nachname = ?, updated_at=NOW() WHERE id = ?");
			$stmt->bindValue(1, $vorname);
			$stmt->bindValue(2, $nachname);
			$stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
			$result = $stmt->execute();
			$user['vorname'] = $vorname;
			$user['nachname'] = $nachname;

			echo("<script>location.href='settings.php'</script>");
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
			$stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
			$stmt->bindValue(1, $email);
			$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
			$result = $stmt->execute();
			$user['email'] = $email;
			
			echo("<script>location.href='settings.php'</script>");
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
				
			$stmt = $pdo->prepare("UPDATE users SET passwort = ? WHERE id = ?");
			$stmt->bindValue(1, $passwort_hash);
			$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
			$result = $stmt->execute();
				
			echo("<script>location.href='settings.php'</script>");
		}
	} else if($save == 'address') {
		$street = $_POST['strasse'];
		$city = $_POST['stadt'];
		
		if($street == "" || $city == "") {
			$error_msg = "Bitte Addresse eintragen.";
		} else {
			$stmt = $pdo->prepare("UPDATE users SET streetHouseNr = ?, city = ?, updated_at=NOW() WHERE id = ?");
			$stmt->bindValue(1, $street);
			$stmt->bindValue(2, $city);
			$stmt->bindValue(3, $user['id'], PDO::PARAM_INT);
			$result = $stmt->execute();
			$user['streetHouseNr'] = $street;
			$user['city'] = $city;

			echo("<script>location.href='settings.php'</script>");
		}
	}
}
?>

<div class="container minheight100 py-2 px-2">
	<div class="row no-gutter">
		<!-- will do somethinge else for error/success_msg later -->
		<?php if(isset($error_msg) && !empty($error_msg)) {echo $error_msg;}?>

		<!-- Persönliche Daten Card -->
		<div class="card cbg ctext my-2 mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title">Persönliche Daten</h1>
				<div class="card-text">
					<div class="row justify-content-between">
						<!-- Name -->
						<div class="cvl col-6">
							<h3 class="ctext">Name</h3>
							<form action="?save=personal_data" method="post">
								<div class="form-floating mb-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputVorname" placeholder="Vorname" name="vorname" type="text" value="<?=$user['vorname']?>" required>
									<label class="text-dark fw-bold" for="inputVorname">Vorname</label>
								</div>
								<div class="form-floating my-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputNachname" placeholder="Nachname" name="nachname" type="text" value="<?=$user['nachname']?>" required>
									<label class="text-dark fw-bold" for="inputNachname">Nachname</label>
								</div>
								<button class="btn btn-outline-primary" type="submit">Speichern</button>
							</form>
						</div>
						<!-- Adresse -->
						<div class="col-6">
							<h3 class="ctext">Adresse</h3>
							<form action="?save=address" method="post">
								<div class="form-floating mb-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputStrasse" placeholder="Straße und Hausnummer" name="strasse" type="text" value="<?=$user['streetHouseNr']?>" required>
									<label class="text-dark fw-bold" for="inputStrasse">Straße und Hausnummer</label>
								</div>
								<div class="form-floating my-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputStadt" placeholder="Stadt" name="stadt" type="text" value="<?=$user['city']?>" required>
									<label class="text-dark fw-bold" for="inputStadt">Stadt mit Postleitzahl</label>
								</div>
								<button class="btn btn-outline-primary" type="submit">Speichern</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- E-Mail und Password Card -->
		<div class="card cbg ctext my-2 mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title">Sicherheit</h1>
				<div class="card-text">
					<div class="row justify-content-between">
						<div class="cvl col-6">
							<!-- E-Mail -->
							<h3 class="ctext">E-Mail-Adresse</h3>
							<form action="?save=email" method="post">
								<div class="form-floating mb-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputPasswort" placeholder="Passwort" name="passwort" type="password" required>
									<label class="text-dark fw-bold" for="inputPasswort">Passwort</label>
								</div>
								<div class="form-floating my-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputEmail" placeholder="E-Mail" name="email" type="email" value="<?=$user['email']?>" required>
									<label class="text-dark fw-bold" for="inputEmail">E-Mail</label>
								</div>
								<div class="form-floating my-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputEmail2" placeholder="E-Mail wiederholen" name="email2" type="email" required>
									<label class="text-dark fw-bold" for="inputEmail2">E-Mail wiederholen</label>
								</div>
								<button class="btn btn-outline-primary" type="submit">Speichern</button>
							</form>
						</div>
						<!-- Passwort -->
						<div class="col-6">
							<h3 class="ctext">Passwort</h3>
							<form>
								<div class="form-floating mb-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputPasswort" placeholder="Altes Passwort" name="passwortAlt" type="password" required>
									<label class="text-dark fw-bold" for="inputPasswort">Altes Passwort</label>
								</div>
								<div class="form-floating my-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputPasswortNeu" placeholder="Neues Passwort" name="passwortNeu" type="password" required>
									<label class="text-dark fw-bold" for="inputPasswortNeu">Neues Passwort</label>
								</div>
								<div class="form-floating my-2">
									<input class="form-control border-0 ps-4 text-dark fw-bold" id="inputPasswortNeu2" placeholder="Neues Passwort wiederholen" name="passwortNeu2" type="password"  required>
									<label class="text-dark fw-bold" for="inputPasswortNeu2">Neues Passwort wiederholen</label>
								</div>
								<button class="btn btn-outline-primary" type="submit">Speichern</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<?php 
include_once("templates/footer.php")
?>
