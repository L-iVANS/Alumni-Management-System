<?php
$conn = new mysqli("localhost", "root", "", "mailer");

// IMPORTANT CODE ---------------
use PHPMailer\PHPMailer\PHPMailer;
require './vendor/autoload.php';
// THIS require './vendor/autoload.php'; IS IMPORTAN TO MAKE SURE YOU CORRECTLY LOCATE THE AUTOLOAD.PHP
// depende sya kung san mo ilalagay ung file basta malink mo lang sya ng maayos at nailagay mo tong line code 3 and 4
// at ma install ung composer software gaagna nayang mailer mo 
// ------------------------------


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from the form input
    $email = $_POST['email'];
    $verification_code = sprintf("%06d", mt_rand(1, 999999));
    $email = mysqli_real_escape_string($conn, $email);
    $verification_code = mysqli_real_escape_string($conn, $verification_code);

    $insert_verifcodes_qry = mysqli_query($conn, "INSERT INTO recovery_code(email,verification_code)
                                                             VALUES('$email','$verification_code')");
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'alumni.management07@gmail.com'; //NOTE gawa ka ng new email account nyo gaya nito, yan kasi ang magiging bridge/ sya ang mag sesend ng email
    $mail->Password   = 'kcio bmde ffvc sfar';           // di ako sude dito pero eto ata ung password ng email / pagdi tanong mo nalang kay Nyel
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // pwede nyo rin naman gamitin nayang email namin pero hingi kalang muna permission kay dhaniel pre, 
    $mail->Port       = 587;

    $mail->setFrom('alumni.management07@gmail.com', 'Alumni Management'); // eto ung email at yung name ng email na makikita sa una
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Verification Code'; // eto ung mga laman ng email na isesend
    $mail->Body    = 'Your verification code is <b>' . $verification_code . '</b> ';
    $mail->AltBody = 'Your verification code is ' . $verification_code;

    $mail->send();
    $_SESSION['email'] = $email;

    echo "<script>
            // Wait for the document to load
            document.addEventListener('DOMContentLoaded', function() {
                // Use SweetAlert2 for the alert
                Swal.fire({
                    title: 'Code Successfully send to $email.',
                    icon: 'success', // Add a success icon
                    timer: 5000,
                    showConfirmButton: true, // Show the confirm button
                    confirmButtonColor: '#4CAF50', // Set the button color to green
                    confirmButtonText: 'OK' // Change the button text if needed
                });
            });
        </script>";
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Code Form</title>
    <link rel="shortcut icon" href="cvsu.png" type="image/svg+xml">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>SEND CODE</h2>
        <form action="" method="POST">
            <label for="email">Enter your email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <input type="submit" value="Send Code">
        </form>
    </div>
</body>

</html>