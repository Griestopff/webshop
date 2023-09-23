<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function create_email($head, $content, $to, $bcc, $subject){
  require CONFIG_DIR.'/mail_config.php';
  //build the message
  $message = $head."<br>".$content;

  try {
    //set email connection
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Host       = MAIL_HOST;
    $mail->Port       = MAIL_PORT;
    $mail->Username   = MAIL_USER;
    $mail->Password   = MAIL_PASSWORD;
    //set sender
    $mail->SetFrom(MAIL_USER, MAIL_DISPLAY_NAME);
    //set receiver and cc
    $mail->AddAddress($to);	
    if($bcc != null){
      $mail->AddBCC ($bcc, 'Example.com Sales Dep.');
    }
    //set the subject and the content (message)
    $mail->Subject = $subject;
    $mail->MsgHTML($message);
    //set if email use html format
    $mail->isHTML(true);
    //optional set html body with alternative plain text if html cant load
    #$mail->Body    = 'This is the HTML message body <b>in bold!</b>, when using ->isHTML(true)';
    #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->Send();
    #$email = $head.$content.$foot;
    #return $email;
  }catch (Exception $e) {
    #echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo("Deine Email ist nicht erreichbar.");
  };
};

?>