<?php

include "config.php";
session_start();
if(
    $_SESSION['role'] != 'admin'
    &&
    $_SESSION['role'] != 'staff'
){
    die("Access Denied");
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

/* ADD REPORT */
if(isset($_POST['add_report'])){

    $staff_id = $_SESSION['user_id'];
    $patient_id = $_POST['patient_id'];
    $report_date = $_POST['report_date'];
    $notes = $_POST['notes'];

    mysqli_query($conn,"
        INSERT INTO reports(staff_id,patient_id,report_date,notes)
        VALUES('$staff_id','$patient_id','$report_date','$notes')
    ");
}

/* FETCH DATA */
$reports = mysqli_query($conn,"SELECT * FROM reports");
$patients = mysqli_query($conn,"SELECT * FROM patients");

?>

<!DOCTYPE html>
<html>
<head>
<title>Daily Reports</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

.container{
    max-width:1000px;
    margin:auto;
}

.box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

input,textarea,select{
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
.btn{
    background:#1e2a38;
    color:white;
    padding:10px 15px;
    border-radius:5px;
}

a{
    text-decoration:none;}

</style>

</head>

<body>

<div class="container">

<h1>Daily Care Reports</h1>

<a href="dashboard.php" class="btn">Back Dashboard</a>


<!-- FORM -->
<div class="box">

<form method="POST">

<select name="patient_id" required>
    <option value="">Select Patient</option>
    <?php while($p = mysqli_fetch_assoc($patients)){ ?>
        <option value="<?php echo $p['id']; ?>">
            <?php echo $p['fullname']; ?>
        </option>
    <?php } ?>
</select>

<input type="date" name="report_date" required>

<textarea name="notes" placeholder="Write daily care report..." required></textarea>

<button name="add_report">Submit Report</button>

</form>

</div>

<!-- TABLE -->
<table>

<tr>
<th>ID</th>
<th>Staff ID</th>
<th>Patient ID</th>
<th>Date</th>
<th>Notes</th>
</tr>

<?php while($r = mysqli_fetch_assoc($reports)){ ?>

<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['staff_id']; ?></td>
<td><?php echo $r['patient_id']; ?></td>
<td><?php echo $r['report_date']; ?></td>
<td><?php echo $r['notes']; ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>