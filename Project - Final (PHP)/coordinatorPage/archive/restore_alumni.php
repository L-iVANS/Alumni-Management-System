<?php
session_start();
if (isset($_GET['id'])) {
    $alumni_id = $_GET['id'];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "alumni_management_system";
    $conn = new mysqli($servername, $db_username, $db_password, $db_name);

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    $account = $_SESSION['user_id'];
    $account_email = $_SESSION['user_email'];

    // Check if user is an admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ? AND email = ?");
    $stmt->bind_param("ss", $account, $account_email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        // User is an admin
        header('Location: ../../adminPage/dashboard_admin.php');
        exit();
    }
    $stmt->close();

    // Check if user is a coordinator
    $stmt = $conn->prepare("SELECT * FROM coordinator WHERE coor_id = ? AND email = ?");
    $stmt->bind_param("ss", $account, $account_email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        // User is a coordinator
        $user = $user_result->fetch_assoc();
    }
    $stmt->close();

    // Check if user is an alumni
    $stmt = $conn->prepare("SELECT * FROM alumni WHERE alumni_id = ? AND email = ?");
    $stmt->bind_param("ss", $account, $account_email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows > 0) {
        // User is an alumni
        header('Location: ../../alumniPage/dashboard_user.php');
        exit();
    }
    $stmt->close();
    
} else {
    header('Location: ../../homepage.php');
    exit();
}
    // Close the database connection if needed
    // $conn->close();

    if (mysqli_connect_errno()) {
        die("" . mysqli_connect_error());
    } else {
        echo "Successfully Connected!";
    }
    //insert data into table alumni_archive from alumni
    $sql_restore = "INSERT INTO alumni (alumni_id, student_id, fname, mname, lname, gender, course, batch_startYear, batch_endYear, contact, address, email, password, picture, date_created)" .
        "SELECT alumni_id, student_id, fname, mname, lname, gender, course, batch_startYear, batch_endYear, contact, address, email, password, picture, date_created FROM alumni_archive WHERE alumni_id=$alumni_id";
    $conn->query($sql_restore);

    //delete data in table alumni
    $sql_delete = "DELETE FROM alumni_archive WHERE alumni_id=$alumni_id";
    $conn->query($sql_delete);
}
$transfer = $alumni_id;
header("Location: ./alumni_archive.php?ide=$transfer");
exit;
?>