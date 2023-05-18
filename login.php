<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");

    exit;
}

require 'functions.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            $_SESSION["login"] = true;
            $_SESSION["username"] = $row["username"];

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>

<body id="login-page">
    <?php if (isset($error)) : ?>
        <p style="color: red;">Username / Password salah</p>
    <?php endif; ?>

    <div class="container">
        <form action="" method="post" class="login-admin">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Halaman Login</p>
            <div class="input-group">
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
        </form>
    </div>
</body>

</html>