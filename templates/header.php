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
    <div class="container-fluid">
        <a class="navbar-brand" href="/index">Delta-Hardware</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Test</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Test1</a></li>
                        <li><a class="dropdown-item" href="#">Test2</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Never gonna give you up</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex" action="search.php">
                <input class="form-control me-2" name="search" type="search" placeholder="Grafikkarte..." aria-label="Suche">
                <button class="btn btn-outline-success" type="submit">Suchen</button>
            </form>
            </i>
            <i class="bi-person-fill" style="font-size: 2rem; color: #ffffff;"><a href="<?php if(isset($_SESSION['userid'])) {print("settings.php");} else {print("login.php");} ?>"></i>
        </div>
    </div>
</nav>




<!--

    <div class="header">
        <a href="index.php"><img class="logo-topleft" src="favicon.svg"></a>
        <a>Delta 
        Hardware</a>
        <a href="<?php if(isset($_SESSION['userid'])) {print("settings.php");} else {print("login.php");} ?>"><img class="profile-icon" src="images/profile-icon-darkmode.png" atl="Profil" data-aos="fade-down" data-aos-duration="1300" data-aos-delay="100"></a>
        
        <a href="javascript:void(0);" class="expandicon" onclick="ResponsiveFunction()" id="expandcollapseicon"><img class="OpenCloseNavBarIcon" src="images/expand-icon-darkmode.png" atl="Dropdown"></a>
    </div>

    <div class="navbar" id="myTopnav">
        <a class="navlink" href="pc/home">PC Komponenten</a>
        <a class="navlink" href="pc/grafikkarten">Server Komponenten</a>
        <a class="navlink" href="template">Monitore</a>
        <a class="navlink" href="template">Eingabegeräte</a>
        <a class="navlink" href="#">Drucker</a>
        <a class="navlink" href="#">Netzwerktechnik</a>
        <a class="navlink" href="#">Audio</a>
        <a class="navlink" href="#">Peripherie</a>
        <a class="navlink" href="#">Kabel & Adapter</a>
    </div>


    <script>
        function ResponsiveFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className == "navbar") {
                x.className = "responsive";
            } else {
                x.className = "navbar";
            }
        }

        
    </script>




</body>
</html>
    -->