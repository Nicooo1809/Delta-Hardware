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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3386a0b16e.js" crossorigin="anonymous"></script>
    <title>Delta-Hardware</title>
</head>
<body>




<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <span class="navbar-icon" href="/index"><a class="navbar-brand" href="/index">Delta-Hardware</a></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    DropdownTest
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Test1</a>
                    <a class="dropdown-item" href="#">Test2</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Never gonna give you up</a>
                </div>
            </li>
        </ul>
        <from class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Suche" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"></button>
        </from>
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