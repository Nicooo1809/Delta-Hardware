<?php 
require_once("templates/header.php");
?>

<?php
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobile()):
?>
<div class="mx-auto py-5 text-center rounded bg-dark" style="width: 90%;">
    <div class="text-white">
        <h1>Wer sind wir?</h1>
        <p>
            Wir sind Schüler der Berufsschule <a href="https://its-stuttgart.de/">it.schule Stuttgart</a>.
            Um genau zu sein sind wir die Projektgruppe Delta, diese Webseite stellt unser BfK-S Projekt für die Klasse E2FS3BT dar.
        </p>
    </div>
</div>
<?php else:?>
    <div class="mx-auto py-5 text-center rounded bg-dark" style="width: 55%;">
    <div class="text-white">
        <h1>Wer sind wir?</h1>
        <p>
            Wir sind Schüler der Berufsschule <a href="https://its-stuttgart.de/">it.schule Stuttgart</a>.
            Um genau zu sein sind wir die Projektgruppe Delta, diese Webseite stellt unser BfK-S Projekt für die Klasse E2FS3BT dar.
        </p>
    </div>
</div>




<?php endif;?>
<?php
require_once("templates/footer.html");
?>