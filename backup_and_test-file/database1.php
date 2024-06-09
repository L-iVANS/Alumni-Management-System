<?php
    $serername="localhost";
    $usernam="root";
    $password="";
    $dbname="alumni_management_system";
    $conn=mysqli_connect($serername, $usernam, $password, $dbname);

    if(mysqli_connect_errno()){
        die("". mysqli_connect_error());
    }else{
        echo"Successfully Connected!";
    }

    // to retrieve data in table
    $query = "SELECT * FROM alumni";
    $result = mysqli_query($conn, $query);
?>