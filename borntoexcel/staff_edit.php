<?php
include "config.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM staff WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];

    mysqli_query($conn, "
        UPDATE staff SET 
        fullname='$fullname',
        email='$email',
        phone='$phone',
        department='$department'
        WHERE id='$id'
    ");

    header("Location: staff.php");
}
?>

<form method="POST">
    <input name="fullname" value="<?php echo $row['fullname']; ?>">
    <input name="email" value="<?php echo $row['email']; ?>">
    <input name="phone" value="<?php echo $row['phone']; ?>">
    <input name="department" value="<?php echo $row['department']; ?>">
    <button name="update">Update</button>
</form>