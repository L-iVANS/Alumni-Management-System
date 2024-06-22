<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "alumni_management_system";
$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
        echo "No user found.";
        exit();
    }

    $stmt->close();
} else {
    echo "User not logged in.";
    exit();
}

// Form data handling and SQL query preparation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $lname = ucwords($lname);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $fname = ucwords($fname);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $mname = ucwords($mname);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // SQL update statement using prepared statement for security
    $sql = "UPDATE `coordinator` SET lname=?, fname=?, mname=?, contact=?, email=? WHERE coor_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $lname, $fname, $mname, $contact, $email, $account);

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

// Close the database connection
mysqli_close($conn);
?>



$conn->close();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Update Coordinators Info</title>
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
                       <a href="../dashboard_coor.php" >
                            <span class="las la-home" style="color:#fff"></span>
                            <small>DASHBOARD</small>
                        </a>
                    </li>
                    <li>
                       <a href="./profile.php"class="active">
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
            <h1><strong>Update Coordinators Info</strong></h1> 
            </div>
            
    <div class="page-content">
        
        

        <div class="row">
            <div class="container-fluid" id="main-container">
                <div class="container-fluid" id="content-container">
                    <div class="information">
                        <form action="update_info.php" method="POST">
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
                                <label for="formGroupExampleInput" class="form-label">CONTACT NUMBER</label>
                                <input type="num" name="contact" class="form-control" id="formGroupExampleInput" placeholder="Enter Contact Number">
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">EMAIL ADDRESS</label>
                                <input type="email" name="email" class="form-control" id="formGroupExampleInput" placeholder="Enter Email Address">
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
