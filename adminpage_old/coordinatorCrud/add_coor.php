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
    $contact ="";
    $email ="";
    $username ="";
    $temp_password ="";

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $temp_password = $_POST['temp_pass'];

        do{
            if(empty($name) || empty($contact) || empty($email) || empty($username) || empty($temp_password)){
                $errorMessage = "All the field are required";
                break;
            }

                // Add new client to the database
                // $sql = "INSERT INTO alumni (alumni_name, course, batch, connected_to, contact, alumni_address, email, username, pass)" .
                //        "VAlUE ($name, $course, $batch, $connected_to, $contact, $address, $email, $username, $temp_password)"; 
                $sql = "INSERT INTO coordinator SET coor_name='$name', contact='$contact', email='$email', username='$username', password='$temp_password'";
        
                $result = $conn->query($sql);

                if(!$result){
                    $errorMessage = "Invalid Query: " . $conn->error;
                    break;
                }

                $name ="";
                $contact ="";
                $email ="";
                $username ="";
                $temp_password ="";
                $errorMessage = "";

                $successMessage = "Coordinator added sucessfully";
                header("location: ../coordinator.php");
                exit;

        }while(false);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Add New Coodinator</title>
</head>
<body>
    <div class="container my-5 " style="background-color: gainsboro; padding: 10px;">
        <h2>Add New Coordinator</h2>

        <?php
            if(!empty($errorMessage)){
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
                </div>";
            } 
        ?>

        <form action="" method="POST">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Contact</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact" value="<?php echo $contact; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Temporary Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="temp_pass" value="<?php echo $temp_password; ?>">
                </div>
            </div>

            <?php
                if(!empty($successMessage)){
                    echo "
                        <div class='row mb-3'>
                            <div class='offset-sm-3 col-sm-6'>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>$successMessage</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
                                </div>
                            </div>
                        </div>
                    ";
                } 
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../coordinator.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>