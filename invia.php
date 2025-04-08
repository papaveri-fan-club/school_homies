<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Configurazione SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'papaverifanclub@gmail.com';
    $mail->Password   = 'ktto vehd jpzr ngio'; // Vedi nota sotto!
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Mittente e destinatario
    $mail->setFrom('papaverifanclub@gmail.com', 'Il Tuo Nome');
    $mail->addAddress('faccio.scureggie@example.com');

    // Contenuto
    $mail->isHTML(true);
    $mail->Subject = 'Email di prova';
    $mail->Body    = 'Questa è una <b>email di test</b> inviata da PHP con PHPMailer.';

    $mail->send();
    echo 'Email inviata con successo!';
} catch (Exception $e) {
    echo "Errore: {$mail->ErrorInfo}";
}
