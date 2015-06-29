<?php
require_once('includes/phpMailer/class.phpmailer.php');
require_once("includes/phpMailer/class.smtp.php");
require 'includes/phpMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = 'abhishek.gupta@deerwalk.edu.np';
$mail->Password = 'GunM@$terG9';
$mail->SMTPAuth = true;

// $from = "abhishek.guptablog@gmail.com";
// $mail->From     = $from;
$mail->FromName = 'Abhishek Gupta';
$mail->AddAddress('abhishek_luck19@hotmail.com');
$mail->AddAddress('abhishek.gupta@deerwalk.edu.np');
$mail->AddReplyTo('abhishek.gupta@deerwalk.edu.np', 'Information');
$mail->IsHTML(true);
$mail->Subject    = "New topic";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->Body    = "Hello ";

if(!$mail->Send())
{
  echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
  echo "Message sent!";
}
?>