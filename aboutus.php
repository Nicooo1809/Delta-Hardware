<?php 
require_once("templates/header.php");
?>

<?php
if(!isMobile()):
?>

<!-- Desktop Devices -->
<div class="mx-auto my-5 py-3 px-5 text-center rounded bg-dark" style="width: 55%;">
    <div class="text-white">
        <h1>Wer sind wir?</h1>
        <p>
            Wir sind Schüler*innen der <a href="https://its-stuttgart.de/">it.schule</a> Stuttgart.<br>
            Genau genommen sind wir die Projektgruppe Delta, welche an der erstellung eines Hardware Webshops arbeitet. <br>
            Dieser Webshop wird das Produkt unserer BfK-S Projektarbeit in der Klasse E2FS3BT sein.
        </p>
    </div>
</div>

<!-- Mobile Devices -->
<?php else:?>
    <div class="mx-auto my-5 py-2 px-3 text-center rounded bg-dark" style="width: 90%;">
    <div class="text-white">
        <h1>Wer sind wir?</h1>
        <p>
            Wir sind Schüler*innen der <a href="https://its-stuttgart.de/">it.schule</a> Stuttgart.<br>
            Genau genommen sind wir die Projektgruppe Delta, welche an der erstellung eines Hardware Webshops arbeitet. <br>
            Dieser Webshop wird das Produkt unserer BfK-S Projektarbeit in der Klasse E2FS3BT sein.
        </p>
    </div>
</div>
<?php endif;?>


<?php
include_once("templates/footer.php")
?>