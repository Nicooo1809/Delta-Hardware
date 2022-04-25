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
			if (!$result) {
				error('Database error', pdo_debugStrParams($stmt));
			}
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
			if (!$result) {
				error('Database error', pdo_debugStrParams($stmt));
			}
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
			if (!$result) {
				error('Database error', pdo_debugStrParams($stmt));
			}
			echo("<script>location.href='settings.php'</script>");
		}
	} else if($save == 'address') {
		
		if(isset($_POST['standardaddresse']) && !empty($_POST['standardaddresse'])) {
			$error_msg = "Bitte Addresse auswählen.";
		} else {
			$stmt = $pdo->prepare("UPDATE address SET default = 0, updated_at=NOW() WHERE default = 1 and user_id = ?");
			$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
			$result = $stmt->execute();
			if (!$result) {
				error('Database error', pdo_debugStrParams($stmt));
			}
			$stmt = $pdo->prepare("UPDATE address SET default = 1, updated_at=NOW() WHERE id = ? and user_id = ?");
			$stmt->bindValue(1, $_POST['standardaddresse'], PDO::PARAM_INT);
			$stmt->bindValue(2, $user['id'], PDO::PARAM_INT);
			$result = $stmt->execute();
			if (!$result) {
				error('Database error', pdo_debugStrParams($stmt));
			}

			echo("<script>location.href='settings.php'</script>");
		}
	}
}
$stmt = $pdo->prepare('SELECT * FROM address where user_id = ?');
$stmt->bindValue(1, $user['id'], PDO::PARAM_INT);
$result = $stmt->execute();
if (!$result) {
    error('Database error', pdo_debugStrParams($stmt));
}
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
							<button class="btn btn-danger mx-1" type="button" onclick="window.location.href = '/address.php';">Abbrechen</button>
							<form action="?save=address" method="post">
								<div class="form-floating mb-2">
									<span style="width: 150px;" class="input-group-text" for="inputCategorie">Standardaddresse</span>
									<select class="form-select" id="inputStandardaddresse" name="standardaddresse">
										<?php foreach ($addresses as $address) {
											if ($address['default'] == 1) {
												print('<option class="text-dark" value="' . $address['id'] . '" selected>' . $address['street'] . ' ' . $address['number'] . ', ' . $address['citys_id'] . '</option>');
											} else {
												print('<option class="text-dark" value="' . $address['id'] . '">' . $address['street'] . ' ' . $address['number'] . ', ' . $address['citys_id'] . '</option>');
											}
										}
										?>
									</select>
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
