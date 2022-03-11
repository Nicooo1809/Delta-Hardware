<?php
// (A) CONNECT TO DATABASE - CHANGE SETTINGS TO YOUR OWN!
$dbHost = "localhost";
$dbName = "shop";
$dbChar = "utf8";
$dbUser = "shopuser";
$dbPass = "";
try {
  $pdo = new PDO(
    "mysql:host=$dbHost;dbname=$dbName;charset=$dbChar",
    $dbUser, $dbPass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
} catch (Exception $ex) { exit($ex->getMessage()); }

// (B) DRILL DOWN GET MENU ITEMS
// ARRANGE BY [PARENT ID] => [MENU ITEMS]
$items = [];
while (true) {
  // (B1) SQL QUERY
  $sql = "SELECT * FROM `menu_items` WHERE `parent_id` ";
  if (!isset($next)) { $sql .= "IS NULL"; }
  else { $sql .= "IN ($next)"; }

  // (B2) FETCH MENU ITEMS
  $next = "";
  $parent = "";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  while (($i = $stmt->fetch()) !== false) {
    $parent = $i["parent_id"]=="" ? 0 : $i["parent_id"] ;
    if (!isset($items[$parent])) { $items[$parent] = []; }
    $items[$parent][$i["item_id"]] = $i;
    $next .= $i["item_id"] . ",";
  }
  if ($next == "") { break; }
  else { $next = substr($next, 0, -1); }
}
print_r($items, true);