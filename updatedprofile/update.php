<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alumni_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data handling and SQL query preparation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you want to update the record with admin_id = 1
    $id = 1; 
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $lname = ucwords($lname);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $fname = ucwords($fname);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $mname = ucwords($mname);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // SQL update statement using prepared statement for security
    $sql = "UPDATE `admin` SET lname=?, fname=?, mname=?, username=?, contact=?, email=? WHERE admin_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $lname, $fname, $mname, $username, $contact, $email, $id);

    if ($stmt->execute()) {
        // Success message
        echo '<script>alert("Update successful");</script>';
        // Redirect after a brief delay to ensure the alert is displayed
        echo '<script>setTimeout(function(){ window.location.href = "profile.php"; }, 1000);</script>';
    } else {
        // Error message
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Update Admin Info</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/update_info.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                <h4>ADMIN</h4>
                <small style="color: white;">admin@email.com</small>
            </div>

            <div class="side-menu">
            <ul>
                    <li>
                       <a href="../dashboard_admin.php" >
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                       <a href="./update.php"class="active">
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
        
        

        <div class="row">
            <div class="container-fluid" id="main-container">
                <div class="container-fluid" id="content-container">
                <div class="information">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">LAST NAME</label>
                            <input type="text" name="lname" class="form-control" id="formGroupExampleInput" placeholder="Enter Last Name">
                          </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">FIRST NAME</label>
                            <input type="text" name="fname" class="form-control" id="formGroupExampleInput" placeholder="Enter First Name">
                          </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">MIDDLE NAME</label>
                            <input type="text" name="mname" class="form-control" id="formGroupExampleInput" placeholder="Enter Middle Name">
                          </div>
                          <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">USERNAME</label>
                            <input type="text" name="username" class="form-control" id="formGroupExampleInput2" placeholder="Enter Username">
                          </div>                                                   
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">CONTACT NUMBER</label>
                            <input type="num" name="contact" class="form-control" id="formGroupExampleInput" placeholder="Enter Contact Number">
                          </div>
                          <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control" id="formGroupExampleInput2" placeholder="Enter Email Address">
                          </div>                                                                                                      
                          <div class="buttons">
                              <a href ="./profile.php"><button type="submit" class="btn" id="button1">UPDATE</button></a>
                              <a href="./profile.php"><button type="button" class="btn" id="button1">CANCEL</button></a>
                          </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
