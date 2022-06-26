<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
class Mail{

   public function sendMail($name,$to,$Subject,$Body)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
           // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = EMAIL_SMTP_HOST;                       //Set the SMTP server to send through
            $mail->SMTPAuth   = EMAIL_SMTP_AUTH;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL_USERNAME;                     //SMTP username
            $mail->Password   = EMAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = EMAIL_SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($mail->Username,"LMS Management");
            $mail->addAddress($to, $name);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
    
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->SMTPDebug = false;  
                           
            $mail->Subject = $Subject;
            $mail->Body    = $Body;
            $mail->isHTML(true);    //Set email format to HTML
            //$mail->AltBody = '';
        
            $mail->send();
            return true;
           // echo 'Message has been sent';
        } catch (Exception $e) {
             //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}