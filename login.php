<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header('location:welcome.php');
}
include_once 'function.php';
if (isset($_POST['submit'])) {
    $myerror = array();
    $message = "";
    $valid = true;
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username)) {
        $myerror['username'] = "username is required";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z_ ']*$/", $username)) {
        $myerror['username'] = "Only alphabets and whitespace are allowed.";
        $valid = false;
    }
    if (empty($password)) {
        $myerror['password'] = "Password is required";
        $valid = false;
    }
    if ($valid) {
        $connection  = connection();
        $sql = "SELECT * FROM `loginform` WHERE `name`= '$username' AND `password`= '$password'";
        $query = mysqli_query($connection, $sql);
        $total = mysqli_num_rows($query);
        if ($total == 1) {
            $_SESSION['user_name'] = $username;
            header('location:welcome.php');
        } else {
            $message =  "incorrect username and password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Login_page</title>
</head>

<body>
    <section class="vh-100 bg-image" style="background-image: url('https://wallpaperaccess.com/full/16692.jpg');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Login here</h2>
                                <form action="" method="POST">
                                    <label class="form-label" for="username">Username</label>
                                    <input class="form-control form-control-lg" type="text" name="username" placeholder="Enter username" value="<?php if (isset($_POST['username'])) {
                                                                                                                                                    echo $username;
                                                                                                                                                } ?>">
                                    <span style="color: red;"> <?php if (!empty($myerror['username'])) {
                                                                    echo $myerror['username'];
                                                                } ?></span><br><br>
                                    <label class="form-label" for="password">Password</label>
                                    <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" value="<?php if (isset($_POST['password'])) {
                                                                                                                                                                echo $password;
                                                                                                                                                            } ?>">
                                    <span style="color: red;"> <?php if (!empty($myerror['password'])) {
                                                                    echo $myerror['password'];
                                                                } ?></span>
                                    <br><br>
                                    <input class="btn btn-warning btn-lg ms-2" type="submit" value="Login" name="submit"><br><br>
                                    <span style="color: red;"><?php if (!empty($message)) {
                                                                    echo $message;
                                                                } ?></span>
                                    <p class="text-center text-muted mt-5 mb-0">Create an account <a href="registration.php" class="fw-bold text-body"><u>Register</u></a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>