<?php
require_once("php/mysql.php");
require_once("php/functions.php");
include("templates/header.php");

//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
$user = check_user();
?>

<div class="container minheight100 py-3 px-3">
	<div class="row no-gutter">
		<div class="card cbg ctext my-3 mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title name">Herzlich Willkommen!</h1>
				<span class="card-text">
					Hallo <?=$user['vorname']?>,<br>
					Herzlich Willkommen im internen Bereich!<br>
				</span>
				<button type="button" href="logout.php" class="btn btn-outline-primary my-3">Abmelden</button>
			</div>
		</div>
		<?php if ($user['showUser'] == 1 and $user['showUserPerms'] == 1) { ?>
		<div class="card cbg ctext my-3 mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title">Adminbereich</h1>
				<div class="card-text">
					<?php
						if ($user['showUser'] == 1) {
							print('<a href="/user.php"><button class="btn btn-outline-primary mx-2" type="submit">Benutzer</button></a>');
						
						} 
						if ($user['showUserPerms'] == 1) {
							print('<a href="/perms.php"><button class="btn btn-outline-primary mx-2" type="submit">Berechtigungen</button></a>');
						}
					?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div>

	</div>
</div>
<?php 
include_once("templates/footer.php")
?>
