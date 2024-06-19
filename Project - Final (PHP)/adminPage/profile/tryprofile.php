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


// Assuming you have a user ID stored in a variable $user_id
$sql = "SELECT * FROM `admin` WHERE 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data
    $row = $result->fetch_assoc();

    // Assign fetched data to variables
    $fname = $row['fname'];
    $mname = $row['mname'];
    $lname = $row['lname'];
    $username = $row['username'];
    $contact = $row['contact'];
    $email = $row['email'];
    $password = $row['password'];
    // Add more fields as needed
} else {
    echo "0 results";
}

$conn->close(); // Close the connection after fetching data


?>
<form action="update.php" method="post">
<fieldset disabled>                          
    <div class="mb-3">
        <label for="disabledTextInput" class="form-label">ADMIN FULL NAME</label>
        <br>
        <input type="text" fname="admminfullname" id="disabledTextInput" class="form-control" placeholder="First name" value="<?php echo htmlspecialchars("$fname $mname $lname"); ?>" />
        <br />
        <input type="email" username="email" id="disabledTextInput" class="form-control" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" />
        <br />
        <input type="text" contact="username" id="disabledTextInput" class="form-control" placeholder="contact" value="<?php echo htmlspecialchars($contact); ?>" />
        <br />
        <input type="email" email="email" id="disabledTextInput" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" />
        <br />
        <input type="email" password="email" id="disabledTextInput" class="form-control" placeholder="Password" value="<?php echo htmlspecialchars($password); ?>" />
        <br />
        <!-- Add more input fields as needed -->
        <input type="submit" value="Update">
</form>

