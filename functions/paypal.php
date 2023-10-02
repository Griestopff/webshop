<?php

//accesstoken is needed for every API call, expires in 3min, first get this token via API call
function getAccessToken():string{
    //if already set use not expired accesstoken, else get new one
    if(isset($_SESSION['payPalAccessToken']) && isset($_SESSION['payPalAccessTokenExpires']) && $_SESSION['payPalAccessTokenExpires'] > time()){
        return $_SESSION['payPalAccessToken'];
    }else{
        require_once CONFIG_DIR.'/paypal_config.php';
        //send request with curl to PayPalAPI
        $curl = curl_init();
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => PAYPAL_BASE_URL.'/v1/oauth2/token',
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_USERPWD => PAYPAL_CLIENT_ID.':'.PAYPAL_SECRET,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials'
        
        ];
        curl_setopt_array($curl, $options);
        
        $result = curl_exec($curl);
        if(curl_errno($curl)){
            curl_close($curl);
            echo(curl_errno($curl));
            return '';
        }
        curl_close($curl);
        //change response to PHP-Array (without true would be stdClass Object)
        $data = json_decode($result,true);
        $accessToken = $data['access_token'];
        $_SESSION['payPalAccessToken'] = $accessToken;
        $_SESSION['payPalAccessTokenExpires'] = time()+$data['expires_in'];
        return $accessToken;
    }
}

function createPayPalOrder(string $accessToken, array $purchaseUnits, int $userId){
    require_once CONFIG_DIR.'/paypal_config.php';

    //TODO feste werte austauschen
    $shippingPrice = getShippingMethodPriceById(getShippingMethodIdFromTmpOrder($userId));
    //Tax isnt used
    //$tax = 0.19;

    //create JSON string with objects
    //orderItem -> foreach loop through all orderitems (all items in arrayofobjects)
    $cartItems = getCartItemsForUserId($userId);
    $arrayOfObjects = array();
    $priceSum = 0;
    $taxSum = 0;
    // generates item objects for every item in cart for the order
    #$cartItem[0] = cart_id
    #$cartItem[1] = product_id
    #$cartItem[2] = product_name
    #$cartItem[3] = price
    #$cartItem[4] = size;
    #$cartItem[5] = color;
    #$cartItem[6] = amount;
    foreach($cartItems as $cartItem){
        $unitAmount = new stdClass();
        $unitAmount->currency_code = "EUR";
        $unitAmount->value = $cartItem[3];
        #$taxObject = new stdClass();
        #$taxObject->currency_code = "EUR";
        #$itemTax = round($cartItem[3] * $tax, 2);
        #$taxObject->value = $itemTax;
        $orderItem = new stdClass();
        $orderItem->name = $cartItem[2];
        $orderItem->quantity = $cartItem[6];
        $orderItem->unit_amount = $unitAmount;
        #$orderItem->tax = $taxObject;
        $arrayOfObjects[] = $orderItem;

        $priceSum = $priceSum + ($cartItem[3] * $cartItem[6]);
        #$taxSum = $taxSum + ($itemTax * $cartItem[6]);
    }
    $amountSum = round($priceSum + $shippingPrice, 2);

    //total price off all items in order (items[].unit_amount * items[].quantity))
    $itemTotalObject = new stdClass();
    $itemTotalObject->currency_code = "EUR";
    $itemTotalObject->value = $priceSum;

    //shipping price of the order
    $shippingTotalObject = new stdClass();
    $shippingTotalObject->currency_code = "EUR";
    $shippingTotalObject->value = $shippingPrice;

    //tax sum of all orderitems
    $taxTotalObject = new stdClass();
    $taxTotalObject->currency_code = "EUR";
    $taxTotalObject->value = $taxSum;

    $breakdownObject = new stdClass();
    $breakdownObject->item_total = $itemTotalObject;
    $breakdownObject->shipping = $shippingTotalObject;
    #$breakdownObject->tax_total = $taxTotalObject;
    
    //amoutnt value is value off all (orderItemsSum + taxesSum + shipping,...)
    $amountObject = new stdClass();
    $amountObject->currency_code = "EUR";
    $amountObject->value = $amountSum;
    $amountObject->breakdown = $breakdownObject;

    if(UserHasShippingAddress($userId)){
        $address = getShippingAddressByUserId($userId);
        $shippingName = $address['person'];
    }else{
        $address = getBillingAddressByUserId($userId);
        $userData = getUserDataById($userId);
        $shippingName = $userData['first_name']." ".$userData['last_name'];
    }
    //shipping address
    $nameObject = new stdClass();
    $nameObject->full_name = $shippingName;
    $addressObject = new stdClass();
    $addressObject->address_line_1 = $address['street']." ".$address['number'];
    $addressObject->admin_area_2 = $address['location'];
    $addressObject->postal_code = $address['postal_code'];
    $addressObject->country_code = "DE";
    $shippingObject = new stdClass();
    $shippingObject->name = $nameObject;
    $shippingObject->address = $addressObject;
    
    //order
    $purchaseUnitsObject = new stdClass();
    $purchaseUnitsObject->amount = $amountObject;
    $purchaseUnitsObject->shipping = $shippingObject;
    $purchaseUnitsObject->items = $arrayOfObjects;

    $experienceContextObject = new stdClass();
    $experienceContextObject->shipping_preference = "SET_PROVIDED_ADDRESS";
    //return_url need "http://" at the beginning
    $experienceContextObject->return_url = "http://shop/index.php/checkout/order";
    $experienceContextObject->cancel_url = "http://shop/index.php/cart";
    $experienceContextObject->brand_name = "SHXRT";

    $paypalObject = new stdClass();
    $paypalObject->experience_context = $experienceContextObject;

    $paymentSourceObject = new stdClass();
    $paymentSourceObject->paypal = $paypalObject;    
     
    $data = [
        "intent" => "CAPTURE",
        "purchase_units" => [
            $purchaseUnitsObject
        ],
        "payment_source" => $paymentSourceObject
    ];
    //encodes the PHP string to a json string
    $dataString = json_encode($data);

    //send data with curl to PayPalAPI
    $curl = curl_init();
    $options = [
    CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => PAYPAL_BASE_URL.'/v2/checkout/orders',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            #'PayPal-Request-Id: 7b92603e-77ed-4896-8e78-5dea2050476a',
            'Authorization: Bearer '.$accessToken
            ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $dataString
        
    ];
    curl_setopt_array($curl, $options);
        
    $result = curl_exec($curl);
    if(curl_errno($curl)){
        curl_close($curl);
        echo(curl_errno($curl));
        return '';
    }
    curl_close($curl);

    //change response to PHP-Array (without true would be stdClass Object)
    $data = json_decode($result,true);
    //DEBUGGING
    //var_dump($data);
    //checks response need PAYER_ACTI ON_REQUIRED
    if (isset($data['status'])) {
        if($data['status'] !== "PAYER_ACTION_REQUIRED"){
            return false;
        }
    }elseif(isset($data['name'])) {
        if($data['name'] == "UNPROCESSABLE_ENTITY"){
            echo("Es ist ein Fehler aufgetreten die Bestellung ist ungültig: ".$data['details'][0]['issue']);
            return false;
        }
    }

    //sets the session variable
    setPayPalOrderId($data['id']);

    //redirect to PayPal, use link from API response
    $paypal_url = "";
    foreach($data['links'] as $link){
        if($link['rel'] !== "payer-action"){
            continue;
        }
        $paypal_url = $link['href'];
    }
    
    header("Location: ".$paypal_url);
    exit();
}

