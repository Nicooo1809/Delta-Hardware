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
















<main>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner carousel-vh">
            <div class="carousel-item active">
                <img src="/media/bg-img.jpg" class="d-block w-100" alt="NEW RTX">
                <div class="carousel-caption d-none d-md-block">
                    <div class="col-md-12 mt-1 white-text text-center">
                        <h1 class="h1-reponsive white-text text-uppercase font-weight-bold mb-0 pt-md-5 pt-5"><strong>Die Neue RTX 3070 Ti</strong></h1>   
                        <hr class="hr-light my-3">
                        <h5 class="text-uppercase mb-4 white-text"><strong>Jetzt kaufen!</strong></h5>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/media/bg-img.jpg" class="d-block w-100" alt="RTX2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Vorherige</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Nächste</span>
        </button>
    </div>


<!--
    <div class="view bg">
        <div class="mask rgba-black-light align-items-center">
            <div class="container">
                <div class="row minimum-vh justify-content-center align-items-center">
                    <div class="col-md-12 mt-1 white-text text-center">
                        <h1 class="h1-reponsive white-text text-uppercase font-weight-bold mb-0 pt-md-5 pt-5"><strong>Die Neue RTX 3070 Ti</strong></h1>   
                        <hr class="hr-light my-3">
                        <h5 class="text-uppercase mb-4 white-text"><strong>Jetzt kaufen!</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
-->
</main>








<!--
<div class="bg-image" id="start-img">

</div>
-->

<?php
include_once("templates/footer.php")
?>
