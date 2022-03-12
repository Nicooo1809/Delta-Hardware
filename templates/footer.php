<div class="alert text-center cookiealert" role="alert">
    <b>Magst du Kekse?</b> &#x1F36A; Wir verwenden Cookies um dir ein großartiges Website-Erlebnis zu bieten.

    <a href="/cookies.php">
    <button type="button" class="btn btn-outline-primary btn-sm ms-3 me-3" data-bs-toggle="modal" data-bs-target="#cookieModal">
        Mehr erfahren
    </button>
    </a>

    <div class="vr"></div>
    <button type="button" class="btn btn-primary btn-sm acceptcookies ms-3">
        Ich stimme zu
    </button>
</div>

<script src="/js/cookies.js"></script>


<?php
$vernum = "0.0.7";
# Like this, cause we want the Date the current Version was developed, not the current dates
$verdate ="12.03.2022";
#$verdate = date("d.m.Y");
if(!isMobile()):
?>
    <footer class="container-fluid footer-footer sticky-bottom footer py-3 cbg">
        <div class="row">
            <div class="col ctext">
                Delta-Hardware
            </div>
            <div class="col text-center">
                <a href="/aboutus.php" class="ctext">Über uns</a>
            </div>
            <div class="col-3">
                <input class="styleswitcher" type="checkbox" name="switch" id="switch">
                <label class="styleswitcherlabel" for="switch"></label>
            </div>
            <div class="col-3 text-end ctext">
                Version <?=$vernum?> 
                <div class="vr mx-1"></div>
                <?=$verdate?>
            </div>
        </div>
    </footer>

<?php else:?>
    <footer class="container-fluid footer-footer sticky-bottom footer py-1 cbg">
        <div class="ctext">
            <div class="col py-1 text-center">
                <a href="aboutus.php" class="ctext">Über uns</a>
            </div>
            <div class="ctext col py-1 text-center">
                Version <?=$vernum?> - <?=$verdate?>
            </div>
        </div>
    </footer>
<?php endif;?>

</body>
</html>