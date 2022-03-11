<div class="alert text-center cookiealert" role="alert">
    <b>Magst du Kekse?</b> &#x1F36A; Wir verwenden Cookies um dir ein großartiges Website-Erlebnis zu bieten.
  

    <button type="button" class="btn btn-outline-primary btn-sm ms-3 me-3" data-bs-toggle="modal" onclick="window.location.href = https://de.w3docs.com;" data-bs-target="#cookieModal">
        Mehr erfahren
    </button>
    <div class="vr"></div>
    <button type="button" class="btn btn-primary btn-sm acceptcookies ms-3">
        Ich stimme zu
    </button>
</div>

<script src="/js/cookies.js"></script>


<?php
$vernum = "0.0.7";
# Like this, cause we want the Date the current Version was developed, not the current dates
$verdate ="11.03.2022";
#$verdate = date("d.m.Y");
if(!isMobile()):
?>
    <footer class="container-fluid footer-footer sticky-bottom footer py-3 bg-dark">
        <div class="row">
            <div class="col">
                Delta-Hardware
            </div>
            <div class="col text-center">
                <a href="/aboutus.php" class="text-white">Über uns</a>
            </div>
            <div class="col text-end">
                Version <?=$vernum?> 
                <div class="vr mx-1"></div>
                 <?=$verdate?>
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