<!DOCTYPE html>
<html>
  <head>
    <title>Dynamic Menu Demo</title>
    <link rel="stylesheet" href="demo.css"/>
  </head>
  <body>
    <nav class="ddmenu"><?php
    // (A) GET MENU ITEMS
    require "menu.php";

    // (B) SUPPORT FUNCTION TO DRAW AN <A>
    function drawlink ($i) {
      printf("<a %shref='%s'>%s</a>",
        $i["item_target"]!="" ? "target='". $i["item_target"] ."' " : "" ,
        $i["item_link"], $i["item_text"]
      );
    }

    // (C) DRAW MENU ITEMS
    foreach ($items[0] as $id=>$i) {
      // (C1) WITH SUB-ITEMS
      if (isset($items[$id])) { ?>
      <div class="ddgrp">
        <div><?=$i["item_text"]?></div>
        <div class="dditems"><?php
          foreach ($items[$id] as $cid=>$c) { drawlink($c); }
        ?></div>
      </div>

      <?php
      // (C2) SINGLE MENU ITEM
      } else { drawlink($i); }
    }
    ?></nav>
  </body>
</html>
