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

    $stmt = $conn->prepare("SELECT * FROM alumni WHERE alumni_id = ?");
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


//read data from table alumni
$sql = "SELECT * FROM alumni WHERE alumni_id=$account";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$file = $row['picture'];

<<<<<<< HEAD
//query for events count
$sql_event = "SELECT COUNT(event_id) AS events_count FROM event";

// connect in databse then run the query $sql
$result_event = $conn->query($sql_event);
 // retrieve the data from database
$row_event = $result_event->fetch_assoc();
// get the exact query or in short COUNT(event_id) from table event,  COUNT(event_id) rename as events_count
$event_count = $row_event['events_count'];

=======
>>>>>>> origin/main

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Alumni Dasboard</title>
    <link rel="shortcut icon" href="../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="dashboard_user.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
                <div>
                    <img id="preview" src="data:image/jpeg;base64,<?php echo base64_encode($row['picture']); ?>" style="width:83px;height:83px; border-radius: 100%;border: 2px solid white;">
                </div>
                <h4><?php echo $user['fname']; ?></h4>
                <small style="color: white;"><?php echo $user['email']; ?></small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="./dashboard_user.php" class="active">
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
                        <a href="./event/event.php">
                            <span class="las la-calendar" style="color:#fff"></span>
                            <small>EVENT</small>
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
                <!-- <span class="header-title">ALUMNI MANAGEMENT SYSTEM</span>  -->
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
                <h1><Strong>Dashboard</Strong></h1>
            </div>
        </main>
        <div class="page-content">
            <!--  -->
<<<<<<< HEAD
            <div class="col-md-4">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="las la-calendar-alt fa-3x"></i>
                                <div class="row mb-3">
                                    <!-- Display events Total Count -->
                                    <label style="font-size: 20px;">Events Total Count:</label>
                                    <!-- display events count in database -->
                                    <label class="col-sm-3 col-form-label" style="font-size: 30px;"><?php echo $event_count; ?></label>
                                </div>
                            </div>
                            </div>
                            <a href="event/event.php" class="card-footer d-flex justify-content-between text-white">
                                <span>View Details</span>
                                <i class="las la-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
=======
        </div>
    </div>
>>>>>>> origin/main

    <!-- Script to display preview of selected image -->
    <script>
        function getImagePreview(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById('preview');
            preview.src = image;
            preview.style.width = '83px';
            preview.style.height = '83px';
        }
    </script>
</body>

</html>