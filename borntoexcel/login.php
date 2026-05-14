<?php

session_start();

include "config.php";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password,$user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");

        }else{
            echo "Wrong Password";
        }

    }else{
        echo "User Not Found";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>

body{
    background:#f4f6f9;
    font-family:Arial;
}

.box{
    width:350px;
    background:white;
    padding:30px;
    margin:100px auto;
    border-radius:10px;
}

input{
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

<h2>Login</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

</div>

</body>
</html>