<?php

use PHPMailer\PHPMailer\PHPMailer;

class ContactModel
{

    // Méthode qui envoie le mail de demande de contact
    public static function sendContactMail($titre, $description, $email)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM'], $email);
        $emailTo = 'contact@viteetgourmand.fr';
        $mail->addAddress($emailTo);

        $mail->Subject = 'Demande de contact: ' . $titre;
        $mail->isHTML(true);

        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Montserrat, sans-serif; color: #0f172a; }
                .header { background-color: #0f172a; padding: 20px; text-align: center; border-radius: 8px; }
                .header h1 { color: #e67e22; font-family: 'Playfair Display', serif; }
                .content { padding: 30px; }
                .recap { background-color: #1e293b; color: white; padding: 20px; border-radius: 8px; }
                .total { color: #e67e22; font-weight: bold; font-size: 1.2rem; }
            </style>
        </head>
        <body>
            <div class='header'>
            <h1>Demande de contact</h1>
            </div>
            <div class='content'>    
            <br>
            </div>
            <div class='recap'>
            <h2>Message de: $email</h2>
            <h3>Sujet : $titre</h3>
            <p>$description</p>
            <br>
            </div>
        </body>
        </html>";

        try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi mail : " . $mail->ErrorInfo);
        }
    }
}
