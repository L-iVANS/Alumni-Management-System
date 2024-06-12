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

    $alumni_id ="";
    $name ="";
    $course ="";
    $batch ="";
    $connected_to ="";
    $contact ="";
    $address ="";
    $email ="";
    $username ="";

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        // Show the data of alumni
        if(!isset($_GET['id'])){
            header("location: ../alumni.php");
            exit;
        }
        $alumni_id = $_GET['id'];
        
        //read data from table alumni
        $sql = "SELECT * FROM alumni WHERE student_id=$alumni_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("location: ../alumni.php");
            exit;
        }

        $name = $row['alumni_name'];
        $course = $row['course'];
        $batch = $row['batch'];
        $connected_to =$row['connected_to'];
        $contact = $row['contact'];
        $address = $row['address'];
        $email = $row['email'];
        $username = $row['username'];
        $file = $row['picture'];
        

    }else{
        // POST method: update the data of alumni
        $alumni_id = $_POST['id'];
        $name = $_POST['name'];
        $course = $_POST['course'];
        $batch = $_POST['batch'];
        $connected_to = $_POST['connected_to'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        // for image
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));

        do{
            if(empty($alumni_id) || empty($name) || empty($course) || empty($batch) || empty($connected_to) || empty($contact) || empty($address) || empty($email) || empty($username)){
                $errorMessage = "All the field are required";
                break;
            }
            // query for insert image in database
            $insert_image = "INSERT INTO alumni SET profile='$file'";
            if(mysqli_query($conn, $insert_image)){
                echo'<script>alert("Image Inserted in database")</script>';
            }

            $sql = "UPDATE alumni SET alumni_name='$name', course='$course', batch='$batch', connected_to='$connected_to', contact='$contact', address='$address', email='$email', username='$username' WHERE student_id=$alumni_id";
            $result = $conn->query($sql);

            if(!$result){
                $errorMessage = "Invalid Query: " . $conn->error;
                break;
            }
            $successMessage = "Alumni added sucessfully";
                header("location: ../alumni.php");
                exit;

        }while(true);
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
    <title>Add New Alumni</title>
</head>
<body>
    <div class="container my-5 " style="background-color: gainsboro; padding: 10px;">
        <h2>Update Alumni Info</h2>

        <?php
            if(!empty($errorMessage)){
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' arial-label='Close'></button>
                </div>";
            } 
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
                <div class="col-sm-6">
                <input class="form-control"
                           type="file" 
                           name="image">
                    <input class="form-control"
                           type="hidden" 
                           name="image"
                           id="image"
                           onchange="getImagePreview(event)">
                </div>
                <div class="col-sm-6">
                    <!-- preview image -->
                    <div class="form-control">
                    
                    <?php echo '<img id="preview" src="data:image/jpeg;base64,'.base64_encode($row['picture']).'" style="width:200px;height:140px;">'; ?>
                        <!-- <img id="preview" src="data:image/jpeg;base64,'.base64_encode($row['profile']).'"> -->
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $alumni_id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Course</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="course" value="<?php echo $course; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Batch</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="batch" value="<?php echo $batch; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Connected to</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="connected_to" value="<?php echo $connected_to; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Contact</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact" value="<?php echo $contact; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
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
                    <a class="btn btn-outline-primary" href="./test_alumni.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Script to display preview of selected image -->
    <script type="text/javascript">
         function getImagePreview(event)
            {
                var image=URL.createObjectURL(event.target.files[0]);
                var imagediv= document.getElementById('preview');
                var newimg=document.createElement('img');
                imagediv.innerHTML='';
                newimg.src=image;
                newimg.width="300";
                imagediv.appendChild(newimg);
            }
    </script>
    <!-- script to insert image to database -->
    <Script>
        $(document).ready(function(){
            $('#insert').click(function(){
                var image_name = $('#image').val();
                if(image_name == ''){
                    alert("please Select Profile")
                    return false;
                }else{
                    var extension = $('#image').val().split('.').pop().toLowerCase();
                    if(jquery.inArray(extenssion,['gif','png','jpg','jpeg']) == -1){
                        alert("Invalid Image File")
                        $('#image').val('');
                         return false;
                    }
                }
            })
        });
    </Script>

</body>
</html>