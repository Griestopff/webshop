<?php

require 'TCPDF/tcpdf.php';

//DEBUGGING test function
function createPDF(){

// PDF-Instanz erstellen
$pdf = new TCPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);

// PDF-Header setzen
$pdf->setPrintHeader(false);

// PDF-Footer setzen
$pdf->setPrintFooter(false);

// Neue Seite hinzufügen
$pdf->AddPage();

// Inhalt der Rechnung
$rechnung = '<h1>Rechnung</h1>';
$rechnung .= '<p>Rechnungsnummer: 12345</p>';
$rechnung .= '<p>Rechnungsdatum: ' . date('d.m.Y') . '</p>';
$rechnung .= '<p>Rechnungsbetrag: $100.00</p>';

// PDF-Inhalt hinzufügen
$pdf->writeHTML($rechnung, true, false, true, false, '');

// PDF-Datei ausgeben
$pdf->Output(DATA_DIR.'/invoice/rechnung.pdf', 'F'); // 'D' steht für Download, du kannst stattdessen 'I' für Anzeigen verwenden


}


function createInvoice($userId, $order_code){
    $orderId = getOrderIdByOrderCode($order_code);
    $orderData = getOrderDataById($orderId, $userId);
    $orderItems = getOrderItemsByOrderId($orderId);
    $shippingPrice = getOrderShippingPriceById($orderId);
    $userData = getUserDataById($userId);
    $date = date("d.m.Y - H:i");
    $address = explode(",", $orderData['shipping_address']);
    $first_part = 
'
<html>
<head>Receipt of Purchase - OrderID: '.$orderId.'</head>
<body>
<div style="text-align:right;">
        <b>Sender:</b> SHXRT
    </div>
    <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 24px;color: #666;">INVOICE</div>
    </div>
<table style="line-height: 1.5;">
    <tr><td><b>Invoice:</b> #'.$orderId.'
        </td>
        <td style="text-align:right;"><b>Receiver:</b></td>
    </tr>
    <tr>
        <td><b>Date:</b> '.$date.'</td>
        <td style="text-align:right;">'.$address[0].'</td>
    </tr>
    <tr>
        <td><b>Payment Due:</b> Completed via PayPal
        </td>
        <td style="text-align:right;">'.$address[1].'</td>
    </tr>
<tr>
<td></td>
<td style="text-align:right;">'.$address[2].'</td>
</tr>
</table>

<div></div>
    <div style="border-bottom:1px solid #000;">
        <table style="line-height: 2;">
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <td style="border:1px solid #cccccc;width:200px;">Item Description</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:85px">Price (€)</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:75px;">Quantity</td>
                <td style = "text-align:right;border:1px solid #cccccc;">Subtotal (€)</td>
            </tr>
';


$table = '';
$total = 0;
foreach ($orderItems as $orderItem) {
    $product = getProductById($orderItem['product_id']);
    $price = $orderItem['amount'] * $product['price'];
    $total += $price;
    $table = $table.'<tr> <td style="border:1px solid #cccccc;">'.$product['product_name'].'</td>
<td style = "text-align:right; border:1px solid #cccccc;">'.number_format($product['price'], 2).'</td>
<td style = "text-align:right; border:1px solid #cccccc;">'.$orderItem["amount"].'</td>
<td style = "text-align:right; border:1px solid #cccccc;">'.number_format($price, 2).'</td>
</tr>';
    

}
$last_part = 
'
<tr>
    <td></td><td></td>
    <td style = "text-align:right;">Shipping</td>
    <td style = "text-align:right;">'.number_format($shippingPrice, 2).'</td>
</tr>
<tr style = "font-weight: bold;">
    <td></td><td></td>
    <td style = "text-align:right;">Total (€)</td>
    <td style = "text-align:right;">'.number_format($total+$shippingPrice, 2).'</td>
</tr>
</table></div>

<p><i>Note: Please send a email to info@shxrt.de if you have question.</i></p>
</body>
</html>
';

// Inhalt der Rechnung
$result = $first_part.$table.$last_part;

// PDF-Instanz erstellen
$pdf = new TCPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);

// PDF-Header setzen
$pdf->setPrintHeader(false);

// PDF-Footer setzen
$pdf->setPrintFooter(false);

// Neue Seite hinzufügen
$pdf->AddPage();

// PDF-Inhalt hinzufügen
$pdf->writeHTML($result, true, false, true, false, '');

$fileName = "invoice_order_".$orderId;

// PDF-Datei ausgeben
$pdf->Output(DATA_DIR.'/invoice/'.$fileName.'.pdf', 'F'); // 'D' steht für Download, du kannst stattdessen 'I' für Anzeigen verwenden

send_invoice_email($userData['email'], $orderId);
send_invoice_email_to_shxrt($orderId, $userId);

}
?>