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
    header("Location: ../../loginPage/login.php");
    exit();
}

// Assuming you have a user ID stored in a variable $user_id
$sql = "SELECT * FROM admin WHERE admin_id = $user[admin_id]";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data
    $row = $result->fetch_assoc();

    // Assign fetched data to variables
    $admin_id = $row['admin_id'];
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $contact = $row['contact'];
    $email = $row['email'];
    $password = $row['password'];
    // Add more fields as needed
} else {
    echo "0 results";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Update About</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="./css/contact.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="https://cvsu-imus.edu.ph/student-portal/assets/images/logo-mobile.png"><span>CVSU</span></h3>
        </div>
        <div class="side-content">
            <div class="profile">
                <i class="bi bi-person-circle"></i>
                <h4><?php echo $user['fname']; ?></h4>
                <small style="color: white;"><?php echo $user['email']; ?></small>
            </div>
            <div class="side-menu">
                <ul>
                    <li><a href="../dashboard_admin.php"><span class="las la-home" style="color:#fff"></span><small>DASHBOARD</small></a></li>
                    <li><a href="../profile/profile.php"><span class="las la-user-alt" style="color:#fff"></span><small>PROFILE</small></a></li>
                    <li><a href="../alumni/alumni.php"><span class="las la-th-list" style="color:#fff"></span><small>ALUMNI</small></a></li>
                    <li><a href="../coordinator/coordinator.php"><span class="las la-user-cog" style="color:#fff"></span><small>COORDINATOR</small></a></li>
                    <li><a href="../event/event.php"><span class="las la-calendar" style="color:#fff"></span><small>EVENT</small></a></li>
                    <li><a href="./about.php" class="active"><span class="las la-cog" style="color:#fff"></span><small>SETTINGS</small></a></li>
                    <li><a href="../report/report.php"><span class="las la-clipboard-check" style="color:#fff"></span><small>REPORT</small></a></li>
                    <li><a href="../archive/alumni_archive.php"><span class="las la-archive" style="color:#fff"></span><small>ARCHIVE</small></a></li>
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
                <h1><strong>Settings</strong></h1>
            </div>
            <form class="form-style">
                <div class="d-flex justify-content-end my-3">
                    <ul class="nav nav-pills custom-nav-pills" id="myTab" role="tablist">
                        <li class="nav-item mx-4">
                            <button class="btn btn-secondary border border-dark" id="about-tab" type="button" role="tab" aria-controls="contact" aria-selected="true" onclick="location.href='about.php'" style="padding-left: 55px; padding-right: 55px;">About</button>
                        </li>
                        <li class="nav-item mx-4">
                            <button class="btn btn-light border border-dark" id="contact-tab" type="button" role="tab" aria-controls="contact" aria-selected="false" onclick="location.href='contact.php'" style="padding-left: 48px; padding-right: 48px;">Contact</button>
                        </li>
                    </ul>
                </div>
              
               <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <form id="aboutForm" class="mt-4">
                            <div class="mb-3">
                                <label for="pageTitle">Page Title</label>
                                <input type="text" class="form-control" id="pageTitle" value="About Us">
                            </div>
                            <div class="mb-3">
                                <label for="pageDescription">Page Description</label>
                                <textarea class="form-control" id="pageDescription" rows="5">Description</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" value="The Team">
                            </div>
                            <div class="mb-3">
                                <label for="upload" class="form-label">Upload</label>
                                <input class="form-control" type="file" id="upload">
                                <div class="mt-3">
                                    <img src="/mnt/data/image.png" alt="Upload Image" class="img-thumbnail">
                                </div>
                            </div>
                            <button class="btn btn-warning" style="padding-left: 50px; padding-right: 50px;">Update</button>
                        </form>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>