function setPayPalOrderId(string $orderId):void{
    $_SESSION['paypalOrderId'] = $orderId;
}

function setPayPalRequestId(string $paypalRequestId):void{
    $_SESSION['paypalRequestId'] = $paypalRequestId;
}

//:?string means: returns string or NULL
function getPayPalOrderId():?string{
    return isset($_SESSION['paypalOrderId'])?$_SESSION['paypalOrderId']:null;
}

//:?string means: returns string or NULL
function getPayPalRequestId():?string{
    return isset($_SESSION['paypalRequestId'])?$_SESSION['paypalRequestId']:null;

}

//finally pay the order, cash from customer is transfered to shop
function capturePayment(string $accessToken, string $orderId, string $token){
    require_once CONFIG_DIR.'/paypal_config.php';
    
    //create JSON string with objects
    $data = new stdClass();
    $data->payment_source = new stdClass();
    $data->payment_source->token = new stdClass();
    $data->payment_source->token->id = $token;
    $data->payment_source->token->type = "BILLING_AGREEMENT";
    $dataString = json_encode($data);

    //send data with curl to PayPalAPI
    $curl = curl_init();
    $options = [
    CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => PAYPAL_BASE_URL.'/v2/checkout/orders/'.$orderId.'/capture',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            #'PayPal-Request-Id: '.$payPalRequestId,
            'Authorization: Bearer '.$accessToken
            ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $dataString
        
    ];
    curl_setopt_array($curl, $options);
        
    $result = curl_exec($curl);
    if(curl_errno($curl)){
        curl_close($curl);
        echo(curl_errno($curl));
        return '';
    }
    curl_close($curl);
    //change response to PHP-Array (without true would be stdClass Object)
    $data = json_decode($result,true);

    //TODO wenn aktualisiert -> reponse von paypal hat keine ['status'] mehr
    //return the status of the payment - should be 'COMPLETED'
    return $data['status'];
}

//if every needed value is set, get money from customer
function paypalPaymentComplete($token, $payerId){
    //accessToken and orderId was send by PayPal API (responses)
    $accessToken = getAccessToken(); 
    $orderId = getPayPalOrderId();

    $token = preg_replace('/[^a-zA-Z0-9]/u', '', $token);
    $payerId = preg_replace('/[^a-zA-Z0-9]/u', '', $payerId);

    $orderStatus = '';
    if($accessToken && $orderId && $token){
        $orderStatus = capturePayment($accessToken, $orderId, $token);
    } 
    return $orderStatus;
}