<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "alumni_management_system";
$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

// USER ACCOUNT DATA
if (isset($_SESSION['user_id'])) {
    $account = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM coordinator WHERE coor_id = ?");
    $stmt->bind_param("s", $account);
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
    exit;
}

$confirmPass = "";
$newPass = "";
$password = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Show the data of coor
    if (!isset($_GET['id'])) {
        header("location: ./profile.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPass = $_POST['currentPass'];
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];
    $userId = $_GET['id'];

    $query = "SELECT password FROM coordinator WHERE coor_id = $userId";
    $result = mysqli_query($conn, $query);
    $account = mysqli_fetch_assoc($result);

    // Check if the current password is correct
    if ($currentPass !== $account['password']) {
        $errorMessage = "Current password is incorrect.";
    }
    // Check if new password and confirm password match
    elseif ($newPass !== $confirmPass) {
        $errorMessage = "New password and confirm password do not match.";
    } else {
        // Update the password in the database
        $updateQuery = "UPDATE coor SET password = '$newPass' WHERE coor_id = $userId";
        if (mysqli_query($conn, $updateQuery)) {
            echo "
                <script>
                    alert('Password Successfully Changed');
                    window.location.href = './profile.php';
                </script>";
            exit;
        } else {
            $errorMessage = "Error changing password. Please try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Change Password</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/change_pass.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js" integrity="sha512-pBoUgBw+mK85IYWlMTSeBQ0Djx3u23anXFNQfBiIm2D8MbVT9lr+IxUccP8AMMQ6LCvgnlhUCK3ZCThaBCr8Ng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                        <a href="./change_pass.php" class="active">
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
                <h1><strong>Profile</strong></h1>
            </div>

            <div class="container-fluid" id="page-content">
                <?php
                if (!empty($errorMessage)) {
                    echo "<script>alert('$errorMessage');</script>";
                }
                ?>

                <div class="row">
                    <div class="container-fluid" id="main-container">
                        <div class="container-fluid" id="content-container">
                        <span>
                            <h3>CHANGE PASSWORD</h3>
                        </span>
                        <br>
                        <form method="POST">
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">Enter Current Password</label>
                                    <input type="text" name="currentPass" class="form-control" id="formGroupExampleInput" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Change Password</label>
                                    <input type="password" name="newPass" class="form-control" id="formGroupExampleInput2" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPass" class="form-control" id="formGroupExampleInput2" required>
                                </div>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="buttons">
                                            <button type="submit" class="btn" id="button1">CHANGE PASSWORD</button>
                                            <a href="./profile.php"><button type="button" class="btn" id="button2">CANCEL</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</body>

</html>