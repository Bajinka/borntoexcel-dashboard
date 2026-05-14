<?php

include "config.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

/* ADD SCHEDULE */
if(isset($_POST['add_schedule'])){

    $staff_id = $_POST['staff_id'];
    $patient_id = $_POST['patient_id'];
    $visit_date = $_POST['visit_date'];
    $visit_time = $_POST['visit_time'];
    $notes = $_POST['notes'];

    mysqli_query($conn, "
        INSERT INTO schedules(staff_id,patient_id,visit_date,visit_time,notes)
        VALUES('$staff_id','$patient_id','$visit_date','$visit_time','$notes')
    ");
}

/* DELETE SCHEDULE */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM schedules WHERE id='$id'");
}
/* COMPLETE SCHEDULE */

if(isset($_GET['complete'])){

    $id = $_GET['complete'];

    mysqli_query($conn,
        "UPDATE schedules 
        SET status='Completed'
        WHERE id='$id'"
    );
}

/* DATA */
$schedules = mysqli_query($conn,"SELECT * FROM schedules");
$staff = mysqli_query($conn,"SELECT * FROM staff");
$patients = mysqli_query($conn,"SELECT * FROM patients");

?>

<!DOCTYPE html>
<html>
<head>
<title>Schedules</title>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

.container{
    max-width:1100px;
    margin:auto;
}

.box{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
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

.delete{
    color:red;
}
.btn{
    background:#1e2a38;
    color:white;
    padding:10px 15px;
    border-radius:5px;
}

a{
    text-decoration:none;}

    #calendar{
    margin-top:20px;
}

.fc-toolbar-title{
    font-size:22px !important;
}

.fc-daygrid-event{
    border:none !important;
    padding:4px !important;
    border-radius:6px !important;
}
</style>

</head>

<body>

<div class="container">

<h1>Schedule Management</h1>

<a href="dashboard.php" class="btn">Back Dashboard</a>


<!-- FORM -->
<div class="box">

<form method="POST">

<!-- STAFF -->
<select name="staff_id" required>
    <option value="">Select Staff</option>
    <?php while($s = mysqli_fetch_assoc($staff)){ ?>
        <option value="<?php echo $s['id']; ?>">
            <?php echo $s['fullname']; ?>
        </option>
    <?php } ?>
</select>

<!-- PATIENT -->
<select name="patient_id" required>
    <option value="">Select Patient</option>
    <?php while($p = mysqli_fetch_assoc($patients)){ ?>
        <option value="<?php echo $p['id']; ?>">
            <?php echo $p['fullname']; ?>
        </option>
    <?php } ?>
</select>

<input type="date" name="visit_date" required>

<input type="time" name="visit_time" required>

<textarea name="notes" placeholder="Notes"></textarea>

<button name="add_schedule">Assign Schedule</button>

</form>

</div>

<!-- TABLE -->
<table>

<tr>
<th>ID</th>
<th>Staff ID</th>
<th>Patient ID</th>
<th>Date</th>
<th>Time</th>
<th>Notes</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($schedules)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['staff_id']; ?></td>
<td><?php echo $row['patient_id']; ?></td>
<td><?php echo $row['visit_date']; ?></td>
<td><?php echo $row['visit_time']; ?></td>
<td><?php echo $row['notes']; ?></td>

<td>
<a href="schedules.php?complete=<?php echo $row['id']; ?>">
Complete
</a>

|

<a class="delete"
href="schedules.php?delete=<?php echo $row['id']; ?>">
Delete
</td>

</tr>

<?php } ?>

</table>
<div class="box">

<h2>Schedule Calendar</h2>

<div id="calendar"></div>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',

        height: 650,

        events: [

            <?php

            $calendar_query = mysqli_query($conn, "

                SELECT 
                    schedules.*,
                    staff.fullname AS staff_name,
                    patients.fullname AS patient_name

                FROM schedules

                LEFT JOIN staff
                ON schedules.staff_id = staff.id

                LEFT JOIN patients
                ON schedules.patient_id = patients.id

            ");

            while($event = mysqli_fetch_assoc($calendar_query)){

            ?>

            {

                title: "<?php echo $event['staff_name']; ?> → <?php echo $event['patient_name']; ?>",

                start: "<?php echo $event['visit_date']; ?>",

                color: "<?php echo $event['status'] == 'Completed' ? '#16a34a' : '#f59e0b'; ?>"

            },

            <?php } ?>

        ]

    });

    calendar.render();

});

</script>

</body>
</html>