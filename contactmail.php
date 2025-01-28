<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mus2alive@gmail.com'; // Replace with your email
        $mail->Password = 'jkbz lfrp ghai vhho'; // Replace with your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('mus2alive@gmail.com', 'Agence Immobilière'); // Your email address

        $mail->Subject = "Nouveau message de $name";
        $mail->isHTML(true);
        $mail->Body = "
            <h3>Nouveau message de contact</h3>
            <p><strong>Nom :</strong> $name</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Message :</strong><br>$message</p>
        ";

        $mail->send();
        echo "Votre message a été envoyé avec succès.";
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
    }
} else {
    echo "Une erreur est survenue.";
}
?>
