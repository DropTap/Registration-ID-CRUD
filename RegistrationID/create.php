<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {

    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $studentIDNumber = isset($_POST['studentIDNumber']) ? $_POST['studentIDNumber'] : '';
    $lName = isset($_POST['lName']) ? $_POST['lName'] : '';
    $fName = isset($_POST['fName']) ? $_POST['fName'] : '';
    $mInitial = isset($_POST['mInitial']) ? $_POST['mInitial'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';

    $stmt = $pdo->prepare('INSERT INTO idregistration VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $studentIDNumber, $lName, $fName, $mInitial, $course, $address, $birthdate]);

    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
    <h2>Create ID</h2>
    <form action="create.php" method="post">

        <label for="id">ID</label>
        <label for="id">Student ID Number</label>
        <input type="text" name="id" placeholder="0" value="Auto" id="id">
        <input type="text" name="studentIDNumber" placeholder="00-0000-000" maxlength="11" id="studentIDNumber">

        <label for="lName">Last Name</label>
        <label for="fName">First Name</label>
        <input type="text" name="lName" maxlength="20" id="lName">
        <input type="text" name="fName" maxlength="20" id="fName">

        <label for="mInitial">Middle Initial</label>
        <label for="address">Address</label>
        <input type="text" name="mInitial" maxlength="1" id="mInitial">
        <input type="text" name="address" id="address">
       
        <label for="course">Course</label>
        <label><input type="radio" name="course" value="BSIT" checked="checked">BS Information Technology</label>
        <label><input type="radio" name="course" value="BSCS" style="margin-left: -100px;">BS Computer Science</label>
        <label><input type="radio" name="course" value="BSDA" style="margin-left: -20px;">BS Data Analytics</label>

        <label for="birthdate">Birthdate</label>
        <input type="date" name="birthdate">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>