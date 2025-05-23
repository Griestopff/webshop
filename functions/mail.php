<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require CONFIG_DIR.'/mail_config.php';

function create_email($head, $content, $to, $bcc, $subject){
  
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

function send_invoice_email($to, $orderId){
  
  //build the message
  $message = 
  '<html>
  <body>
    <p>Hallo, '.$to.'</p>
    <p>du hast soeben eine neue Bestellung mit der Bestellnummer <strong>#'.$orderId.'</strong> aufgegeben.</p>
    <p>Die Rechnung befindet sich im Anhang dieser E-Mail.</p>
    <br>
    <p>Mit freundlichen Grüßen<br>
    Dein Bestellservice</p>
    <hr>
    <p style="font-size: small; color: #555;">
      --<br>
      Diese Nachricht wurde automatisch generiert.<br>
      Bitte antworten Sie nicht auf diese E-Mail.
    </p>
  </body>
</html>';

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
    
    //set the subject and the content (message)
    $mail->Subject = "Bestellung #".$orderId;
    $mail->MsgHTML($message);
    //set if email use html format
    $mail->isHTML(true);
    
    $filename = 'data/invoice/invoice_order_'.$orderId.'.pdf';
    if (file_exists($filename)) {
      $mail->addAttachment('data/invoice/invoice_order_'.$orderId.'.pdf', 'invoice_order_'.$orderId.'.pdf');
    } else {
      error_log("PDF nicht gefunden: $filename");
    }    //optional set html body with alternative plain text if html cant load
    #$mail->Body    = 'This is the HTML message body <b>in bold!</b>, when using ->isHTML(true)';
    #$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->Send();
    #$email = $head.$content.$foot;
    #return $email;
  }catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo("Deine Email ist nicht erreichbar.");
  };
};

function send_invoice_email_to_shxrt($orderId, $userId){
  
  //build the message
  $message = 
  '<html>
  <body>
    <p>Hallo, '.$userId.'</p>
    <p>du hast soeben eine neue Bestellung mit der Bestellnummer <strong>#'.$orderId.'</strong> aufgegeben.</p>
    <p>Die Rechnung befindet sich im Anhang dieser E-Mail.</p>
    <br>
    <p>Mit freundlichen Grüßen<br>
    Dein Bestellservice</p>
    <hr>
    <p style="font-size: small; color: #555;">
      --<br>
      Diese Nachricht wurde automatisch generiert.<br>
      Bitte antworten Sie nicht auf diese E-Mail.
    </p>
  </body>
</html>';

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
    $mail->AddAddress(MAIL_USER);	
    
    //set the subject and the content (message)
    $mail->Subject = "Bestellung #".$orderId;
    $mail->MsgHTML($message);
    //set if email use html format
    $mail->isHTML(true);
    
    $filename = 'data/invoice/invoice_order_'.$orderId.'.pdf';
    if (file_exists($filename)) {
      $mail->addAttachment('data/invoice/invoice_order_'.$orderId.'.pdf', 'invoice_order_'.$orderId.'.pdf');
    } else {
      error_log("PDF nicht gefunden: $filename");
    }
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

function send_invoice_error_email_to_shxrt($orderId, $userId){
 
  //build the message
  $message = "Bei der Bestellung ".$orderId." von User ".$userId." ist bei Gelato fehlgeschlagen.";

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
    $mail->AddAddress(MAIL_USER);	
    
    //set the subject and the content (message)
    $mail->Subject = "Bestellung #".$orderId;
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
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo("Deine Email ist nicht erreichbar.");
  };
};

?>