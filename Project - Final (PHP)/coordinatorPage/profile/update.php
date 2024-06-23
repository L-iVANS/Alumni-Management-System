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

    $stmt = $conn->prepare("SELECT * FROM coordinator WHERE coor_id = ?");
    $stmt->bind_param("s", $account); // "s" indicates the type is string
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    } else {
        // No user found with the given coor_id
    }

    $stmt->close();
} else {
    echo "User not logged in.";
    header("Location: ../../loginPage/login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Show the data of alumni
    if (!isset($_GET['id'])) {
        header("location: ./profile.php");
        exit;
    }
    $coor_id = $_GET['id'];

    //read data from table alumni
    $sql = "SELECT * FROM coordinator WHERE coor_id=$coor_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: ./profile.php");
        exit;
    }
    // data from table alumni where student_id = $alumni_id = $_GET['id']; get from alumni list update
    $coor_id = $row['coor_id'];
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $contact = $row['contact'];
    $email = $row['email'];
} else {
    // get the data from form
    $coor_id = $_POST['coor_id'];
    $fname = ucwords($_POST['fname']);
    $mname = ucwords($_POST['mname']);
    $lname = ucwords($_POST['lname']);
    $contact = $_POST['contact'];
    $email = strtolower($_POST['email']);

    // email and user existing check
    $emailCheck = mysqli_query($conn, "SELECT * FROM coordinator WHERE email = '$email' AND coor_id != $coor_id");

    if (mysqli_num_rows($emailCheck) > 0) {
        $errorMessage = "Email Already Exists";
    } else {

        $sql = "UPDATE coordinator SET fname='$fname', mname='$mname', lname='$lname', contact='$contact', email='$email' WHERE coor_id = $coor_id";
        $result = $conn->query($sql);
        echo
        "
        <script>
            alert('Info Updated Successfully');
            window.location.href = './profile.php';
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
    <title>Update coordinator Info</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/update_info.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="https://cvsu-imus.edu.ph/student-portal/assets/images/logo-mobile.png"></img><span>CVSU</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <i class="bi bi-person-circle"></i>
                <h4><?php echo $user['fname']; ?></h4>
                <small style="color: white;"><?php echo $user['email']; ?></small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="../dashboard_coor.php">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                        <a href="./update.php" class="active">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                        <a href="../alumni/alumni.php">
                            <span class="las la-th-list" style="color:#fff"></span>
                            <small>ALUMNI</small>
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
                            <span class="las la-clipboard-check" style="color:#fff"></span>
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
                <h1><strong>Profile</strong></h1>
            </div>

            <div class="page-content">
                <?php
                if (!empty($errorMessage)) {
                    echo "<script>alert('$errorMessage');</script>";
                }
                ?>
                <div class="row">
                    <div class="container-fluid" id="main-container">
                        <div class="container-fluid" id="content-container">
                            <div class="information">
                                <form action="update.php" method="POST">
                                    <div class="mb-3">
                                        <input type="hidden" name="coor_id" class="form-control" id="formGroupExampleInput" placeholder="Coordinator Id" value="<?php echo $coor_id; ?>">
                                        <label for="formGroupExampleInput" class="form-label">FIRST NAME</label>
                                        <input type="text" name="fname" class="form-control" id="formGroupExampleInput" placeholder="Enter First Name"required  value="<?php echo htmlspecialchars("$fname"); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">MIDDLE NAME</label>
                                        <input type="text" name="mname" class="form-control" id="formGroupExampleInput" placeholder="Enter Middle Name" value="<?php echo htmlspecialchars("$mname"); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">LAST NAME</label>
                                        <input type="text" name="lname" class="form-control" id="formGroupExampleInput" placeholder="Enter Last Name"required  value="<?php echo htmlspecialchars("$lname"); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">CONTACT NUMBER</label>
                                        <input type="number" name="contact" class="form-control" id="formGroupExampleInput" placeholder="Enter Contact Number"required  value="<?php echo htmlspecialchars("$contact"); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">EMAIL ADDRESS</label>
                                        <input type="email" name="email" class="form-control" id="formGroupExampleInput" placeholder="Enter Email Address" required value="<?php echo htmlspecialchars("$email"); ?>">
                                    </div>
                                    <div class="buttons">
                                        <button type="submit" class="btn" id="button1" value="Update">UPDATE</button>
                                        <a href="./profile.php"><button type="button" class="btn" id="button1">CANCEL</button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- <script>
    let profilePic = document.getElementById("profile-pic");
    let inputFile = document.getElementById("input-file");

    inputFile.onchange = function(){
        profilePic.src = URL.createObjectURL(inputFile.files[0]);
    }
</script> -->

</body>

</html>