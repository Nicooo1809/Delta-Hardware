<?php 
require_once("templates/header.php");
?>

<div class="modal fade" id="cookieModal" tabindex="-1" aria-labelledby="cookieModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
            <div class="modal-header bg-dark">
                <h4 class="modal-title text-white fw-bold" id="cookieModalLabel">Mhhh Lecker &#x1F36A;!</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body text-white bg-dark fw-normal">
                <div class="px-2">
                    <h4 class="fw-bold">Wir verwenden Cookies um folgende Funktion bereitzustellen:</h4>
                    <br>
                    <p class="fs-5 cookie-p-text">- Speichern der PHP-Session</p>
                    <p class="fs-5 cookie-p-text">- Angemeldet bleiben</p>
                    <p class="fs-5 cookie-p-text mb-1">- Speichern der Cookie-Einstellung</p>
                    <br>
                    <p class="fw-light fs-6 cookie-p-text">Ihre Cookie-Einstellung wird gespeichert.</p>
                </div>
            </div>
            <div class="modal-footer text-white bg-dark fw-bold">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>
<div class="minheight100">
</div>
<!--
<div class="bg-image" id="start-img">

</div>
-->

<?php
include_once("templates/footer.php")
?>
