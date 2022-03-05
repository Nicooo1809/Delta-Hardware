<div class="alert text-center cookiealert" role="alert">
    <b>Magst du Kekse?</b> &#x1F36A; Wir verwenden Cookies um dir ein großartiges Website-Erlebnis zu bieten. <a href="/cookies" target="_blank">Mehr erfahren</a>
  
    <button type="button" class="btn btn-primary btn-sm acceptcookies">
        Ich stimme zu
    </button>
</div>
  
<script src="/js/cookies.js"></script>

<?php
$vernum = "0.0.4";
$verdate ="05.03.2022";
function isMobile () {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
if(!isMobile()):
?>
    <footer class="footer fixed-bottom py-3 bg-dark">
        <div class="container-fluid">
            <div class="row text-white">
                <div class="col">
                    Delta-Hardware
                </div>
                <div class="col text-center">
                    <a href="aboutus.php" class="text-white">Über uns</a>
                </div>
                <div class="col me-2 text-end">
                    Version <?=$vernum?> - <?=$verdate?>
                </div>
            </div>
        </div>
    </footer>

<?php else:?>
    <footer class="footer fixed-bottom py-1 bg-dark">
        <div class="container-fluid">
            <div class="text-white">
                <div class="col my-1 text-center">
                    <a href="aboutus.php" class="text-white">Über uns</a>
                </div>
                <div class="col my-1 text-center">
                    Version <?=$vernum?> - <?=$verdate?>
                </div>
            </div>
        </div>
    </footer>
<?php endif;?>

</body>
</html>