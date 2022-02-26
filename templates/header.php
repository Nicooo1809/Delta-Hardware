<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="icon" type="image/png" href="favicon.png" sizes="1024x1024" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3386a0b16e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Delta-Hardware</title>
</head>
<body>




<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid me-3 ms-3">
        <a class="navbar-brand" href="/index"><img src="/favicon.svg" style="width:2.5rem;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="#">Katalog</a>
                </li>

                <!--PC Komponenten Dropdown-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        PC
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Arbeitsspeicher</a></li>
                        <li><a class="dropdown-item" href="#">CPUs</a></li>
                        <li><a class="dropdown-item" href="#">CPU Kühler</a></li>
                        <li><a class="dropdown-item" href="#">Festplatten & SSDs</a></li>
                        <li><a class="dropdown-item" href="#">Grafikkarten</a></li>
                        <li><a class="dropdown-item" href="#">Laufwerke</a></li>
                        <li><a class="dropdown-item" href="#">Mainboards</a></li>
                        <li><a class="dropdown-item" href="#">Netzteile</a></li>
                        <li><a class="dropdown-item" href="#">Gehäuse</a></li>
                        <li><a class="dropdown-item" href="#">Lüfter</a></li>
                        <li><a class="dropdown-item" href="#">Wasserkühlung</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">SONDERANGEBOT - RTX 3080ti</a></li>
                    </ul>
                </li>

                <!--Server Komponenten Dropdown-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Server
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="#">Server Festplatten</a></li>
                        <li><a class="dropdown-item" href="#">Server Gehäuse</a></li>
                        <li><a class="dropdown-item" href="#">Server Mainboard</a></li>
                        <li><a class="dropdown-item" href="#">Server Prozessor</a></li>
                        <li><a class="dropdown-item" href="#">Server SSDs</a></li>
                        <li><a class="dropdown-item" href="#">Serverkühlung</a></li>
                        <li><a class="dropdown-item" href="#">Serverschrank</a></li>
                        <li><a class="dropdown-item" href="#">Redundantes Netzteil</a></li>
                        <li><a class="dropdown-item" href="#">R-DIMM</a></li>
                        <li><a class="dropdown-item" href="#">ECC Ram</a></li>
                    </ul>
                </li>



                <!--Monitore Komponenten Dropdown-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Monitore
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="#">Ultrawide</a></li>
                        <li><a class="dropdown-item" href="#">WQHD</a></li>
                        <li><a class="dropdown-item" href="#">4K</a></li>
                        <li><a class="dropdown-item" href="#">Curved</a></li>
                        <li><a class="dropdown-item" href="#">Gaming</a></li>
                        <li><a class="dropdown-item" href="#">Touchscreen</a></li>
                        <li><a class="dropdown-item" href="#">24 Zoll</a></li>
                        <li><a class="dropdown-item" href="#">27 Zoll</a></li>
                        <li><a class="dropdown-item" href="#">32 Zoll</a></li>
                        <li><a class="dropdown-item" href="#">34 Zoll</a></li>
                        <li><a class="dropdown-item" href="#">49 Zoll</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Monitorzubehör</a></li>
                    </ul>
                </li>


                <!--Eingabegeräte Komponenten Dropdown-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Eingabegeräte
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="#">Office-Mäuse</a></li>
                        <li><a class="dropdown-item" href="#">Gaming-Mäuse</a></li>
                        <li><a class="dropdown-item" href="#">Mauspads</a></li>
                        <li><a class="dropdown-item" href="#">Office-Tastaturen</a></li>
                        <li><a class="dropdown-item" href="#">Gaming-Tastaturen</a></li>
                        <li><a class="dropdown-item" href="#">Joystick</a></li>
                        <li><a class="dropdown-item" href="#">Länkräder</a></li>
                        <li><a class="dropdown-item" href="#">Controller</a></li>
                    </ul>
                </li>


                <!--Netzwerktechnik Komponenten Dropdown-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Netzwerktechnik
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="#">Access-Points</a></li>
                        <li><a class="dropdown-item" href="#">Bluetooth Adapter</a></li>
                        <li><a class="dropdown-item" href="#">Netzwerkswitches</a></li>
                        <li><a class="dropdown-item" href="#">Gaming-Tastaturen</a></li>
                        <li><a class="dropdown-item" href="#">Router</a></li>
                        <li><a class="dropdown-item" href="#">USB-Hubs</a></li>
                        <li><a class="dropdown-item" href="#">WLAN Repeater</a></li>
                    </ul>
                </li>



                <!--Audio Komponenten Dropdown-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Audio
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="#">Headsets</a></li>
                        <li><a class="dropdown-item" href="#">Kopfhörer</a></li>
                        <li><a class="dropdown-item" href="#">Mikrofone</a></li>
                        <li><a class="dropdown-item" href="#">Lautsprecher</a></li>
                        <li><a class="dropdown-item" href="#">Soundbar</a></li>
                        <li><a class="dropdown-item" href="#">Soundkarten</a></li>
                    </ul>
                </li>
            </ul>

            <form class="d-flex mb-2 mt-1" action="search.php">
                <input class="form-control me-2" name="search" type="search" placeholder="Suchen" aria-label="Suche">
                <button class="btn btn-outline-primary me-4" type="submit">Suchen</button>
            </form>

            </i>


            
            <?php 
            /*
            $anmeldentext  = "Anmelden";
            $profiltext = "Profil";
            if(isset($_SESSION['userid']))
            {
                $output = $profiltext;
            }
            else
            {
                $output = $anmeldentext;
            }
            */
            ?>

            <a class="icon-navbar-a" href="<?php if(isset($_SESSION['userid'])) {print("settings.php");} else {print("login.php");} ?>"><i class="fa-solid fa-user me-2 mt-2" id="user-icon-navbar"></i></a>
            <a class="icon-navbar-a" href="#WARENKORB"><i class="fa-solid fa-cart-shopping me-2 ms-4 mt-2" id="user-icon-navbar"></i></a>
            <a class="icon-navbar-a" href="#HILFE"><i class="fa-solid fa-circle-info me-2 ms-4 mt-2" id="user-icon-navbar"></i></a>

        
                
            </ul>
        </div>
    </div>
</nav>


<!--
</body>
</html>
-->