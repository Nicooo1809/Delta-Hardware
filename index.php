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
            <div class="modal-body text-white bg-dark fw-normal">
                <div class="px-2">
                    <li>Das speichern der PHP Session</li>
                    <li>Login Remember me Funktion</li>
                    <li>Das Speichern der Cookie Einstellung</li>
                </div>
            </div>
            <div class="modal-footer text-white bg-dark fw-bold">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>

<!--
<div class="bg-image" id="start-img">

</div>
-->

<?php
include_once("templates/footer.php")
?>
