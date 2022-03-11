<?php 
require_once("php/mysql.php");
require_once("php/functions.php");

$error_msg = "";
if(isset($_POST['email']) && isset($_POST['passwort'])) {
	$email = $_POST['email'];
	$passwort = $_POST['passwort'];

	$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
	$result = $statement->execute(array('email' => $email));
	$user = $statement->fetch();
	#error_log(print_r($user,true));

	//Überprüfung des Passworts
	if ($user !== false && password_verify($passwort, $user['passwort'])) {
		$_SESSION['userid'] = $user['id'];

		//Möchte der Nutzer angemeldet beleiben?
		if(isset($_POST['angemeldet_bleiben'])) {
			$identifier = md5(uniqid());
			$securitytoken = md5(uniqid());
				
			$insert = $pdo->prepare("INSERT INTO securitytokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken)");
			$insert->execute(array('user_id' => $user['id'], 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
			setcookie("identifier",$identifier,time()+(3600*24*365)); //Valid for 1 year
			setcookie("securitytoken",$securitytoken,time()+(3600*24*365)); //Valid for 1 year
			#error_log(pdo_debugStrParams($insert));
		}

		header("location: internal.php");
		exit;
	} else {
		$error_msg =  "E-Mail oder Passwort war ungültig<br><br>";
	}

}


$email_value = "";
if(isset($_POST['email']))
	$email_value = htmlentities($_POST['email']); 

include("templates/header.php");
?>
<div class="container-fluid">
	<div class="row no-gutter">
		<div class="bg-custom-dark">
			<div class="minheight100 d-flex align-items-center py-5">
				<div class="container">
					<div class="row">
						<div class="col-lg-10 col-xl-7 mx-auto">
							<h3 class="display-4 ">Anmelden</h3>
							<?php 
							if(isset($error_msg) && !empty($error_msg)) {
								echo $error_msg;
							}
							?>
							<p class="text-muted mb-4">Schön, dass du wieder da bist!</p>
							
							<form action="login.php" method="post">
								<div class="form-floating mb-3">
									<input id="inputEmail" type="email" name="email" placeholder="E-Mail" value="<?php echo $email_value; ?>" autofocus class="form-control is-invalid border-0 shadow-sm ps-4 text-dark fw-bold" require>
									<label for="inputEmail" class="text-dark fw-bold">E-Mail</label>
									<label for="inputEmail">E-Mail-Adresse muss ausgefüllt sein</label>
								</div>
								<div class="form-floating mb-3">
                                    <input id="inputPassword" type="password" name="passwort" placeholder="Passwort" class="form-control is-invalid border-0 shadow-sm ps-4 text-dark fw-bold" require>
									<label for="inputPassword" class="text-dark fw-bold">Passwort</label>
									<label for="inputPassword">Passwort muss ausgefüllt sein</label>
								</div>

								<div class="custom-control custom-checkbox mb-3">
									<input value="remember-me" id="customCheck1" type="checkbox" name="angemeldet_bleiben" value="1" checked class="custom-control-input">
									<label for="customCheck1" class="custom-control-label">Angemeldet bleiben</label>
								</div>
								
								<button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 shadow-sm">Anmelden</button>
								<div class="text-center d-flex justify-content-between mt-4 "><p>Noch kein Kunde? <a href="register" class="font-italic text-muted"> 
									<u>Registrieren</u></a></p>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





<?php
/*

<div class="form-signin">
  <form action="login.php" method="post">
	<h2>Login</h2>
	
<?php 
if(isset($error_msg) && !empty($error_msg)) {
	echo $error_msg;
}
?>
	<label for="inputEmail" class="sr-only">E-Mail</label>
	<input type="email" name="email" id="inputEmail" placeholder="E-Mail" value="<?php echo $email_value; ?>" required autofocus>
	<label for="inputPassword" class="sr-only">Passwort</label>
	<input type="password" name="passwort" id="inputPassword" placeholder="Passwort" required>
	<div class="checkbox">
	  <label>
		<input type="checkbox" value="remember-me" name="angemeldet_bleiben" value="1" checked> Angemeldet bleiben
	  </label>
	</div>
	<button type="submit">Login</button>
  </form>

</div>
*/
?>



<?php 
include_once("templates/footer.php")
?>
