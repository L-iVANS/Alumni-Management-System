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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Event List</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="css/event.css">
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
                        <a href="../dashboard_user.php">
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
                        <a href="./event.php" class="active">
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

                        <a href="../logout.php">
                            <span class="las la-power-off"></span>
                        </a>

                    </div>
                </div>
            </div>
        </header>


        <main>
            <div class="page-header">
                <h1><strong>Event</strong></h1>
            </div>
        </main>
        <div class="container-fluid" id="page-content">
            <div class="container-fluid" id="content-header">
                <span>
                    <h2>More Details</h2>
                </span>
            </div>
            <div class="container" id="main-container">
                <div class="container-fluid" id="content-container">
                    <div class="row g-0 position-relative">
                        <div class="col-md-6 mb-md-0 p-md-4">
                            <img src="OIP (1).jpg" class="w-100" alt="...">
                        </div>
                        <div class="col-md-6 p-4 ps-md-0" id="right-side">
                            <h3 class="mt-0"> <strong>Event Title</strong></h3>
                            <form action="">
                                <fieldset disabled>
                                    <div class="description">
                                        <label for="" class="form-label">Event Description:</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="10"></textarea>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="row">
                                <div class="container" id="date">
                                    <div class="col">
                                        <form action="">
                                            <fieldset disabled>
                                                <div class="date">
                                                    <label for="" class="form-label mt-3">Event Date & Time:
                                                    </label>
                                                    <input type="date" class="form-control form-label mt-3">
                                                    <input type="time" class="form-control">
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col" id="dropdown">
                                        <select class="form-control" name="course" id="course" required>
                                            <option value="" selected hidden disabled>Are you going to the event?</option>
                                            <option value="BAJ">Interested</option>
                                            <option value="BECEd">Not Interested</option>
                                            <option value="BECEd">Going</option>
                                        </select>
                                        <div class="submit">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <a class="btn btn-light border border-dark" href='./event.php' style="margin-left: 1%; padding-left: 22px; padding-right: 22px;">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script>
        let eventPic = document.getElementById("event-pic");
        let formFile = document.getElementById("formFile");

        formFile.onchange = function() {
            eventPic.src = URL.createObjectURL(formFile.files[0]);
        }
    </script> -->
</body>

</html>