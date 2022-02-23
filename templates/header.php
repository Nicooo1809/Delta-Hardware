<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="favicon.png" sizes="1024x1024" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/3386a0b16e.js" crossorigin="anonymous"></script>
    <title>Delta-Hardware</title>
</head>

<body>

    <div class="header">
        <a href="index.php"><img class="logo-topleft" src="favicon.svg" data-aos="fade-down" data-aos-duration="1300" data-aos-delay="100"></a>
        <a data-aos="fade-down" data-aos-duration="1300" data-aos-delay="100">Delta 
        Hardware</a>
        <a href="<?php if(isset($_SESSION['userid'])) {print("settings.php");} else {print("login.php");} ?>"><img class="profile-icon" src="images/profile-icon-darkmode.png" atl="Profil" data-aos="fade-down" data-aos-duration="1300" data-aos-delay="100"></a>
        
        <a href="javascript:void(0);" class="expandicon" onclick="ResponsiveFunction()" id="expandcollapseicon" data-aos="fade-down" data-aos-duration="1300" data-aos-delay="100"><img class="OpenCloseNavBarIcon" src="images/expand-icon-darkmode.png" atl="Dropdown"></a>
    </div>

    <div class="navbar" id="myTopnav">
        <a class="navlink" href="pc/home" data-aos="fade-down" data-aos-duration="500" data-aos-delay="100">PC Komponenten</a>
        <a class="navlink" href="pc/grafikkarten" data-aos="fade-down" data-aos-duration="500" data-aos-delay="200">Server Komponenten</a>
        <a class="navlink" href="template" data-aos="fade-down" data-aos-duration="500" data-aos-delay="300">Monitore</a>
        <a class="navlink" href="template" data-aos="fade-down" data-aos-duration="500" data-aos-delay="400">Eingabegeräte</a>
        <a class="navlink" href="#" data-aos="fade-down" data-aos-duration="500" data-aos-delay="500">Drucker</a>
        <a class="navlink" href="#" data-aos="fade-down" data-aos-duration="500" data-aos-delay="600">Netzwerktechnik</a>
        <a class="navlink" href="#" data-aos="fade-down" data-aos-duration="500" data-aos-delay="700">Audio</a>
        <a class="navlink" href="#" data-aos="fade-down" data-aos-duration="500" data-aos-delay="800">Peripherie</a>
        <a class="navlink" href="#" data-aos="fade-down" data-aos-duration="500" data-aos-delay="900">Kabel & Adapter</a>
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





    
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    AOS.init();
</script>


</body>
</html>
