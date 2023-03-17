<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

interface EmailServerInterface
{
    public function sendEmail($to, $subject, $message);
}

class EmailSender
{
    private $emailServer;
    public function __construct(EmailServerInterface $emailServer)
    {
        $this->emailServer = $emailServer;
    }

    public function send($to, $subject, $message)
    {
        $this->emailServer->sendEmail($to, $subject, $message);
    }
}

class MyEmailServer implements EmailServerInterface
{
    public function sendEmail($to, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings 
            $mail->SMTPDebug = 0;    //Enable verbose debug output 
            $mail->isSMTP();                            // Set mailer to use SMTP 
            $mail->Host = 'smtp.gmail.com';           // Specify main and backup SMTP servers 
            $mail->SMTPAuth = true;                     // Enable SMTP authentication 
            $mail->Username = 'thaongocns@gmail.com';       // SMTP username 
            $mail->Password = 'bsqmmvjqtzdrzqls';         // SMTP password 
            $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, ssl also accepted 
            $mail->Port = 587;                          // TCP port to connect to 

            // Add a recipient 
            $mail->addAddress($to, 'Đào Ngọc Thảo');

            // Set email format to HTML 
            $mail->isHTML(true);

            // Mail subject 
            $mail->Subject = $subject;

            $mail->Body = $message;

            // Send email 
            $mail->send();
            echo 'Message has been sent.';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
$emailServer = new MyEmailServer();

$emailSender = new EmailSender($emailServer);
$emailSender->send("thaongocns@gmail.com", "PHPMailer", "Hello haha");
?>