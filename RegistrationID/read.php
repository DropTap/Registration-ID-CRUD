<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM idregistration ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$idregistration = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_idregistration = $pdo->query('SELECT COUNT(*) FROM idregistration')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Read ID Registration</h2>
	<a href="create.php" class="create-id">Create ID</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Student ID Number</td>
                <td>Last Name</td>
                <td>FIrst Name</td>
                <td>Middle Initial</td>
                <td>Course</td>
                <td>Address</td>
                <td>Birthdate</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($idregistration as $idregister): ?>
            <tr>
                <td><?=$idregister['id']?></td>
                <td><?=$idregister['studentIDNumber']?></td>
                <td><?=$idregister['lName']?></td>
                <td><?=$idregister['fName']?></td>
                <td><?=$idregister['mInitial']?></td>
                <td><?=$idregister['course']?></td>
                <td><?=$idregister['address']?></td>
                <td><?=$idregister['birthdate']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$idregister['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$idregister['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_idregistration): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>