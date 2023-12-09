<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendConfirmationEmail($to, $confirmationCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'karzkarzx@gmail.com';
        $mail->Password = 'wodauuldjcecttjc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('karzkarzx@example.com', 'Karz');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmation Email';
        $mail->Body = 'Click the following link to confirm your email: <a href="https://deepakauth.000webhostapp.com/php/confirm.php?code=' . $confirmationCode . '">Confirm Email</a>';

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>
