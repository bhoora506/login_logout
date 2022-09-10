<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//database connecton
function connection()
{
    $connection = mysqli_connect('192.168.1.63', 'bhoora', 'ubuy@123', 'bhoora_test');
    if (!$connection) {
        die("connection failed:" . mysqli_connect_error());
    } else {
        // echo "connected succussfully";
    }
    return $connection;
}
// insert data into database
function insertdata($insert){
    $response = array(
        'message'=>'',
        'success'=> false,
    );
    $connection = connection();
    $sql = "INSERT INTO `loginform`(`name`, `email`, `mobile_no`, `password`, `comfirmpassword`,`termconditions`)
     VALUES('{$insert['username']}', '{$insert['useremail']}', '{$insert['usermobile']}', '{$insert['userpassword']}', '{$insert['confirmpassword']}', '{$insert['termcondition']}')";
     $query = mysqli_query($connection,$sql);
     if($query){
        $response['success']= true;
     }else{
        $response['message']= "Sorry something went wrong";
     }
     return $response;
}   
// find dupicate data from database
function countduplicate($duplicatedata){
$response = array(
    'message'=>false,
);
    $connection = connection();
    $sql = "SELECT *FROM `loginform` WHERE `email`= '{$duplicatedata['useremail']}' AND `mobile_no`= '{$duplicatedata['usermobile']}'";
   $query =  mysqli_query($connection,$sql);
   $count = mysqli_num_rows($query);
   if($count >=1){
    $response['message']= true;
    $response['message']= "data already exist";
   }
   return $response;
} 

// select data from database
