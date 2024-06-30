<?php
session_start();
if (isset($_GET['id'])) {
    $alumni_id = $_GET['id'];

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
        echo "User not logged in.";
        header("location: ../../loginPage/login.php");
        exit;
    }

    // Close the database connection if needed
    // $conn->close();

    if (mysqli_connect_errno()) {
        die("" . mysqli_connect_error());
    } else {
        echo "Successfully Connected!";
    }
    //insert data into table alumni_archive from alumni
    $sql_restore = "INSERT INTO alumni (student_id, fname, mname, lname, gender, course, batch_startYear, batch_endYear, contact, address, email, password, picture, date_created)" .
        "SELECT student_id, fname, mname, lname, gender, course, batch_startYear, batch_endYear, contact, address, email, password, picture, date_created FROM pending WHERE alumni_id=$alumni_id";
    $conn->query($sql_restore);

    //delete data in table alumni
    $sql_delete = "DELETE FROM pending WHERE alumni_id=$alumni_id";
    $conn->query($sql_delete);
}
echo
"
        <script>
            alert('Alumni Acccount Accepted!');
            window.location.href = './pending.php';
        </script>
    ";