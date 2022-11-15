<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        
        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
        $studentIDNumber = isset($_POST['studentIDNumber']) ? $_POST['studentIDNumber'] : '';
        $lName = isset($_POST['lName']) ? $_POST['lName'] : '';
        $fName = isset($_POST['fName']) ? $_POST['fName'] : '';
        $mInitial = isset($_POST['mInitial']) ? $_POST['mInitial'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';

        $stmt = $pdo->prepare('UPDATE idregistration SET id = ?, studentIdNumber = ?, lName = ?, fName = ?, mInitial = ?, course = ?, address = ?, birthdate = ? WHERE id = ?');
        $stmt->execute([$id, $studentIDNumber, $lName, $fName, $mInitial, $course, $address, $birthdate, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }

    $stmt = $pdo->prepare('SELECT * FROM idregistration WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$id) {
        exit('Student ID doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update ID #<?=$id['id']?></h2>
    <form action="update.php?id=<?=$id['id']?>" method="post">

        <label for="id">ID</label>
        <label for="id">Student ID Number</label>
        <input type="text" name="id" placeholder="0" value="<?=$id['id']?>" id="id">
        <input type="text" name="studentIDNumber" placeholder="00-0000-000" value="<?=$id['studentIDNumber']?>" maxlength="11" id="studentIDNumber">

        <label for="lName">Last Name</label>
        <label for="fName">First Name</label>
        <input type="text" name="lName" maxlength="20" value="<?=$id['lName']?>" id="lName">
        <input type="text" name="fName" maxlength="20" value="<?=$id['fName']?>" id="fName">

        <label for="mInitial">Middle Initial</label>
        <label for="address">Address</label>
        <input type="text" name="mInitial" maxlength="1" value="<?=$id['mInitial']?>" id="mInitial">
        <input type="text" name="address" value="<?=$id['address']?> "id="address">
       
        <label for="course">Course</label>
        <label><input type="radio" name="course" value="BSIT" checked="checked">BS Information Technology</label>
        <label><input type="radio" name="course" value="BSCS" style="margin-left: -100px;">BS Computer Science</label>
        <label><input type="radio" name="course" value="BSDA" style="margin-left: -20px;">BS Data Analytics</label>

        <label for="birthdate">Birthdate</label>
        <input type="date" name="birthdate" value="<?=date('Y-m-d\TH:i', strtotime($id['birthdate']))?>">

        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>