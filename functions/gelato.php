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

function sendOrderToGelato($orderId, $userId):bool{

    //get order and user Data
    $orderData = getOrderDataById($orderId, $userId);
    $orderItems = getOrderItemsByOrderId($orderId);
    $addressData = explode(',', $orderData['shipping_address']);
    $name = $addressData[0];
    $street = $addressData[1];
    $city = explode(" ", $addressData[2])[2];
    $postalCode = explode(" ", $addressData[2])[1];
    $addition = $addressData[3];
    if($orderData['shipping_method'] == 2){
        $shipping = 'express';
    }else{
        $shipping = 'standard';
    }

    # === Define headers ===
    $headers = [
        "Content-Type: application/json",
        "X-API-KEY: ".GELATO_SECRET
    ];

    //defines every orderitem and take the right gelato uid from color and size and product
    $itemArray = [];
    foreach ($orderItems as $orderItem) {
        $gelatoUid = getGelatoUid($orderItem['product_id'], $orderItem['color'], $orderItem['size']);
        
        $item = [
            "itemReferenceId" => $orderItem['product_id']."_".$orderItem['color']."_".$orderItem['size'],
            "productUid" => $gelatoUid,
            "files" => [
                [
                    "type" => "default",
                    "url" => "http://www.shxrt.de/data/print/print_motiv_".$orderItem['product_id'].".png"
                ]
                //more places for print availabe
                #,
                //[
                #    "type" => "back",
                #    "url" => "https://s3-eu-west-1.amazonaws.com/developers.gelato.com/product-examples/test_print_job_BX_4-4_hor_none.pdf"
                #]
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
        "shipmentMethodUid" => $shipping,
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

    //DEBUGGING
    #var_dump($orderCreateData);
    #echo $orderCreateData->message;

    //fulfillment
    //The current order fulfillment status can be one of the following: created, passed, failed, canceled, printed, shipped, draft, pending_approval, not_connected, on_hold, in_transit, delivered, or returned.
    //Please note that the additional status types in_transit, delivered, and returned will be introduced and available from June 15th onwards.
    //
    //financialStatus
    //The order current financial status. Can be: draft, pending, invoiced, to_be_invoiced, paid, canceled, partially_refunded, refunded and refused.
    //
    //https://dashboard.gelato.com/docs/orders/v4/create/

    //TODO change pending to paid in live system i think and check if these attributes are there
    if($orderCreateData->financialStatus == "pending" && $orderCreateData->fulfillmentStatus == "created"){
        //save gelato id in order
        $gelatoOrderId = $orderCreateData->id;
        setGelatoOrderId($orderId, $gelatoOrderId);
        return true;
    }else{
        return false;
    }
}

function getGelatoUid($productId, $color, $size){
    $sql = 'SELECT gelato_uid FROM product_gelato_uid WHERE product_id = :productid AND color = :color AND size = :size ;';
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':productid' => $productId,
        ':color' => $color,
        ':size' => $size
    ]);
    $uid = $stmt->fetch();
    return $uid[0];
}
