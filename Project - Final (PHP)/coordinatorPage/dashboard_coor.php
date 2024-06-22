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
        // No user found with the given admin_id
    }

    $stmt->close();
} else {
    echo "User not logged in.";
}

//query for alumni count
$sql = "SELECT COUNT(student_id) AS alumni_count FROM alumni";

// connect in databse then run the query $sql
$result = $conn->query($sql);
// retrieve the data from database
$row = $result->fetch_assoc();

// get the exact query or in short COUNT(student_id) from table alumni,  COUNT(student_id) rename as alumni_count
$count = $row['alumni_count'];

//query for events count
$sql_event = "SELECT COUNT(event_id) AS events_count FROM event";

// connect in databse then run the query $sql
$result_event = $conn->query($sql_event);
 // retrieve the data from database
$row_event = $result_event->fetch_assoc();
// get the exact query or in short COUNT(event_id) from table event,  COUNT(event_id) rename as events_count
$event_count = $row_event['events_count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Coordinator Dashboard</title>
    <link rel="shortcut icon" href="../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="./dashboard.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                       <a href="./dashboard_coor.php" class="active">
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                       <a href="./profile/profile.php">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                       <a href="./alumni/alumni.php">
                            <span class="las la-th-list" style="color:#fff"></span>
                            <small>ALUMNI</small>
                        </a>
                    </li>
                    <li>
                       <a href="./event/event.php">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
                        </a>
                    </li>
                    <li>
                       <a href="./settings/about.php">
                            <span class="las la-cog" style="color:#fff"></span>
                            <small>SETTINGS</small>
                        </a>
                    </li>
                    <li>
                       <a href="./report/report.php">
                            <span class="las la-clipboard-check" style="color:#fff"></span>
                            <small>REPORT</small>
                        </a>
                    </li>
                    <li>
                        <a href="./archive/alumni_archive.php">
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
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                    </label>
                    
                    <div class="notify-icon">
                    </div>
                    
                    <div class="notify-icon">   
                    </div>
                    
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                        <a href="./logout.php">
                        <span class="las la-power-off"></span>
                        </a>

                    </div>
                </div>
            </div>
        </header>
        
         
            <main>
            
                <div class="page-header">
                    <h1>Dashboard</h1>
                </div>
                
                <div class="page-content">
                    <!-- Dashboard Items Start -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="las la-user-graduate fa-3x"></i>
                                                <div class="row mb-3">
                                                        <!-- display Alumni Total Count -->
                                                        <label style="font-size: 20px;">Alumni Total Count:</label>
                                                        <!-- display alumni count in database -->
                                                        <label class="col-sm-3 col-form-label" style="font-size: 30px;"><?php echo $count; ?></label>
                                                </div>
                                        </div>
                                    </div>
                                    <a href="alumni/alumni.php" class="card-footer d-flex justify-content-between text-white">
                                        <span>View Details</span>
                                        <i class="las la-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="las la-calendar-alt fa-3x"></i>
                                                <div class="row mb-3">
                                                    <!-- Display Student Total Count -->
                                                    <label style="font-size: 20px;">Events Total Count:</label>
                                                    <!-- display events count in database -->
                                                    <label class="col-sm-3 col-form-label" style="font-size: 30px;"><?php echo $event_count; ?></label>
                                                </div>
                                        </div>
                                    </div>
                                    <a href="event.php" class="card-footer d-flex justify-content-between text-white">
                                        <span>View Details</span>
                                        <i class="las la-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="las la-users fa-3x"></i>
                                            <div class="ml-4">
                                                <h5>Total Visits</h5>
                                                <h2>10,000</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="report.php" class="card-footer d-flex justify-content-between text-white">
                                        <span>View Details</span>
                                        <i class="las la-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dashboard Items End -->
                </div>
            
            </main>
    </div>
</body>
</html>