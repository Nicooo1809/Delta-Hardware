<?php
require_once("php/mysql.php");
require_once("php/functions.php");
include("templates/header.php");

//Überprüfe, dass der User eingeloggt ist
//Der Aufruf von check_user() muss in alle internen Seiten eingebaut sein
$user = check_user();
?>

<div class="container minheight100 py-4 px-3">
	<div class="row no-gutter">
		<div class="card bg-dark mx-auto">
			<div class="card-body text-center">
				<h1 class="card-title name">Herzlich Willkommen!</h1>
				<span class="card-text">
					Hallo <?=$user['vorname']?>,<br>
					Herzlich Willkommen im internen Bereich!<br>
				</span>
				<button type="button" href="logout.php" class="py-2 btn btn-outline-primary">Abmelden</button>
			</div>
		</div>
	</div>
	<div>

	</div>
</div>
<?php 
include_once("templates/footer.php")
?>
