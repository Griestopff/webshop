<?php
#header('Content-type: text/css');

$cont = "hi";



$grey = "#6C757D";
$darkgrey = "#212529";
$lightgrey = "#C4C8CC";
$black = "black";
$white = "#FFFFFF";

$blue = "#0D6EFD";
$darkblue = "#0b5ed7";

$orange = "#F39931";
$darkorange = "#F28930";

$primary_btn = $blue;
$primary_btn_sec = $darkblue;
$primary_btn_fontc = $white;
$secondary_btn = $grey;
$secondary_btn_sec = $darkgrey;
$secondary_btn_fontc = $white;
$backgroundcolor = $black;
$backgroundcolor_div = $darkgrey;
$backgroundcolor_card = $grey; /*+Second background*/
$fontcolor = $white;
$fontcolor2 = $black;



$messagehead =
'
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <title></title>
  <!--[if mso]>
  <style>
    table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
    div, td {padding:0;}
    div {margin:0 !important;}
  </style>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {
      font-family: Arial, sans-serif;
    }
    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: white;
        text-decoration: none !important;
        font-weight: bold;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }
      .col-lge {
        max-width: 73% !important;
      }
    }
  </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:white;">
  <div role="article" aria-roledescription="email" lang="en" style="border-radius: 10px;text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:'.$backgroundcolor.';">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
      <tr>
        <td align="center" style="padding:0;">
          <!--[if mso]>
          <table role="presentation" align="center" style="width:600px;">
          <tr>
          <td>
          <![endif]-->
          <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:'.$fontcolor2.';">
            <tr>
              <td style="text-align:center;font-size:24px;font-weight:bold;border-radius: 10px;">
                <a href="https://shxrt.de" class="navbar-brand d-flex align-items-center" style="text-decoration:none;margin-left:5px">
			               <img alt="" src="'.$pfad.'" style="margin-top:18px; margin-left:-10px; height:90px">
                     <!--<img alt="self-Logo" src="./loop.svg" style="margin-right:10px; height:90px">-->
			               <strong style="margin-top:18px;margin-left: 15px;color:black">SHXRT.de</strong>
		            </a>
              </td>
            </tr>
            <tr>
              <td style="color:'.$fontcolor.';padding:30px;background-color:'.$backgroundcolor_div.';border-radius: 10px 10px 0px 0px;">
';

$messagemid =
'
</td>
</tr>
<tr>
<td style="padding:30px;background-color:'.$backgroundcolor_card.';">
';

$messageend =
'
</td>
</tr>

<tr>
<td style="padding:30px;text-align:center;font-size:12px;background-color:'.$backgroundcolor_div.';color:#cccccc;border-radius: 0px 0px 10px 10px;">
<a style="text-decoration:none" href="https://www.instagram.com" class="text-white">
<img alt="Instagram" src="https://www.christophmanitz.de/instagram.svg" style="width:25px; height:25px;color:'.$fontcolor2.';font-size:20px">
</a>
<span style="color:black; font-size:20px"> |</span>
<a style="text-decoration:none" href="https://www.linkedin.com" class="text-white">
<img alt="LinkedIn" src="https://www.christophmanitz.de/linkedin.svg" style="width:25px; height:25px;color:'.$fontcolor2.';font-size:20px">
</a>
<span style="color:black; font-size:20px"> |</span>
<a style="text-decoration:none" href="https://www.twitter.com" class="text-white">
<img alt="Twitter" src="https://www.christophmanitz.de/twitter.svg" style="width:25px; height:25px; color:'.$fontcolor2.';font-size:20px">
</a>
<!--      <br><br><br><a class="unsub" href="http://www.example.com/" style="color:#cccccc;text-decoration:underline;">Unsubscribe instantly</a></p>
</td>-->
</tr>
</table>
<!--[if mso]>
</td>
</tr>
</table>
<![endif]-->
</td>
</tr>
</table>
<br>
</div>
</body>
</html>
'
?>
