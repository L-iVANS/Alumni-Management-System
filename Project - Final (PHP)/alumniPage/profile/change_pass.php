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

    $stmt = $conn->prepare("SELECT * FROM alumni WHERE alumni_id = ?");
    $stmt->bind_param("s", $account);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
    } else {
        // No user found with the given alumni_id
    }

    $stmt->close();
} else {
    echo "User not logged in.";
    header("Location: ../../loginPage/login.php");
    exit();
}

// FOR PROFILE IMAGE
//read data from table alumni
$sql = "SELECT * FROM alumni WHERE alumni_id=$account";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$file = $row['picture'];

$pass = "";
$confirm_pass = "";
$new_pass = "";
$password = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Show the data of admin
    if (!isset($_GET['id'])) {
        header("location: ./profile.php");
        exit;
    }
    $alumni_id = $_GET['id'];

    // Read data from table admin
    $sql = "SELECT * FROM alumni WHERE alumni_id=$alumni_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: ./profile.php");
        exit;
    }

    $alumni_id = $row['alumni_id'];
    $password = $row['password'];
} else {
    // Get the data from form
    $alumni_id = $_POST['alumni_id'];
    $current_password = $_POST['current_password'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];
    $new_pass = $_POST['new_pass'];
    $errorMessage = "";

    if ($current_password == $pass) {
        if ($new_pass == $confirm_pass) {
            $sql = "UPDATE alumni SET password ='$new_pass' WHERE alumni_id = $alumni_id";
            $result = $conn->query($sql);
            echo "
            <script>
                alert('Password Successfully Changed');
                window.location.href = './profile.php';
            </script>";
        } 
        if($new_pass != $confirm_pass) {
            $errorMessage = "New Password and Confirm Password Don't Match";
        }
    } else {
        $errorMessage = "Incorrect Current Password";
    }

    // Reset the form variables
    $pass = "";
    $confirm_pass = "";
    $new_pass = "";
    $current_password = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Change Admin Password</title>
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
                        <a href="./change_pass.php" class="active">
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
                <h1><strong>Profile</strong></h1>
            </div>

            <div class="container-fluid" id="page-content">
                <?php
                // Display the error message if it exists
                if (!empty($errorMessage)) {
                    echo "<script>alert('$errorMessage');</script>";
                }
                ?>
                <span>
                    <h2>CHANGE PASSWORD</h2>
                </span>

                <div class="row">
                    <div class="container-fluid" id="main-container">
                        <div class="container-fluid" id="content-container">
                            <form method="POST">
                                <div class="mb-3">
                                    <input type="hidden" name="alumni_id" class="form-control" id="formGroupExampleInput" value="<?php echo $alumni_id; ?>">
                                    <input type="hidden" name="current_password" class="form-control" id="formGroupExampleInput" value="<?php echo $row['password']; ?>">
                                    <label for="formGroupExampleInput" class="form-label">Enter Current Password</label>
                                    <input type="text" name="password" class="form-control" id="formGroupExampleInput" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Change Password</label>
                                    <input type="text" name="new_pass" class="form-control" id="formGroupExampleInput2" required>
                                </div>
                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Confirm Password</label>
                                    <input type="text" name="confirm_pass" class="form-control" id="formGroupExampleInput2" required>
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