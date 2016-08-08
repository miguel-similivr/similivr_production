<?php
include_once '../includes/mail-config.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();
$mail->Host = MAIL_HOST;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = MAIL_USERNAME;                 // SMTP username
$mail->Password = MAIL_PASSWORD;                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->isHTML(true);                                  // Set email format to HTML


// SYTAX: phpMail($from, $reply, $to, $subject, $body);
function phpMail($to, $subject, $body, $from = "noreply@simili.io", $reply = "noreply@simili.io") {
    if (isset($from)) 
        $mail->From = $from;
        $mail->FromName = "testing";

    if (isset($to)) 
        $mail->addAddress($to);

    if (isset($reply)) 
        $mail->addReplyTo($reply);

    if (isset($subject)) 
        $mail->Subject = $subject;

    if (isset($body)) 
        $mail->Body = $body;
        $mail->AltBody = $body;

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }

}

phpMail("miguel@similivr.com", "testing", "testing123");
?>