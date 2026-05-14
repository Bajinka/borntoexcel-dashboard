<?php

session_start();if($_SESSION['role'] != 'admin')
    die("Access Denied");

include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

/* ADD STAFF */

if(isset($_POST['add_staff'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];

    $sql = "INSERT INTO staff(fullname,email,phone,department)
            VALUES('$fullname','$email','$phone','$department')";

    mysqli_query($conn,$sql);

}

/* DELETE STAFF */

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query($conn,"DELETE FROM staff WHERE id='$id'");

}

/* FETCH STAFF */

$staff = mysqli_query($conn,"SELECT * FROM staff");

?>

<!DOCTYPE html>
<html>
<head>

<title>Staff Management</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f4f6f9;
    padding:20px;
}

.container{
    max-width:1200px;
    margin:auto;
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

a{
    text-decoration:none;
}

.btn{
    background:#1e2a38;
    color:white;
    padding:10px 15px;
    border-radius:5px;
}

.form-box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
}

button{
    padding:12px 20px;
    background:#1e2a38;
    color:white;
    border:none;
    margin-top:15px;
    cursor:pointer;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
}

table th,
table td{
    padding:12px;
    border:1px solid #ddd;
    text-align:left;
}

.delete{
    color:red;
}

</style>

</head>

<body>

<div class="container">

<div class="top">

<h1>Staff Management</h1>

<a href="dashboard.php" class="btn">Back Dashboard</a>

</div>

<!-- ADD STAFF FORM -->

<div class="form-box">

<form method="POST">

<input type="text" name="fullname" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="text" name="phone" placeholder="Phone Number" required>

<input type="text" name="department" placeholder="Department" required>


<button type="submit" name="add_staff">Add Staff</button>

</form>

</div>

<!-- STAFF TABLE -->

<table>

<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Department</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($staff)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td><?php echo $row['department']; ?></td>


<td>


<a href="staff.php?delete=<?php echo $row['id']; ?>" style="color:red;">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>