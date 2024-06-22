<?php 
    session_start();
    
    if(isset($_GET['id'])){
        $coor_id = $_GET['id'];

    $serername="localhost";
    $db_username="root";
    $db_password="";
    $db_name="alumni_management_system";
    $conn=mysqli_connect($serername, $db_username, $db_password, $db_name);

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
        header("location: ../../loginPage/login.php");
        exit;
    }

    // Close the database connection if needed
    // $conn->close();
    
    //insert data into table alumni_archive from alumni
    $sql_archive = "INSERT INTO coordinator_archive (coor_id, fname, mname, lname, contact, email, password, date_created)" . 
                   "SELECT coor_id, fname, mname, lname, contact, email, password, date_created FROM coordinator WHERE coor_id=$coor_id";
    $conn->query($sql_archive);

    //delete data in table alumni
    $sql_delete = "DELETE FROM coordinator WHERE coor_id=$coor_id";
    $conn->query($sql_delete);
    }
    header("location: ./coordinator.php");
    exit;
?>