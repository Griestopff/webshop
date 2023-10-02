<?php

require_once CONFIG_DIR.'/gelato_config.php';

function request($url, $data, $headers)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers,
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        die("cURL Error #:" . $err);
    } else {
        return $response;
    }
}

function sendTestOrderToGelato($orderId, $userId){

$orderData = getOrderDataById($orderId, $userId);
$orderItems = getOrderItemsByOrderId($orderId);
$addressData = explode(',', $orderData['shipping_address']);
$name = $addressData[0];
$street = $addressData[1];
$city = explode(" ", $addressData[2])[2];
$postalCode = explode(" ", $addressData[2])[1];
$addition = $addressData[3];

//TODO
//shippingaddress
//foreach array für items array

# === Define headers ===
$headers = [
    "Content-Type: application/json",
    "X-API-KEY: ".GELATO_SECRET
];

$itemArray = [];
foreach ($orderItems as $orderItem) {
    $item = [
        "itemReferenceId" => $orderItem['product_id']."_".$orderItem['color']."_".$orderItem['size'],
        "productUid" => "apparel_product_gca_t-shirt_gsc_crewneck_gcu_unisex_gqa_classic_gsi_s_gco_white_gpr_4-4",
        "files" => [
            [
                "type" => "default",
                "url" => "http://s3-eu-west-1.amazonaws.com/developers.gelato.com/product-examples/test_print_job_BX_4-4_hor_none.pdf"
            ],
            [
                "type" => "back",
                "url" => "https://s3-eu-west-1.amazonaws.com/developers.gelato.com/product-examples/test_print_job_BX_4-4_hor_none.pdf"
            ]
        ],
        "quantity" => $orderItem['amount']
    ];
    $itemArray[] = $item;
}


# === Set-up order request ===
$orderUrl = GELATO_BASE_URL."/v4/orders";
$orderData = [
    "orderType" => "order",
    "orderReferenceId" => $orderId."_".$orderData['order_code'],
    "customerReferenceId" => $userId,
    "currency" => "EUR",
    "items" => $itemArray,        
    "shipmentMethodUid" => "standard",
    "shippingAddress" => [
        #"companyName" => "Example",
        "firstName" => $name,
        #"lastName" => "Smith",
        "addressLine1" => $street,
        "addressLine2" => $addition,
        #"state" => "NY",
        "city" => $city,
        "postCode" => $postalCode,
        "country" => "DE",
        #"email" => "apisupport@gelato.com",
        #"phone" => "123456789"
    ]
];

# === Send create order request ===
$response = request($orderUrl, $orderData, $headers);
$orderCreateData = json_decode($response);

var_dump($orderCreateData);
echo $orderCreateData->message;
}