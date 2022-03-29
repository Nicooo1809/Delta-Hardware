<?php
require_once("php/functions.php");
$user = require_once("templates/header.php");
//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
#error_log(print_r($user,true));
if (!isset($user['id'])) {
    require_once("login.php");
    exit;
}
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
				<div class="card-text">
					<a href="logout.php"><button type="button" class="btn btn-outline-primary mx-2 my-2">Abmelden</button></a>
					<a href="settings.php"><button type="button" class="btn btn-outline-primary mx-2 my-2">Einstellungen</button></a>
				</div>
			</div>
		</div>
		<?php if ($user['showUser'] == 1 or $user['showUserPerms'] == 1 or $user['showCategories'] == 1 or $user['showProduct'] == 1) { ?>
		<div class="card cbg ctext my-3 mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title">Adminbereich</h1>
				<div class="card-text">
					<?php
						if ($user['showUser'] == 1) {
							print('<a href="user.php"><button class="btn btn-outline-primary mx-2 my-2" type="button">Benutzer</button></a>');
						} 
						if ($user['showUserPerms'] == 1) {
							print('<a href="perms.php"><button class="btn btn-outline-primary mx-2 my-2" type="button">Berechtigungen</button></a>');
						}
						if ($user['showCategories'] == 1) {
							print('<a href="categories.php"><button class="btn btn-outline-primary mx-2 my-2" type="button">Kategorien</button></a>');
						}
						if ($user['showProduct'] == 1) {
							print('<a href="produc.php"><button class="btn btn-outline-primary mx-2 my-2" type="button">Produkte</button></a>');
						}
					?>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if ($user['showOrders'] == 1) { ?>
		<div class="card cbg ctext my-3 mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title">Bestellungen</h1>
				<div class="card-text">
					<?php
						# foreach
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
