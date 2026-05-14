<?php

session_start();
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

/* COUNTS */

$staff_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM staff")
);

$patient_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM patients")
);

$schedule_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM schedules")
);

$report_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM reports")
);

/* RECENT SCHEDULES */

$recent_schedules = mysqli_query($conn, "

SELECT 
    schedules.*,
    staff.fullname AS staff_name,
    patients.fullname AS patient_name

FROM schedules

LEFT JOIN staff 
ON schedules.staff_id = staff.id

LEFT JOIN patients
ON schedules.patient_id = patients.id

ORDER BY schedules.id DESC
LIMIT 5

");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f1f5f9;
}

/* MAIN LAYOUT */

.container{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */

.sidebar{
    width:260px;
    background:#0f172a;
    color:white;
    padding:20px;
    position:sticky;
    top:0;
    height:100vh;
}

.sidebar h2{
    margin-bottom:30px;
    text-align:center;
}

.sidebar a{
    display:block;
    text-decoration:none;
    color:#cbd5e1;
    padding:14px;
    margin-bottom:10px;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
    color:white;
}

/* MAIN */

.main{
    flex:1;
    padding:20px;
}

/* TOPBAR */

.topbar{
    background:white;
    padding:20px;
    border-radius:14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:20px;
}

.card{
    background:white;
    padding:25px;
    border-radius:14px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card h1{
    font-size:34px;
    color:#0f172a;
    margin-bottom:10px;
}

.card p{
    color:#64748b;
}

/* TABLE */

.table-box{
    background:white;
    margin-top:25px;
    padding:20px;
    border-radius:14px;
    overflow-x:auto;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.table-box h2{
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:700px;
}

table th{
    background:#f8fafc;
    color:#475569;
}

table th,
table td{
    padding:14px;
    border-bottom:1px solid #e2e8f0;
    text-align:left;
}

/* STATUS */

.pending{
    background:#fef3c7;
    color:#92400e;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

.completed{
    background:#dcfce7;
    color:#166534;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

/* MOBILE */

@media(max-width:900px){

    .container{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
        height:auto;
        position:relative;
        display:flex;
        flex-wrap:wrap;
        justify-content:center;
        gap:10px;
    }

    .sidebar h2{
        width:100%;
        margin-bottom:10px;
    }

    .sidebar a{
        margin-bottom:0;
    }

    .main{
        padding:15px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }

}

</style>

</head>

<body>

<div class="container">

<!-- SIDEBAR -->

<div class="sidebar">

<h2>Care Panel</h2>

<a href="Dashboard.php">Dashboard</a>

<?php if($_SESSION['role'] == 'admin'){ ?>

<a href="staff.php">Staff</a>

<a href="patients.php">Patients</a>

<a href="schedules.php">Schedules</a>

<a href="uploads.php">Uploads</a>

<?php } ?>

<a href="reports.php">Reports</a>

<a href="logout.php">Logout</a>

</div>

<!-- MAIN -->

<div class="main">

<!-- TOPBAR -->

<div class="topbar">

<div>
<h2>Home Care Dashboard</h2>
</div>

<div>
Welcome,
<?php echo $_SESSION['fullname']; ?>
(<?php echo $_SESSION['role']; ?>)
</div>

</div>

<!-- CARDS -->

<div class="cards">

<div class="card">
<h1><?php echo $staff_count['total']; ?></h1>
<p>Total Staff</p>
</div>

<div class="card">
<h1><?php echo $patient_count['total']; ?></h1>
<p>Total Patients</p>
</div>

<div class="card">
<h1><?php echo $schedule_count['total']; ?></h1>
<p>Total Schedules</p>
</div>

<div class="card">
<h1><?php echo $report_count['total']; ?></h1>
<p>Total Reports</p>
</div>

</div>

<!-- TABLE -->

<div class="table-box">

<h2>Recent Schedule</h2>

<table>

<tr>
<th>Staff</th>
<th>Patient</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($schedule = mysqli_fetch_assoc($recent_schedules)){ ?>

<tr>

<td><?php echo $schedule['staff_name']; ?></td>

<td><?php echo $schedule['patient_name']; ?></td>

<td><?php echo $schedule['visit_date']; ?></td>

<td>

<?php if($schedule['status'] == 'Pending'){ ?>

<span class="pending">
Pending
</span>

<?php } else { ?>

<span class="completed">
Completed
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>