<?php
$serername="localhost";
$db_username="root";
$db_password="";
$db_name="alumni_management_system";
$conn=mysqli_connect($serername, $db_username, $db_password, $db_name);

// check for error
if(mysqli_connect_errno()){
    die("". mysqli_connect_error());
}else{
    // display if no error in connection
    echo"Successfully Connected!";
}
?>