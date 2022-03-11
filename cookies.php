<?php 
require_once("templates/header.php");
?>


<div class="modal fade" id="cookieModal" tabindex="-1" aria-labelledby="cookieModalLabel" aria-hidden="true">
    <div class="modal-dialog cbg">
        <div class="modal-content cbg">
            <div class="modal-header cbg">
                <h4 class="modal-title ctext fw-bold" id="cookieModalLabel">Mhhh Lecker &#x1F36A;!</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body ctext cbg fw-normal">
                <div class="px-2">
                    <h4 class="fw-bold ctext">Wir verwenden Cookies um folgende Funktion bereitzustellen:</h4>
                    <br>
                    <p class="fs-5 ctext cookie-p-text">- Speichern der PHP-Session</p>
                    <p class="fs-5 ctext cookie-p-text">- Angemeldet bleiben</p>
                    <p class="fs-5 ctext cookie-p-text">- Speichern der Style-Einstellung</p>
                    <p class="fs-5 ctext cookie-p-text mb-1">- Speichern der Cookie-Einstellung</p>
                    <br>
                    <p class="fw-light fs-6 cookie-p-text ctext">Ihre Cookie-Einstellung wird gespeichert.</p>
                </div>
            </div>
            <div class="modal-footer ctext cbg fw-bold">
                <a href="/index"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zurück zur Startseite</button></a>
            </div>
        </div>
    </div>
</div>
    
<?php
include_once("templates/footer.php")
?>