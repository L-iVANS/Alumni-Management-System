<?php
    $serername="localhost";
    $db_username="root";
    $db_password="";
    $db_name="alumni_management_system";
    $conn=mysqli_connect($serername, $db_username, $db_password, $db_name);

    if(mysqli_connect_errno()){
        die("". mysqli_connect_error());
    }else{
        echo"Successfully Connected!";
    }

    $name ="";
    $course ="";
    $batch ="";
    $connected_to ="";
    $contact ="";
    $address ="";
    $email ="";
    $username ="";
    $temp_password ="";

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        $name = $_POST['name'];
        $course = $_POST['batch'];
        $batch = $_POST['course'];
        $connected_to = $_POST['connected_to'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $temp_password = $_POST['temp_pass'];

        do{
            if(empty($name) || empty($course) || empty($batch) || empty($connected_to) || empty($contact) || empty($address) || empty($email) || empty($username) || empty($temp_password)){
                $errorMessage = "All the field are required";
                break;
            }

                // Add new client to the database
                // $sql = "INSERT INTO alumni (alumni_name, course, batch, connected_to, contact, alumni_address, email, username, pass)" .
                //        "VAlUE ($name, $course, $batch, $connected_to, $contact, $address, $email, $username, $temp_password)"; 
                $sql = "INSERT INTO alumni SET alumni_name='$name', course='$course', batch='$batch', connected_to='$connected_to', contact='$contact', address='$address', email='$email', username='$username', password='$temp_password'";
        
                $result = $conn->query($sql);

                if(!$result){
                    $errorMessage = "Invalid Query: " . $conn->error;
                    break;
                }

                $name ="";
                $course ="";
                $batch ="";
                $connected_to ="";
                $contact ="";
                $address ="";
                $email ="";
                $username ="";
                $temp_password ="";
                $errorMessage = "";

                $successMessage = "Alumni added sucessfully";
                header("location: ../alumni.php");
                exit;

        }while(false);
    }
?>