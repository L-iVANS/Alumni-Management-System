
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
<html>
<head>
    <title>Update Form</title>
</head>
<body>
    <form action="tryupdate.php" method="POST">
        <label>Last name:</label><br>
        <input type="text" name="lname" placeholder="Enter new Last name"><br>
        <label>First name:</label><br>
        <input type="text" name="fname" placeholder="Enter new First name"><br>
        <label>Middle name:</label><br>
        <input type="text" name="mname" placeholder="Enter new Middle Name"><br>
        <label>Username:</label><br>
        <input type="text" name="username" placeholder="Enter new username"><br>
        <label>Contact:</label><br>
        <input type="text" name="contact" placeholder="Enter new contact"><br>
        <label>Email:</label><br>
        <input type="text" name="email" placeholder="Enter new email"><br>
        <button type="submit" class="btn" id="button1" value="Update">UPDATE</button>
        <a href="./profile.php"><button type="button" class="btn" id="button1">CANCEL</button></a>
    </form>
</body>
</html>