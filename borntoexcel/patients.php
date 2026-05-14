<?php

include "config.php";
session_start();
if($_SESSION['role'] != 'admin'){
    die("Access Denied");
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

/* ADD PATIENT */
if(isset($_POST['add_patient'])){

    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $condition = $_POST['condition_notes'];

    $sql = "INSERT INTO patients(fullname,age,gender,address,condition_notes)
            VALUES('$fullname','$age','$gender','$address','$condition')";

    mysqli_query($conn,$sql);
}

/* DELETE PATIENT */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM patients WHERE id='$id'");
}

/* FETCH PATIENTS */
$patients = mysqli_query($conn,"SELECT * FROM patients");

?>

<!DOCTYPE html>
<html>
<head>
<title>Patients</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}
.a{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.container{
    max-width:1100px;
    margin:auto;
}

.box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

input,select,textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
}

button{
    padding:10px;
    margin-top:10px;
    background:#1e2a38;
    color:white;
    border:none;
    cursor:pointer;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
}

th,td{
    padding:10px;
    border:1px solid #ddd;
}

a{
    text-decoration:none;
}

.back-link{
    float: right;
}

.delete{
    color:red;
}
.btn{
    background:#1e2a38;
    color:white;
    padding:10px 15px;
    border-radius:5px;
}

</style>

</head>

<body>

<div class="container">

<h1>Patient Management</h1>

<a href="dashboard.php" class="btn">Back Dashboard</a>

<!-- ADD PATIENT FORM -->
<div class="box">

<form method="POST">

<input type="text" name="fullname" placeholder="Full Name" required>

<input type="number" name="age" placeholder="Age" required>

<select name="gender">
    <option>Male</option>
    <option>Female</option>
</select>

<input type="text" name="address" placeholder="Address">

<textarea name="condition_notes" placeholder="Condition Notes"></textarea>

<button name="add_patient">Add Patient</button>

</form>

</div>

<!-- TABLE -->
<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Age</th>
<th>Gender</th>
<th>Address</th>
<th>Condition</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($patients)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['fullname']; ?></td>
<td><?php echo $row['age']; ?></td>
<td><?php echo $row['gender']; ?></td>
<td><?php echo $row['address']; ?></td>
<td><?php echo $row['condition_notes']; ?></td>

<td>

<a class="delete" href="patients.php?delete=<?php echo $row['id']; ?>">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>