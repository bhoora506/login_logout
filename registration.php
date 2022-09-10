<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header('location:welcome.php');
}
include_once 'function.php';
if (isset($_POST['submit'])) {
    $valid = true;
    $message = "";
    $duplicatedata = array();
    $php_error = array();
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $usermobile = $_POST['usermobile'];
    $userpassword = $_POST['userpassword'];
    $termcondition = isset($_POST['termcondition']) ? $_POST['termcondition'] : "";
    $confirmpassword = $_POST['confirmpassword'];
    if (empty($username)) {
        $php_error['username'] = "username is required";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z_ ']*$/", $username)) {
        $php_error['username'] = "Only alphabets and whitespace are allowed.";
        $valid = false;
    }
    if (empty($useremail)) {
        $php_error['useremail'] = "useremail is required";
        $valid = false;
    } elseif (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $php_error['useremail'] = "Invalid email format";
        $valid = false;
    }
    if (empty($usermobile)) {
        $php_error['usermobile'] = "usermobile is required";
        $valid = false;
    } elseif (!filter_var($usermobile, FILTER_SANITIZE_NUMBER_INT)) {
        $php_error['usermobile'] = "Only numbers are allowed";
        $valid = false;
    } else {
        $count = strlen($usermobile);
        if ($count != 10) {
            $php_error['usermobile'] = "Only 10 digits are allowed";
            $valid = false;
        }
    }
    if (empty($userpassword)) {
        $php_error['userpassword'] = "Password is required";
        $valid = false;
    } elseif (strlen($_POST["userpassword"]) <= '8') {
        $php_error['userpassword'] = "Your Password Must Contain At Least 8 Characters!";
    } elseif (!preg_match("#[0-9]+#", $userpassword)) {
        $php_error['userpassword'] = "Your Password Must Contain At Least 1 Number!";
    } elseif (!preg_match("#[A-Z]+#", $userpassword)) {
        $php_error['userpassword'] = "Your Password Must Contain At Least 1 Capital Letter!";
    } elseif (!preg_match("#[a-z]+#", $userpassword)) {
        $php_error['userpassword'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
    } 
    if ($userpassword != $confirmpassword) {
        $php_error['confirmpassword'] = "your passwords doesn't match";
        $valid = false;
    }
    if (empty($confirmpassword)) {
        $php_error['confirmpassword'] = "confirmpassword is required";
        $valid = false;
    }
    if (empty($termcondition)) {
        $php_error['termcondition'] = "Please accept term and conditions";
        $valid = false;
    }
    if ($valid) {
        $duplicatedata['useremail'] = $_POST['useremail'];
        $duplicatedata['usermobile'] = $_POST['usermobile'];
        $response = countduplicate($duplicatedata);
        if ($response['message'] == true) {
            $message = $response['message'];
        } else {
            $insert = array(
                'username' => $_POST['username'],
                'useremail' => $_POST['useremail'],
                'usermobile' => $_POST['usermobile'],
                'userpassword' => $_POST['userpassword'],
                'confirmpassword' => $_POST['confirmpassword'],
                'termcondition' => $_POST['termcondition'],
            );
            $response = insertdata($insert);
            if ($response['success'] == true) {
                $message = "insreted data successfully";
                header('location:login.php');
            } else {
                $message = $response['message'];
            }
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
    <title>Registeration_form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div style="color: red;"><?php if (!empty($message)) {
                                    echo $message;
                                } ?></div>
    <section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                                <form action="" method="POST">
                                    <label for="username">Name</label>
                                    <input class="form-control" type="text" name="username" placeholder="Enter your name" value="<?php if (isset($_POST['username'])) {
                                                                                                                echo $username;
                                                                                                            } ?>">
                                    <span style="color: red;"><?php if (!empty($php_error['username'])) {
                                                                    echo  $php_error['username'];
                                                                } ?></span><br><br>
                                    <label for="useremail">Email</label>
                                    <input class="form-control" type="text" name="useremail" placeholder="Enter youer email" value="<?php if (isset($_POST['useremail'])) {
                                                                                                                    echo $useremail;
                                                                                                                } ?>">
                                    <span style="color: red;"><?php if (!empty($php_error['useremail'])) {
                                                                    echo  $php_error['useremail'];
                                                                } ?></span><br><br>
                                    <label for="usermobile">Mobile</label>
                                    <input class="form-control" type="text" name="usermobile" placeholder="Enter your mobile number" value="<?php if (isset($_POST['usermobile'])) {
                                                                                                                            echo $usermobile;
                                                                                                                        } ?>">
                                    <span style="color: red;"><?php if (!empty($php_error['usermobile'])) {
                                                                    echo  $php_error['usermobile'];
                                                                } ?></span><br><br>
                                    <label for="userpassword">Password</label>
                                    <input class="form-control" type="password" name="userpassword" id="userpassword" placeholder="Enter your password" value="<?php if (isset($_POST['userpassword'])) {
                                                                                                                                                echo $userpassword;
                                                                                                                                            } ?>">
                                    <span style="color: red;"><?php if (!empty($php_error['userpassword'])) {
                                                                    echo  $php_error['userpassword'];
                                                                } ?></span><br><br>
                                    <label for="confirmpassword">Confirmpassword</label>
                                    <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm your password" value="<?php if (isset($_POST['confirmpassword'])) {
                                                                                                                                                        echo $confirmpassword;
                                                                                                                                                    } ?>">
                                    <span style="color: red;"><?php if (!empty($php_error['confirmpassword'])) {
                                                                    echo  $php_error['confirmpassword'];
                                                                } ?></span><br><br>
                                    <input class="form-check-input me-2" type="checkbox" name="termcondition" id="termcondition" value="true" <?php if (isset($_POST['termcondition'])) {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?>>
                                    <label class="form-check-label" for="form2Example3g">
                                        I agree all statements in <a href="https://www.grabtechnologysolutions.com/" class="text-body"><u>Terms of service</u></a>
                                    </label>
                                    <span style="color: red;"><?php if (!empty($php_error['termcondition'])) {
                                                                    echo  $php_error['termcondition'];
                                                                } ?></span><br><br>
                                    <div class="d-flex justify-content-center">
                                        <input type="submit" value="Register" name="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">
                                    </div>
                                    <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="login.php" class="fw-bold text-body"><u>Login here</u></a></p>
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
