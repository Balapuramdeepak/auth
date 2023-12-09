<?php
require_once '../vendor/autoload.php';
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

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (!$user['verified']) {
            echo json_encode(array("status" => "error", "message" => "Email not verified. Please check your email for confirmation."));
            exit();
        }

        if (password_verify($password, $user['password'])) {
            $secret_key = "your_secret_key";
            $issued_at = time();
            $expiration_time = $issued_at + 3600;

            $payload = array(
                "user_id" => $user['id'],
                "email" => $user['email'],
                "iat" => $issued_at,
                "exp" => $expiration_time
            );

            $token = JWT::encode($payload, $secret_key, 'HS256');

            echo json_encode(array("status" => "success", "token" => $token));
            exit();
        } else {
            echo json_encode(array("status" => "error", "message" => "Invalid password"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "User not found"));
    }

    $stmt->close();
}

$conn->close();
?>
