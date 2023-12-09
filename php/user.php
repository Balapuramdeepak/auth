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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $stmt = $conn->prepare("SELECT name, dob, contact FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($name, $dob, $contact);

    if ($stmt->fetch()) {
        echo json_encode(array("status" => "success", "name" => $name, "dob" => $dob, "contact" => $contact));
    } else {
        echo json_encode(array("status" => "error", "message" => "User not found"));
    }

    $stmt->close();
}

$conn->close();
?>
