<!-- php -->
<?php
    // connect the php file to database alumni_management_system
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
        
        //query for alumni count
        $sql = "SELECT COUNT(student_id) AS alumni_count FROM alumni";

        // connect in databse then run the query $sql
        $result = $conn->query($sql);
        // retrieve the data from database
        $row = $result->fetch_assoc();

        // get the exact query or in short COUNT(student_id) from table alumni,  COUNT(student_id) rename as alumni_count
        $count = $row['alumni_count'];

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="row mb-3">
        <!-- display Alumni Total Count -->
        <label class="col-sm-3 col-form-label" style="font-size: 20px;">Alumni Total Count:</label>
        <!-- display alumni count in database -->
        <label class="col-sm-3 col-form-label" style="font-size: 20px;"><?php echo $count; ?></label>
    </div>
</body>
</html>