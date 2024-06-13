<?php
session_start();

// Database credentials
$servername = "localhost";
$dbusername = "root"; // Replace with your database username
$dbpassword = ""; // Replace with your database password
$dbname = "your_database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Define an array to store tables you want to check
    $tables = ['admin', 'moderators', 'users'];

    // Loop through each table to check username, password, and retrieve ID
    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT id, password FROM $table WHERE username = ?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password);
                $stmt->fetch();

                // Verify password
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['id'] = $id; // Store user ID in session
                    $_SESSION['username'] = $username;
                    $stmt->close();
                    $conn->close();
                    header("Location: index.php");
                    exit();
                }
            }
        }
        $stmt->close(); // Close statement for each iteration
    }

    // If no match found in any table
    echo "Invalid username or password";
}

$conn->close();
?>

<!-- HTML form for login -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
