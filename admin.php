<?php
require_once("php/functions.php");
$user = check_user();
if ($user['showUser'] != 1 or $user['showUserPerms'] != 1) {
    error('Permission denied!');
}
if (isset($get['site'])) {
    if ($_GET['site'] == 'user') {
        require_once('user.php');
    }
    if ($_GET['site'] == 'permission') {
        require_once('perms.php');
    }
    exit;
}
require_once("templates/header.php");
?>
<main>
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="minheight100 col py-4 px-3">
                <div class="card cbg text-center mx-auto" style="width: 75%;">
                    <div class="card-body">
                        <h1 class="card-title mb-2 text-center">Adminbereich</h1>
                        <?php
                            if ($user['showUser'] == 1) {
                                print('<a href="user.php">Benutzer</a>');
                            
                            } 
                            if ($user['showUserPerms'] == 1) {
                                print('<a href="perms.php">Berechtigungen</a>');
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include_once("templates/footer.php")
?>
