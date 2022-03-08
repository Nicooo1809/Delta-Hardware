<?php
chdir('..');
require_once("php/functions.php");
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM users ORDER BY id');
$stmt->execute();
// Fetch the records so we can display them in our template.
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once("templates/header.php");
?>

<div class="minheight100 content read">
	<h2>Read Contacts</h2>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Vorname</td>
                <td>Nachname</td>
                <td>E-Mail</td>
                <td>Created</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['vorname']?></td>
                <td><?=$row['nachname']?></td>
                <td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
                <td><?=$row['created_at']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$row['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$row['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
include_once("templates/footer.php")
?>
