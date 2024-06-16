<?php
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "alumni_management_system";
    $conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

    $fname = "";
    $mname = "";
    $lname = "";
    $contact = "";
    $email = "";
    $username = "";
    $temp_password = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $temp_password = $_POST['temp_pass'];

        $emailCheck = mysqli_query($conn, "SELECT * FROM coordinator WHERE email='$email'");
        $usernameCheck = mysqli_query($conn, "SELECT * FROM coordinator WHERE username='$username'");

        if (mysqli_num_rows($emailCheck) > 0) {
            $errorMessage = "Email Already Exists";
        } else if (mysqli_num_rows($usernameCheck) > 0) {
            $errorMessage = "Username Already Exists";
        } else {

            // for image
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
                $sql = "INSERT INTO coordinator SET fname='$fname', mname='$mname', lname='$lname', contact='$contact', email='$email', username='$username', password='$temp_password', picture='$file'";
            } else {
                // Path to the image file
                $filePath = '../../profile_icon.jpg';
                // Read the image file into a variable
                $imageData = file_get_contents($filePath);
                // Escape special characters (optional, depends on usage)
                $imageDataEscaped = addslashes($imageData);
                $sql = "INSERT INTO coordinator SET fname='$fname', mname='$mname', lname='$lname', contact='$contact', email='$email', username='$username', password='$temp_password', picture='$imageDataEscaped'";
            }

            $result = $conn->query($sql);

            if ($result) {
                $successMessage = "Coordinator Added Successfully";
                echo "
                    <script>
                        setTimeout(function() {
                            window.location.href = '../coordinator.php';
                        }, 1500);
                    </script>
                ";
            } else{
                $errorMessage = "Error: " . $conn->error;
            }
        }
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
    <title>Add New Coordinator</title>
</head>
<body>
    <div class="container my-5" style="background-color: gainsboro; padding: 10px;">
        <h2>Add New Coordinator</h2>

        <?php
            if (!empty($errorMessage)) {
                echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <strong>$errorMessage</strong>
                            </div>
                        </div>
                    </div>
                ";
            }
            if (!empty($successMessage)) {
                echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                            </div>
                        </div>
                    </div>
                ";
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
           <!-- div for choose image file -->
            <div class="row mb-3">
                <div class="col-sm-6">
                    <input class="form-control" type="file" name="image" onchange="getImagePreview(event)">
                </div>
                <div class="col-sm-6">
                    <!-- Preview image -->
                    <div class="form-control" style="width:225px;height:215px; border-radius: 100%;">
                        <img id="preview" src="../../profile_icon.jpg" style="width:200px;height:200px; border-radius: 100%;">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="fname" required value="<?php echo $fname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Middle Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="mname" required value="<?php echo $mname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="lname" required value="<?php echo $lname; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Contact</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact" required value="<?php echo $contact; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" required value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" required value="<?php echo $username; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 20px;">Temporary Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="temp_pass" required value="<?php echo $temp_password; ?>">
                </div>
            </div>

            <!-- div for submit button -->
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary" name="insert" id="insert" value="insert">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../coordinator.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <!-- Script to display preview of selected image -->
    <script>
        function getImagePreview(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById('preview');
            preview.src = image;
            preview.style.width = '200px';
            preview.style.height = '200px';
        }
    </script>
</body>
</html>
