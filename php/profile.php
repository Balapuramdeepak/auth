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
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $contact = mysqli_real_escape_string($conn, $_POST["contact"]);

 
    $stmt = $conn->prepare("UPDATE users SET name=?, dob=?, contact=? WHERE email=?");
    $stmt->bind_param("ssss", $name, $date, $contact, $email);

    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Profile updated successfully!"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $stmt->error));
    }

    $stmt->close();
}

$conn->close();
?>
