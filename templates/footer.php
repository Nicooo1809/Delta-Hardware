<div class="alert text-center cookiealert" role="alert">
    <b>Magst du Kekse?</b> &#x1F36A; Wir verwenden Cookies um dir ein großartiges Website-Erlebnis zu bieten.
  
    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cookieModal">
        Mehr erfahren
    </button>
    
    <button type="button" class="btn btn-primary btn-sm acceptcookies">
        Ich stimme zu
    </button>
</div>

<script src="/js/cookies.js"></script>


<?php
$vernum = "0.0.6";
# Like this, cause we want the Date the current Version was developed, not the current dates
$verdate ="08.03.2022";
#$verdate = date("d.m.Y");
if(!isMobile()):
?>
    <footer class="container-fluid footer-footer sticky-bottom footer py-3 bg-dark">
        <div class="row text-white">
            <div class="col">
                Delta-Hardware
            </div>
            <div class="col text-center">
                <a href="aboutus.php" class="text-white">Über uns</a>
            </div>
            <div class="col text-end">
                Version <?=$vernum?> - <?=$verdate?>
            </div>
        </div>
    </footer>

<?php else:?>
    <footer class="container-fluid footer-footer sticky-bottom footer py-1 bg-dark">
        <div class="text-white">
            <div class="col py-1 text-center">
                <a href="aboutus.php" class="text-white">Über uns</a>
            </div>
            <div class="col py-1 text-center">
                Version <?=$vernum?> - <?=$verdate?>
            </div>
        </div>
    </footer>
<?php endif;?>

</body>
</html>