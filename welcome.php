<?php
session_start();
include_once 'function.php';
$userprofile = $_SESSION['user_name'];
if ($userprofile == true) {
    $connection = connection();
    $sql = "SELECT * FROM `loginform` WHERE `name`= '$userprofile'";
    $query = mysqli_query($connection, $sql);
    $result  = mysqli_fetch_assoc($query);
    $name = $result['name'];
    $password = $result['password'];
    $email = $result['email'];
    $mobile = $result['mobile_no'];
   
} else {
    header('location:login.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Welcome_page</title>
</head>

<body>
    <div class="container">
        <h2 class="text-center" ><?php echo "Welcome $name";?></h2>
        <table class="table table-bordered">
            <tr>
                <td> Name:</td>
                <td><?php echo $name; ?></td>
            </tr>
            <tr>
                <td>Email_id:</td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td>Mobile_no:</td>
                <td><?php echo $mobile; ?> </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><?php echo $password; ?></td>
            </tr>
        </table>
    </div>
    <button style="margin: 20px;" onclick="return confirmation();"><a href="logout.php">Logout</a></button>

</body>
<script>
    function confirmation() {
        return confirm('Are sure you want to logout');
    }
</script>

</html>