<?php
session_start();

$serername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "alumni_management_system";
$conn = mysqli_connect($serername, $db_username, $db_password, $db_name);

// USER ACCOUNT DATA
if (isset($_SESSION['user_id'])) {
    $account = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $stmt->bind_param("s", $account); // "s" indicates the type is string
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    } else {
        // No user found with the given admin_id
    }

    $stmt->close();
} else {
    echo "User not logged in.";
}

// Close the database connection if needed
// $conn->close();

$stud_id = "";
$fname = "";
$mname = "";
$lname = "";
$gender = "";
$course = "";
$fromYear = "";
$toYear = "";
$connected_to = "";
$contact = "";
$address = "";
$email = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Show the data of alumni
    if (!isset($_GET['id'])) {
        header("location: ./alumni.php");
        exit;
    }
    $alumni_id = $_GET['id'];

    //read data from table alumni
    $sql = "SELECT * FROM alumni WHERE alumni_id=$alumni_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: ./alumni.php");
        exit;
    }
    // data from table alumni where student_id = $alumni_id = $_GET['id']; get from alumni list update
    $stud_id = $row['student_id'];
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $gender = $row['gender'];
    $course = $row['course'];
    $fromYear = $row['batch_startYear'];
    $toYear = $row['batch_endYear'];
    $connected_to = $row['connected_to'];
    $contact = $row['contact'];
    $address = $row['address'];
    $email = $row['email'];
    $username = $row['username'];
    $file = $row['picture'];
} else {
    // get the data from form
    $alumni_id = $_POST['id'];
    $stud_id = $_POST['student_id'];
    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $fromYear = $_POST['startYear'];
    $toYear = $_POST['endYear'];
    $connected_to = ucwords($_POST['connected_to']);
    $contact = $_POST['contact'];
    $address = ucwords($_POST['address']);
    $email = $_POST['email'];
    $username = $_POST['username'];

    // for image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        $sql = "UPDATE alumni SET student_id='$stud_id', fname='$fname', mname='$mname', lname='$lname', gender='$gender', course='$course', batch_startYear='$fromYear', batch_endYear='$toYear', connected_to='$connected_to', contact='$contact', address='$address', email='$email', username='$username', picture='$file' WHERE alumni_id=$alumni_id";
    } else {
        // Path to the image file
        // $filePath = '../../profile_icon.jpg';
        // // Read the image file into a variable
        // $imageData = file_get_contents($filePath);
        // // Escape special characters (optional, depends on usage)
        // $imageDataEscaped = addslashes($imageData);
        $sql = "UPDATE alumni SET student_id='$stud_id', fname='$fname', mname='$mname', lname='$lname', gender='$gender', course='$course', batch_startYear='$fromYear', batch_endYear='$toYear', connected_to='$connected_to', contact='$contact', address='$address', email='$email', username='$username' WHERE alumni_id=$alumni_id";
    }

    $result = $conn->query($sql);
    echo
    "
        <script>
            alert('Alumni Info Updated Successfully');
            window.location.href = './alumni.php';
        </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Update Alumni Info</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/add_alumni.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="https://cvsu-imus.edu.ph/student-portal/assets/images/logo-mobile.png"></img><span>CVSU</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <i class='bx bx-user bx-flip-horizontal'></i>
                <h4><?php echo $user['fname']; ?></h4>
                <small style="color: white;"><?php echo $user['email']; ?></small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="../dashboard_admin.php">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                        <a href="../profile/profile.php">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                        <a href="./update_alumni.php" class="active">
                            <span class="las la-th-list" style="color:#fff"></span>
                            <small>ALUMNI</small>
                        </a>
                    </li>
                    <li>
                        <a href="../coordinator/coordinator.php">
                            <span class="las la-user-cog" style="color:#fff"></span>
                            <small>COORDINATOR</small>
                        </a>
                    </li>
                    <li>
                        <a href="../event/event.php">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
                        </a>
                    </li>
                    <li>
                        <a href="../settings/about.php">
                            <span class="las la-cog" style="color:#fff"></span>
                            <small>SETTINGS</small>
                        </a>
                    </li>
                    <li>
                        <a href="../report/report.php">
                            <span class="las la-clipboard-check" style="color:#fff"></span>
                            <small>REPORT</small>
                        </a>
                    </li>
                    <li>
                        <a href="../archive/alumni_archive.php">
                            <span class="las la-archive" style="color:#fff"></span>
                            <small>ARCHIVE</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">

        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars bars" style="color: white;"></span>
                </label>
                <div class="header-menu">
                    <label for="">
                    </label>
                    <div class="user">
                        <a href="../logout.php">
                            <span class="las la-power-off" style="font-size: 30px; border-left: 1px solid #fff; padding-left:10px; color:#fff"></span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="page-header">
                <h1><strong>Alumni</strong></h1>
            </div>
        </main>
        <div class="container" id="container-full">
            <div class="container" id="content-container">
                <div class="container-title">
                    <span>Update Alumni Info</span>
                </div>
                <div class="container" id="content">
                    <!-- PROFILE -->
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="container text-center" id="start">
                            <div class="row align-items-end">
                                <div class="col">
                                    <!-- Preview image -->
                                    <div class="form-control" style="width:225px;height:215px; border-radius: 100%;">
                                        <img id="preview" src="data:image/jpeg;base64,<?php echo base64_encode($row['picture']); ?>" style="width:200px;height:200px; border-radius: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="container text-center" id="start">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="first-name">Profile Picture :</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="file" name="image" onchange="getImagePreview(event)">
                                </div>
                            </div>
                        </div>


                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <input type="hidden" name="id" value="<?php echo $alumni_id; ?>">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="first-name">Student ID:</label>
                                </div>

                                <div class="col">
                                    <input class="form-control" type="number" id="name" name="student_id" placeholder="Student ID" required value="<?php echo $stud_id; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">

                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="first-name">First Name:</label>
                                </div>

                                <div class="col">
                                    <input class="form-control" type="text" id="name" name="fname" placeholder="First Name" required value="<?php echo $fname; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="middle-name">Middle Name:</label>
                                </div>

                                <div class="col">
                                    <input class="form-control" type="text" id="name" name="mname" placeholder="Middle Name" value="<?php echo $mname; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="last-name">Last Name:</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="text" id="name" name="lname" placeholder="Last Name" required value="<?php echo $lname; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="name">Gender:</label>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="<?php echo $gender; ?>" selecte> <?php echo $gender; ?> </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="name">Course:</label>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="course" id="course" required>
                                        <option value="<?php echo $course; ?>" selected><?php echo $course; ?></option>
                                        <option value="BAJ">BAJ</option>
                                        <option value="BECEd">BECEd</option>
                                        <option value="BEEd">BEEd</option>
                                        <option value="BSBM">BSBM</option>
                                        <option value="BSOA">BSOA</option>
                                        <option value="BSEntrep">BSEntrep</option>
                                        <option value="BSHM">BSHM</option>
                                        <option value="BSIT">BSIT</option>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BSc(Psych)">BSc(Psych)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col" id="calendar">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="phone"><span>Batch:</span></label>
                                </div>

                                <div class="col" id="batch">
                                    <select class="form-control" name="startYear" id="startYear" required>
                                        <option value="<?php echo $fromYear; ?>" selected><?php echo $fromYear; ?></option>
                                        <?php
                                        // Get the current year
                                        $currentYear = date('Y');

                                        // Number of years to include before and after the current year
                                        $yearRange = 21; // Adjust this number as needed

                                        // Generate options for years, from current year minus $yearRange to current year plus $yearRange
                                        for ($year = $currentYear - $yearRange; $year <= $currentYear + $yearRange; $year++) {
                                            echo "<option value=\"$year\">$year</option>";
                                        }
                                        ?>
                                    </select>

                                    <select class="form-control" name="endYear" id="endYear" required>
                                        <option value="<?php echo $toYear; ?>" selected><?php echo $toYear; ?></option>
                                        <?php
                                        // Get the current year
                                        $currentYear = date('Y');

                                        // Number of years to include before and after the current year
                                        $yearRange = 21; // Adjust this number as needed

                                        // Generate options for years, from current year minus $yearRange to current year plus $yearRange
                                        for ($year = $currentYear - $yearRange; $year <= $currentYear + $yearRange; $year++) {
                                            echo "<option value=\"$year\">$year</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="name">Connected to:</label>
                                </div>

                                <div class="col">
                                    <input class="form-control" class="form-control" type="text" id="name" name="connected_to" placeholder="Company" required value="<?php echo $connected_to; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="name">Contact:</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="number" id="name" name="contact" placeholder="Enter Phone No." required value="<?php echo $contact; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="name">Address:</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="address" id="address" name="address" placeholder="Enter Address" required value="<?php echo $address; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="name">Email:</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email" required value="<?php echo $email; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="username">Username:</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="text" id="username" name="username" placeholder="Enter Username" required value="<?php echo $username; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row" style="margin-top:20px;">
                                <div class="col" id="buttons">
                                    <div class="button">
                                        <button type="submit" class="btn btn-warning" name="insert" id="insert" value="insert">Update</button>
                                        <a class="btn btn-danger" href="./alumni.php">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
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
    <!-- script to insert image to database -->
    <Script>
        $(document).ready(function() {
            $('#insert').click(function() {
                var image_name = $('#image').val();
                if (image_name == '') {
                    alert("please Select Profile")
                    return false;
                } else {
                    var extension = $('#image').val().split('.').pop().toLowerCase();
                    if (jquery.inArray(extenssion, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
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