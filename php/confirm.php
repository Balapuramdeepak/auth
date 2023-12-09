<?php
require '../vendor/autoload.php';

$servername = "localhost";
$username = "id21645880_root";
$password = "sDX5DihjotjU1ab9@";
$dbname = "id21645880_users";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["code"])) {
    $confirmationCode = $_GET["code"];

   
    $stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE confirmation_code = ? AND verified = 0");
    $stmt->bind_param("s", $confirmationCode);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Email verified successfully!";
        } else {
            echo "Email already verified or invalid confirmation code.";
        }
    } else {
        echo "Error verifying email: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
