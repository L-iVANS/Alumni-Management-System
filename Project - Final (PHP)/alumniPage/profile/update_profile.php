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

// Close the database connection if needed
// $conn->close();

// FOR PROFILE IMAGE
//read data from table alumni
$sql = "SELECT * FROM alumni WHERE alumni_id=$account";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$file = $row['picture'];

$file = "";
$myId = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Show the data of alumni
    if (!isset($_GET['id'])) {
        header("location: ./alumni.php");
        exit;
    }
    $alumni_id = $_GET['id'];

    //read data from table alumni
    $sql = "SELECT * FROM alumni WHERE alumni_id=$alumni_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: ./alumni.php");
        exit;
    }
    // data from table alumni where student_id = $alumni_id = $_GET['id']; get from alumni list update
    $file = $row['picture'];
} else {

    $alumni_id = $_POST['id'];
    // for image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        $sql = "UPDATE alumni SET picture='$file' WHERE alumni_id=$alumni_id";
    }

    $result = $conn->query($sql);
    echo
    "
        <script>
            alert('Profile Updated Successfully');
            window.location.href = './profile.php?id=$alumni_id';
        </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Update Alumni Profile</title>
    <link rel="shortcut icon" href="../../assets/cvsu.png" type="image/svg+xml">
    <link rel="stylesheet" href="./css/update_profile.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
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
                        <a href="./update_profile.php" class="active">
                            <span class="las la-user-alt" style="color:#fff"></span>
                            <small>PROFILE</small>
                        </a>
                    </li>
                    <li>
                        <a href="../event/event.php">
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
                    <span>Update Profile</span>
                </div>
                <div class="container" id="content">
                    <!-- PROFILE -->
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="container text-center" id="start">
                            <div class="row align-items-end">
                                <div class="col">
                                    <!-- Preview image -->
                                    <div class="form-control" style="width:445px;height:435px; border-radius: 100%;">
                                        <img id="previewTWO" src="data:image/jpeg;base64,<?php echo base64_encode($row['picture']); ?>" style="width:420px;height:420px; border-radius: 100%;">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-end" style="margin-top:5%;">
                                <div class="col">
                                    <input type="hidden" name="id" value="<?php echo $alumni_id; ?>">
                                    <input class="form-control" type="file" name="image" required onchange="getImagePreview(event)">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-warning" name="insert" id="insert" value="insert" style="padding-left: 70px; padding-right: 70px; margin-right: 7%;">Update</button>
                                    <?php
                                    echo "
                                        <a class='btn btn-danger' href='./profile.php' style='padding-left: 70px; padding-right: 70px;'>Cancel</a>
                                        "; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to display preview of selected image -->
    <script>
        var image = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById('preview');
        preview.src = image;
        preview.style.width = '420px';
        preview.style.height = '420px';
    </script>
    <!-- Script to display preview of selected image -->
    <script>
        function getImagePreview(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById('previewTWO');
            preview.src = image;
            preview.style.width = '420px';
            preview.style.height = '420px';
        }
    </script>
    <!-- script to insert image to database -->
    <Script>
        $(document).ready(function() {
            $('#insert').click(function() {
                var image_name = $('#image').val();
                if (image_name == '') {
                    alert("please Select Profile")
                    return false;
                } else {
                    var extension = $('#image').val().split('.').pop().toLowerCase();
                    if (jquery.inArray(extenssion, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        alert("Invalid Image File")
                        $('#image').val('');
                        return false;
                    }
                }
            })
        });
    </Script>
</body>

</html>