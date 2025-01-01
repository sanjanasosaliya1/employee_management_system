<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="formstyle.css">
</head>
<body>
<?php
session_start();
include('connection.php');

$usernameERR = $passwordERR = $captchaERR = "";
$username = $password = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (empty($_POST['username'])) 
    {
        $usernameERR = "UserID is required";
        $valid = false;
    } 
    else 
    {
        $username = $_POST['username'];
        if (!preg_match("/^[A-Za-z]+$/", $username)) 
        {
            $usernameERR = "Username should be numeric";
            $valid = false;
        }
    }

    if (empty($_POST['loginpassword'])) 
    {
        $passwordERR = "Password is required";
        $valid = false;
    } 
    else 
    {
        $password = $_POST['loginpassword'];
    }

    if (empty($_POST["vercode"])) 
    {
        $captchaERR = "Captcha is required";
        $valid = false;
    } 
    elseif ($_POST["vercode"] != $_SESSION["vercode"]) 
    {
        $captchaERR = "Incorrect captcha";
        $valid = false;
    }

    if ($valid) 
    {
        $sql = "SELECT password FROM admintb WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_array($result);
            if ($password == $row['password']) 
            {
                $_SESSION['username'] = $username;
                header("Location:display.php");
                exit();
            } 
            else {
                $passwordERR = "Invalid Username or Password";
            }
        } 
        else {
            $usernameERR = "Invalid Username or Password";
        }
        mysqli_close($conn);
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center">Log In</h2>
    <form action="index.php" method="post" class="mt-4">

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input id="username" name="username" placeholder="Enter Your User name" type="text" class="form-control" value="">
            <span class="text-danger"><?php echo $usernameERR; ?></span>
        </div>

        <div class="mb-3">
            <label for="loginpassword" class="form-label">Password</label>
            <input id="loginpassword" name="loginpassword" placeholder="Enter Your Password" type="password" class="form-control">
            <span class="text-danger"><?php echo $passwordERR; ?></span>
        </div>

        <div class="mb-3">
            <label for="vercode" class="form-label">Captcha</label>
            <div class="input-group">
                <input type="text" name="vercode" id="vercode" placeholder="Enter captcha" class="form-control">
                <img src="captcha.php" alt="CAPTCHA Image" class="input-group-text">
            </div>
            <span class="text-danger"><?php echo $captchaERR; ?></span>
        </div>

        <div class="text-center">
            <input type="submit" value="Log In" name="submit" class="btn btn-primary">
        </div>

    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>