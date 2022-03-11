    <?php
    // (A) GET MENU ITEMS
    require "menu.php";
    require_once('templates/header.php');

    // (B) SUPPORT FUNCTION TO DRAW AN <A>
    function drawlink ($i) {
      printf("<li><a class='dropdown-item' href='". $i["item_link"] . "'>" . $i["item_text"] . "</a></li>"
      );
    }
    ?>
    <li class="nav-item dropdown">
    <?php
    // (C) DRAW MENU ITEMS
    foreach ($items[0] as $id=>$i) {
      // (C1) WITH SUB-ITEMS
      if (isset($items[$id])) { ?>
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Audio
    </a>
        <div><?=$i["item_text"]?></div>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown"><?php
          foreach ($items[$id] as $cid=>$c) { drawlink($c); }
        ?></ul>

      <?php
      // (C2) SINGLE MENU ITEM
      } else { drawlink($i); }
    }
    ?>
    </li>
<?php
require_once("templates/footer.php");
?>

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

