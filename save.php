<?php
// (A) GET MENU ITEMS
require "menu.php";

// (B) WRITE HTML MENU TO FILE
$fh = fopen("menu.html", "w");
foreach ($items[0] as $id=>$i) {
  // FORMAT YOUR OWN HTML!
  fwrite($fh, "<a href='{$i["item_link"]}'>{$i["item_text"]}</a>");
}

// (C) DONE!
fclose($fh);
