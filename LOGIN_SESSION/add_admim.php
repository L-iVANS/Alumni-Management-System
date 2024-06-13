<?php
// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new admin user into admin table
    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed_password')";
    
    $result = $conn->query($sql);
    
    if ($result) {
        echo "Admin user registered successfully.";
        // Optionally, redirect to login page or another page
    } else {
        echo "Failed to register admin user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
</head>
<body>
    <h2>Register New Admin User</h2>
    <form method="post" action="">
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit" name="submit">Register</button>
        </div>
    </form>
</body>
</html>
