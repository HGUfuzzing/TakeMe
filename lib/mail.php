<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions

function send_mail($addresses, $subject, $body) {
    $mail = new PHPMailer(true);
    
    try {
        $json_text = file_get_contents(__DIR__ . '/mail_secret.json', true);
        if($json_text === false) {
            die('error : send_mail()오류. ' . __DIR__ . '/mail_secret.json을 포함시키세요');
        }
        $decoded_arr = json_decode($json_text, true);
        $id = $decoded_arr['id'];
        $pw = $decoded_arr['pw'];

        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $id;                     // SMTP username
        $mail->Password   = $pw;                               // SMTP password
        $mail->CharSet = 'utf-8'; 
        $mail->Encoding = "base64";
        $mail->SMTPSecure = 'ssl';          
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('eventapp.notify@gmail.com', 'eventapp');

        foreach ($addresses as $address) {
            $mail->addAddress($address);     // Add a recipient
        }

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}