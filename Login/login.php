<?php
// Database configuration
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "alumni_management_system";

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
    $user = check_login($conn, 'alumni', $username, $password);
    $user_type = 'alumni';

    // Check in admin table if not found in users
    if (!$user) {
        $user = check_login($conn, 'admin', $username, $password);
        $user_type = 'admin';
    }
    
    // Check in moderators table if not found in users and admin
    if (!$user) {
        $user = check_login($conn, 'coordinator', $username, $password);
        $user_type = 'coordinator';
    }

    if ($user) {
        // Login success, set session variables
        switch ($user_type) {
            case 'alumni':
                $_SESSION['user_id'] = $user['student_id'];
                break;
            case 'admin':
                $_SESSION['user_id'] = $user['admin_id'];
                break;
            case 'coordinator':
                $_SESSION['user_id'] = $user['coor_id'];
                break;
        }
        $_SESSION['name'] = $user["fname"] . " " . $user["mname"] . " " . $user["lname"];
        $_SESSION['username'] = $user['username'];
        $_SESSION['password'] = $user['password'];
        // Redirect to a different page
        header("Location: index.php");
        exit();
    } else {
        // Login failed
        echo "
            <script>
                alert('Invalid Username and Password');
                window.location.href = 'login.php';
            </script>
        ";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in || Sign up form</title>
    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="cvsu.png" type="image/svg+xml">
    <!-- css stylesheet -->
    <link rel="stylesheet" href="login.css">
    
</head>
<body>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <h1>Sign Up</h1>
                <div class="infield">
                    <input type="text" placeholder="First Name"name="fname"  required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="Middle Name" name="mname" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder=" Last Name"name="lname"  required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="Username"name="username"  required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="email" placeholder="Email" name="email" required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password"name="course" name="course" required/>
                    <label></label>
                </div>
                <div class="infield">
                <select name="course" id="course" required >
                        <option value="" disabled selected>Select a Course</option>
                        <option value="BSIT">BSIT</option>
                        <option value="BSCS">BSCS</option>
                        <option value="BSAB">BSAB</option>
                        <option value="BSTM">BSTM</option>
                    </select>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="Batch"name="batch"  required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="Currently connected to"name="connected_to"  required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="Contact"name="Contact"  required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="Address"name="Address"  required/>
                    <label></label>
                </div>
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container log-in-container">
            <form action="#" method="POST">
                <h1>Log in</h1>
                <div class="infield">
                    <input type="text" placeholder="Username" name="username" required/>
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" name="password" required/>
                    <label></label>
                </div>
                <a href="#" class="forgot">Forgot your password?</a>
                <button>Log In</button>
            </form>
        </div>
        <div class="overlay-container" id="overlayCon">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="cvsu.png" usemap="#logo">
                    <map name="logo">
                        <area shape="poly" coords="101,8,200,106,129,182,73,182,1,110" href="https://programminghead.com/Projects/find-coordinates-of-image-online.html">
                    </map>
                    <br>
                    <br>
                    <button class="ghost" id="logIn">Log In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="cvsu.png" usemap="#logo">
                    <map name="logo">
                        <area shape="poly" coords="101,8,200,106,129,182,73,182,1,110" href="https://programminghead.com/Projects/find-coordinates-of-image-online.html">
                    </map>
                    <br>
                    <br>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <!-- js code -->
    <script>
        const signUpButton = document.getElementById('signUp');
        const logInButton = document.getElementById('logIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        logInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });
    </script>
</body>
</html>
