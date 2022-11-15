<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {

    $stmt = $pdo->prepare('SELECT * FROM idRegistration WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$id) {
        exit('Student ID doesn\'t exist with that ID!');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            
            $stmt = $pdo->prepare('DELETE FROM idRegistration WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the Student ID!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete Student ID #<?=$id['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Are you sure you want to delete student ID #<?=$id['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$id['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$id['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>