<?php

include "config.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

/* UPLOAD FILE */

if(isset($_POST['upload'])){

    $patient_id = $_POST['patient_id'];

    $file = time() . "_" . $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    $target = "uploads/" . basename($file);

    if(move_uploaded_file($tmp_name, $target)){

        mysqli_query($conn,"
            INSERT INTO uploads(patient_id,file_name)
            VALUES('$patient_id','$file')
        ");

    }

}

/* FETCH */

$patients = mysqli_query($conn,"SELECT * FROM patients");

$files = mysqli_query($conn,"
    SELECT uploads.*, patients.fullname
    FROM uploads
    LEFT JOIN patients
    ON uploads.patient_id = patients.id
");

?>

<!DOCTYPE html>
<html>

<head>

<title>File Uploads</title>

<style>

body{
    font-family:Arial;
    background:#f1f5f9;
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

input,select{
    width:100%;
    padding:12px;
    margin-top:10px;
}

button{
    padding:12px;
    margin-top:10px;
    background:#0f172a;
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
    padding:12px;
    border:1px solid #ddd;
    text-align:left;
}

a{
    color:blue;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<h1>Patient File Uploads</h1>

<div class="box">

<form method="POST" enctype="multipart/form-data">

<select name="patient_id" required>

<option value="">Select Patient</option>

<?php while($p = mysqli_fetch_assoc($patients)){ ?>

<option value="<?php echo $p['id']; ?>">
<?php echo $p['fullname']; ?>
</option>

<?php } ?>

</select>

<input type="file" name="file" required>

<button name="upload">
Upload File
</button>

</form>

</div>

<table>

<tr>
<th>ID</th>
<th>Patient</th>
<th>File</th>
<th>Date</th>
</tr>

<?php while($f = mysqli_fetch_assoc($files)){ ?>

<tr>

<td><?php echo $f['id']; ?></td>

<td><?php echo $f['fullname']; ?></td>

<td>

<a target="_blank"
href="uploads/<?php echo $f['file_name']; ?>">

<?php echo $f['file_name']; ?>

</a>

</td>

<td><?php echo $f['uploaded_at']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>