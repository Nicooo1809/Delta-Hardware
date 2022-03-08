<div class="alert text-center cookiealert" role="alert">
    <b>Magst du Kekse?</b> &#x1F36A; Wir verwenden Cookies um dir ein großartiges Website-Erlebnis zu bieten. <a href="/cookies" target="_blank">Mehr erfahren</a>
  
    <button type="button" class="btn btn-primary btn-sm acceptcookies">
        Ich stimme zu
    </button>
</div>
  
<script src="/js/cookies.js"></script>


<?php
$vernum = "0.0.4";
$verdate ="08.03.2022";
if(!isMobile()):
?>
    <div class="container-fluid py-3" style="height: 59px;">
        <div class="row text-white">
        </div>
    </div>
    <footer class="container-fluid fixed-bottom footer py-3 bg-dark">
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
    <div class="container-fluid py-1" style="height: 75px;"></div>
    <footer class="container-fluid fixed-bottom footer py-1 bg-dark">
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