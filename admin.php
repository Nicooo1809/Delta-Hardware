<?php
require_once("templates/header.php");
?>
<main>
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="minheight100 col py-4 px-3">
                <div class="card cbg text-center mx-auto" style="width: 75%;">
                    <div class="card-body">
                        <h1 class="card-title mb-2 text-center">Adminbereich</h1>
                        <a href="user.php">Benutzer</a>
                        <a href="perms.php">Berechtigungen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include_once("templates/footer.php")
?>
