<?php 
require_once("templates/header.php");
?>

<main>
    <div class="view bg">
        <div class="mask rgba-black-light align-items-center">
            <div class="container">
                <div class="d-flex flex-row minimum-vh justify-content-start align-items-center">
                    <div class="col-md-12 mt-1 text-white text-start">
                        <h1 class="h1-reponsive text-white text-uppercase font-weight-bold mb-0 pt-md-5 pt-5"><strong class="text-white">Die Neue RTX-Reihe</strong></h1>   
                        <hr class="hr-light my-3">
                        <h5 class="text-uppercase mb-4 text-white"><strong href="products.php?search=rtx" class="text-white">Jetzt kaufen!</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="newproductcarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">

                <div class="row">
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                </div>

            </div>
            <div class="carousel-item">

                <div class="row">
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                </div>

            </div>
            <div class="carousel-item">

                <div class="row">
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                    <div class="col-sm">
                    One of three columns
                    </div>
                </div>
                
            </div>
        </div>
        <a class="carousel-control-prev" href="#newproductcarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#newproductcarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


</main>




<?php
include_once("templates/footer.php")
?>
