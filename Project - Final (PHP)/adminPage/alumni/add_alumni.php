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
$temp_password = "";

// get the data from form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    $temp_password = $_POST['temp_pass'];


    // email and user existing check
    $emailCheck = mysqli_query($conn, "SELECT * FROM alumni WHERE email='$email'");
    $usernameCheck = mysqli_query($conn, "SELECT * FROM alumni WHERE username='$username'");

    if (mysqli_num_rows($emailCheck) > 0) {
        $errorMessage = "Email Already Exists";
        // echo "
        //         <script>
        //             alert('Email Already Exist!!!');
        //             window.location.href = '../coordinator.php';
        //         </script>
        //     ";
    } else if (mysqli_num_rows($usernameCheck) > 0) {
        $errorMessage = "Username Already Exists";
        // echo "
        //         <script>
        //             alert('Username Already Exist!!!');
        //             window.location.href = '../coordinator.php';
        //         </script>
        //     ";
    } else {

        $sql = "INSERT INTO alumni SET student_id='$stud_id', fname='$fname', mname='$mname', lname='$lname', gender='$gender', course='$course', batch_startYear='$fromYear', batch_endYear='$toYear', connected_to='$connected_to', contact='$contact', address='$address', email='$email', username='$username', password='$temp_password'";
        $result = $conn->query($sql);
        echo
        "
        <script>
            alert('Alumni Added Successfully');
            window.location.href = './alumni.php';
        </script>
    ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Add New Alumni</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="./css/add_alumni.css">
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
                        <a href="./add_alumni.php" class="active">
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
                    <span>ADD ALUMNI</span>
                </div>

                <?php
                if (!empty($errorMessage)) {
                    echo "<script>alert('$errorMessage');</script>";
                }
                ?>

                <div class="container" id="content">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="container">
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="Student ID">Student ID:</label>
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
                                        <option value="" selected hidden disabled>Select a Gender</option>
                                        <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
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
                                        <option value="" selected hidden disabled>Select a course</option>
                                        <option value="BAJ" <?php echo ($course == 'BAJ') ? 'selected' : ''; ?>>BAJ</option>
                                        <option value="BECEd" <?php echo ($course == 'BECEd') ? 'selected' : ''; ?>>BECEd</option>
                                        <option value="BEEd" <?php echo ($course == 'BEEd') ? 'selected' : ''; ?>>BEEd</option>
                                        <option value="BSBM" <?php echo ($course == 'BSBM') ? 'selected' : ''; ?>>BSBM</option>
                                        <option value="BSOA" <?php echo ($course == 'BSOA') ? 'selected' : ''; ?>>BSOA</option>
                                        <option value="BSEntrep" <?php echo ($course == 'BSEntrep') ? 'selected' : ''; ?>>BSEntrep</option>
                                        <option value="BSHM" <?php echo ($course == 'BSHM') ? 'selected' : ''; ?>>BSHM</option>
                                        <option value="BSIT" <?php echo ($course == 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
                                        <option value="BSCS" <?php echo ($course == 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
                                        <option value="BSc(Psych)" <?php echo ($course == 'BSc(Psych)') ? 'selected' : ''; ?>>BSc(Psych)</option>
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
                                        <option value="" selected hidden disabled>Batch: From Year</option>
                                        <?php
                                        // Get the current year
                                        $currentYear = date('Y');

                                        // Number of years to include before and after the current year
                                        $yearRange = 21; // Adjust this number as needed

                                        // Preserve the selected value after form submission
                                        $selectedYear = isset($_POST['startYear']) ? $_POST['startYear'] : '';

                                        // Generate options for years, from current year minus $yearRange to current year plus $yearRange
                                        for ($year = $currentYear - $yearRange; $year <= $currentYear + $yearRange; $year++) {
                                            $selected = ($year == $selectedYear) ? 'selected' : '';
                                            echo "<option value=\"$year\" $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                    <select class="form-control" name="endYear" id="endYear" required>
                                        <option value="" selected hidden disabled>Batch: To Year</option>
                                        <?php
                                        // Get the current year
                                        $currentYear = date('Y');

                                        // Number of years to include before and after the current year
                                        $yearRange = 21; // Adjust this number as needed

                                        // Preserve the selected value after form submission
                                        $selectedEndYear = isset($_POST['endYear']) ? $_POST['endYear'] : '';

                                        // Generate options for years, from current year minus $yearRange to current year plus $yearRange
                                        for ($year = $currentYear - $yearRange; $year <= $currentYear + $yearRange; $year++) {
                                            $selected = ($year == $selectedEndYear) ? 'selected' : '';
                                            echo "<option value=\"$year\" $selected>$year</option>";
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
                            <div class="row align-items-end">
                                <div class="col">
                                    <label class="col-sm-3 col-form-label" style="font-size: 20px;" for="username">Temporary Password:</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="text" id="temp_pass" name="temp_pass" placeholder="Enter Password" required value="<?php echo $temp_password; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row" style="margin-top:20px;">
                                <div class="col" id="buttons">
                                    <div class="button">
                                        <button type="submit" class="btn btn-warning" name="insert" id="insert" value="insert">Add new</button>
                                        <a class="btn btn-danger" href="./alumni.php">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>