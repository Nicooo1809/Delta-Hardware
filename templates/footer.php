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
            <div class="col d-flex justify-content-end align-items-center text-end ctext">
                <input onchange="switch_style()" class="styleswitcher" type="checkbox" name="switch" id="style_switch" <?php if (check_style() == "dark") {print("checked");}?>>
                <label class="styleswitcherlabel" for="style_switch"></label>
                <script>
                    function switch_style() {
                        if(isset($_COOKIE['style'])) {
                            if ($_COOKIE['style'] == 'dark') {
                                setcookie("style",'light',time() + (3600*24*365));
                            } else if ($_COOKIE['style'] == 'light') {
                                setcookie("style",'dark',time() + (3600*24*365));
                            }
                        } else {
                            setcookie("style",'dark',time() + (3600*24*365));
                        }
                    }
                </script>
                <div class="ps-3 text-end ctext">
                    Version <?=$vernum?> 
                    <div class="vr mx-1"></div>
                    <?=$verdate?>
                </div>
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