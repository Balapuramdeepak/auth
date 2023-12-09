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
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirmPassword"]);

   
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        echo json_encode(array("status" => "error", "message" => "Email already exists"));
        exit();
    }

    $checkStmt->close();

    if ($password != $confirmPassword) {
        echo json_encode(array("status" => "error", "message" => "Passwords do not match"));
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $confirmationCode = md5(uniqid(rand(), true));

    $insertStmt = $conn->prepare("INSERT INTO users (email, password, confirmation_code, verified) VALUES (?, ?, ?, 0)");
    $insertStmt->bind_param("sss", $email, $hashedPassword, $confirmationCode);

    if ($insertStmt->execute()) {
        require 'send_mail.php';  
        sendConfirmationEmail($email, $confirmationCode);

        echo json_encode(array("status" => "success", "message" => "Registration successful! Check your email for confirmation."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $insertStmt->error));
    }

    $insertStmt->close();
}

$conn->close();
?>
