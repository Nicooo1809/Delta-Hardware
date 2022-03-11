<?php
require_once('php/functions.php');
require_once("templates/header.php");
$stmt = $pdo->prepare("SELECT * FROM menu_items WHERE parent_id = 0");
$stmt->execute();
#error_log(pdo_debugStrParams($stmt));
$roottypes = $stmt->fetch(PDO::FETCH_ASSOC);
error_log(print_r($roottypes, true));
foreach ($roottypes as $roottype) {
  $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE parent_id = ?");
  $stmt->bindValue(1, $roottype['parent_id'], PDO::PARAM_INT);
  $stmt->execute();
  $subtypes = $stmt->fetch(PDO::FETCH_ASSOC);
  if (isset($subtypes)) {
  #error_log('1');
  ?>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?=$roottype['item_text']?>
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
  <?php
  }
  foreach ($subtypes as $subtype) {
  ?>
        <li><a class="dropdown-item" href="products.php?type=<?=$subtype['item_text']?>"><?=$subtype['item_text']?></a></li>
  <?php
  }
  if (isset($subtypes)) {
  ?>
      </ul>
    </li>
  <?php
  }
}
include_once("templates/footer.php")
?>