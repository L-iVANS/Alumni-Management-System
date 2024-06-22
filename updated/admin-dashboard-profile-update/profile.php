<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "alumni_management_system";
$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// USER ACCOUNT DATA
if (isset($_SESSION['user_id'])) {
    $account = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $stmt->bind_param("s", $account); // "s" indicates the type is string
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        // Assign fetched data to variables
        $fname = $user['fname'];
        $mname = $user['mname'];
        $lname = $user['lname'];
        $contact = $user['contact'];
        $email = $user['email'];
        $password = $user['password'];
    } else {
        echo "No user found with the given admin_id.";
        exit;
    }

    $stmt->close();
} else {
    echo "User not logged in.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin Profile</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
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
                <h4><?php echo htmlspecialchars($fname); ?></h4>
                <small style="color: white;"><?php echo htmlspecialchars($email); ?></small>
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
                       <a href="./profile.php" class="active">
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
                    <label for=""></label>
                    
                    <div class="user">
                        <a href="../logout.php">
                            <span class="las la-power-off" style="font-size: 30px; border-left: 1px solid #fff; padding-left:10px; color:#fff"></span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <main>
            <div class="page-header" style="color: #74767d;">
                <h1><strong>Profile</strong></h1>
            </div>
            <div class="page-content">
                <div class="container-fluid" id="container-main">
                    <div class="row">
                        <div class="container-fluid">
                            <div class="container-fluid" id="content-container">
                                <div class="information">
                                    <form>
                                        <fieldset disabled>
                                            <div class="mb-3">
                                                <label for="disabledTextInput" class="form-label">ADMIN FULL NAME</label>
                                                <input fname="adminfullname" id="disabledTextInput" class="form-control" placeholder="First name" value="<?php echo htmlspecialchars("$fname $mname $lname"); ?>" />
                                            </div>                                                  
                                            <div class="mb-3">
                                                <label for="disabledTextInput" class="form-label">CONTACT NUMBER</label>
                                                <input contact="username" id="disabledTextInput" class="form-control" placeholder="contact" value="<?php echo htmlspecialchars($contact); ?>" />
                                            </div>                          
                                            <div class="mb-3">
                                                <label for="disabledTextInput" class="form-label">EMAIL ADDRESS</label>
                                                <input email="email" id="disabledTextInput" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" />
                                            </div>                          
                                            <div class="mb-3">
                                                <label for="disabledTextInput" class="form-label">PASSWORD</label>
                                                <input password="password" id="disabledTextInput" class="form-control" placeholder="Password" value="<?php echo htmlspecialchars($password); ?>" />
                                            </div>                          
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="buttons">
                                    <a href="./update.php"><button type="button" class="btn" id="button1">UPDATE INFO</button></a>
                                    <a href="./change_pass.php"><button type="button" class="btn" id="button2">CHANGE PASSWORD</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </main>
    </div>
</body>
</html>
