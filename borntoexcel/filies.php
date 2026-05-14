<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM uploads ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Files</title>
</head>
<body>

<h2>📁 Uploaded Files</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>File Name</th>
        <th>Uploaded By</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

    <tr>
        <td><?php echo $row['file_name']; ?></td>
        <td><?php echo $row['uploaded_by']; ?></td>
        <td><?php echo $row['upload_date']; ?></td>
        <td>
            <a href="<?php echo $row['file_path']; ?>" download>⬇ Download</a>
        </td>
    </tr>

<?php } ?>

</table>

</body>
</html>