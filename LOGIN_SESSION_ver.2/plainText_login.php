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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in users table
    $user = check_login($conn, 'users', $username, $password);
    $user_type = 'users';
    
    // Check in admin table if not found in users
    if (!$user) {
        $user = check_login($conn, 'admin', $username, $password);
        $user_type = 'admin';
    }
    
    // Check in moderators table if not found in users and admin
    if (!$user) {
        $user = check_login($conn, 'moderators', $username, $password);
        $user_type = 'moderators';
    }

    if ($user) {
        // Login success, set session variables
        switch ($user_type) {
            case 'users':
                $_SESSION['user_id'] = $user['users_id'];
                break;
            case 'admin':
                $_SESSION['user_id'] = $user['admin_id'];
                break;
            case 'moderators':
                $_SESSION['user_id'] = $user['moderators_id'];
                break;
        }
        $_SESSION['username'] = $user['username'];
        $_SESSION['password'] = $user['password'];
        // Redirect to a different page
        header("Location: index.php");
        exit();
    } else {
        // Login failed
        echo "Invalid username or password.";
    }
}

// Function to check login
function check_login($conn, $table, $username, $password) {
    // Prepare the SQL query
    $sql = "SELECT * FROM $table WHERE username = ? AND password = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    
    // Bind the username and password parameters to the query
    $stmt->bind_param("ss", $username, $password);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result set from the query
    $result = $stmt->get_result();
    
    // Check if a matching row was found
    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        return $result->fetch_assoc();
    }
    
    // Return false if no match was found
    return false;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
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
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
