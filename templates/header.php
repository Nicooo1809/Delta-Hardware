<?php
require_once("php/functions.php");
#error_log($_SESSION['userid']);
#error_log('8');
session_start();
#error_log(print_r($_SESSION['userid'],true));
#error_log($user1);
$user1 = check_user(FALSE);

#error_log($_SESSION['userid']);
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css?v=<?php print(date("Y.m.d.H.i.s")); ?>">
    <link rel="stylesheet"  href="/css/dark.css" disabled>
    <link rel="stylesheet"  href="/css/light.css" disabled>
    <link rel="icon" type="image/png" href="/favicon.png" sizes="1024x1024" />
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/3386a0b16e.js"></script>
    <script src="/js/custom.js"></script>
    <link rel="stylesheet" href="/css/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/cookiebanner.css">
    <title>Delta-Hardware</title>
</head>
<body>

<nav class="navbar header-header navbar-expand-lg navbar-<?php print(check_style());?> cbg ctext sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><img src="/favicon.svg" class="navbar-icon"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!--Dynamic from Database-->
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM products_types WHERE parent_id = 0");
                    $stmt->execute();
                    #error_log(pdo_debugStrParams($stmt));
                    $roottypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    #error_log(print_r($roottypes, true));
                    foreach ($roottypes as $roottype) {
                        $stmt = $pdo->prepare("SELECT *, (SELECT COUNT(*) FROM products WHERE products_types.id = products.product_type_id and visible = 1) as quantity FROM products_types WHERE parent_id = ?");
                        $stmt->bindValue(1, $roottype['id'], PDO::PARAM_INT);
                        $stmt->execute();
                        $subtypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (isset($subtypes[0])) {
                            #error_log('1');
                            ?>
                                <li class="nav-item dropdown">
                                <a class="nav-link ctext dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?=$roottype['type']?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php 
                        } else { 
                            ?>
                            <li class="nav-item"><?=$roottype['type']?></li>
                            <?php
                        }
                        foreach ($subtypes as $subtype) {
                        ?>
                            <?php if ($subtype['type'] == "line"):?>
                                <li><hr class="dropdown-divider"></li>
                            <?php else:?>
                                <li>
                                        <a class="dropdown-item text-start" href="/products.php?type=<?=$subtype['id']?>"><?=$subtype['type']?> <?=$subtype['quantity']?></a>
                                        
                                </li>
                            <?php endif; ?>
                        <?php
                        }
                        if (isset($subtypes[0])) {
                        ?>
                            </ul>
                            </li>
                        <?php
                        }
                    }
                ?>
                <li class="nav-item"><a class="nav-link ctext" href="/products.php">Alle Produkte</a></li>
            </ul> 

            <form class="d-flex" action="/products.php">
                <input class="form-control me-2" name="search" type="search" placeholder="Suchen" aria-label="Search" required>
                <button class="btn btn-outline-primary me-2" type="submit">Suchen</button>
            </form>
            <?php if(isset($user1['id'])): ?>
            <a class="icon-navbar-a" href="/cart.php"><i class="fa-solid fa-cart-shopping me-2 ms-2 mt-2" id="user-icon-navbar"></i></a>
            <?php endif; if(!isset($user1['id'])): ?>
                <a class="icon-navbar-a" href="/<?php if(isset($user1['id'])) {print("settings.php");} else {print("login.php");} ?>"><i class="fa-solid fa-user ms-2 me-2 mt-2" id="user-icon-navbar"></i></a>
            <?php endif; if(isset($user1['id'])): ?>
            <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link ctext dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user ms-2 me-2 mt-2" id="user-icon-navbar"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item " href="/internal.php">Intern</a></li>
                    <li><a class="dropdown-item" href="/settings.php">Einstellungen</a></li>
                    <li><a class="dropdown-item" href="/logout.php">Abmelden</a></li>
                </ul>
            </li>
            </ul>
            <?php endif; ?>
            <!--
            <a class="d-flex icon-navbar-a" href="#HILFE"><i class="fa-solid fa-circle-info me-2 ms-4 mt-2" id="user-icon-navbar"></i></a>
            -->
        </div>
    </div>
</nav>
<?php
return $user1;
?>