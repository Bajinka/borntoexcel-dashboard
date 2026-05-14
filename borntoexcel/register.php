<?php

include "config.php";

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users(fullname,email,password,role)
            VALUES('$fullname','$email','$password','$role')";

    if(mysqli_query($conn,$sql)){
        echo "User Registered Successfully";
    }else{
        echo "Error";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <style>

        body{
            background:#f4f6f9;
            font-family:Arial;
        }

        .box{
            width:400px;
            background:white;
            padding:30px;
            margin:50px auto;
            border-radius:10px;
        }

        input,select{
            width:100%;
            padding:12px;
            margin-top:10px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:15px;
            background:#1e2a38;
            color:white;
            border:none;
        }

    </style>

</head>

<body>

<div class="box">

<h2>Create User</h2>

<form method="POST">

<input type="text" name="fullname" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<select name="role">

<option value="admin">Admin</option>

<option value="staff">Staff</option>

<option value="supervisor">Supervisor</option>

</select>

<button type="submit" name="register">Register</button>

</form>

</div>

</body>
</html>