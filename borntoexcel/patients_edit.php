<?php

include "config.php";

$id = $_GET['id'];

/* GET PATIENT DATA */
$result = mysqli_query($conn, "SELECT * FROM patients WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

/* UPDATE PATIENT */
if(isset($_POST['update'])){

    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $condition = $_POST['condition_notes'];

    mysqli_query($conn, "
        UPDATE patients SET 
        fullname='$fullname',
        age='$age',
        gender='$gender',
        address='$address',
        condition_notes='$condition'
        WHERE id='$id'
    ");

    header("Location: patients.php");
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Patient</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

.box{
    width:500px;
    margin:auto;
    background:white;
    padding:20px;
    border-radius:10px;
}

input,select,textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#1e2a38;
    color:white;
    border:none;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="box">

<h2>Edit Patient</h2>

<form method="POST">

<input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" required>

<input type="number" name="age" value="<?php echo $row['age']; ?>" required>

<select name="gender">

    <option <?php if($row['gender']=="Male") echo "selected"; ?>>Male</option>
    <option <?php if($row['gender']=="Female") echo "selected"; ?>>Female</option>

</select>

<input type="text" name="address" value="<?php echo $row['address']; ?>">

<textarea name="condition_notes"><?php echo $row['condition_notes']; ?></textarea>

<button name="update">Update Patient</button>

</form>

</div>

</body>
</html>