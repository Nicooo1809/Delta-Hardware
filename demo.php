<!DOCTYPE html>
<html>
  <head>
    <title>Dynamic Menu Demo</title>
    <link rel="stylesheet" href="demo.css"/>
  </head>
  <body>
    <li class="nav-item dropdown">
    <?php
    // (A) GET MENU ITEMS
    require "menu.php";

    // (B) SUPPORT FUNCTION TO DRAW AN <A>
    function drawlink ($i) {
      printf("<li><a class='dropdown-item' href='". $i["item_link"] . "'>" . $i["item_text"] . "</a></li>"
      );
    }

    // (C) DRAW MENU ITEMS
    foreach ($items[0] as $id=>$i) {
      // (C1) WITH SUB-ITEMS
      if (isset($items[$id])) { ?>
      <div class="ddgrp">
        <div><?=$i["item_text"]?></div>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown"><?php
          foreach ($items[$id] as $cid=>$c) { drawlink($c); }
        ?></ul>
      </div>

      <?php
      // (C2) SINGLE MENU ITEM
      } else { drawlink($i); }
    }
    ?>
    </li>
  </body>
</html>


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

