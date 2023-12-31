<?php

function deleteTmpOrders($userId){
    try {
        $sql = "DELETE FROM tmp_orders WHERE user_id = :userId;";
        // Prepared Statement 
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
            ':userId' => $userId
        ]);
    } catch (PDOException $e) {
        // Fehlerbehandlung, falls ein Fehler auftritt
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }  
}

function createNewTmpOrder($userId, $shippingMethod){
    try {
        //first delete all old temporary orders
        deleteTmpOrders($userId);

        //random order_code
        $orderCode = rand(0,100000);
        
        $_SESSION['orderCode'] = $orderCode;
    
        //shipping address string for orders table
        $shipping_address = userShippingAddressForOderToString($userId);
        $shipping_method = $shippingMethod; 
        $insertOrderSQL = "INSERT INTO tmp_orders (user_id, shipping_address, paid, delivered, shipping_method, order_code) 
                VALUES (:userId, :shipping_address, FALSE, FALSE, :shipping_method, :order_code)";
    
        // Prepared Statement 
        $stmt = getDB()->prepare($insertOrderSQL);
        $stmt->execute([
            ':userId' => $userId,
            ':shipping_address' => $shipping_address,
            ':shipping_method' => $shipping_method,
            ':order_code' => $orderCode
        ]);
    
        //get created OrderId
        $orderId = getTmpOrderIdByOrderCode($orderCode);
    
        //get cartItems to set in order
        $cartItems = getCartItemsForUserId($userId); // Diese Funktion sollten Sie entsprechend implementieren
    
        //insert cartItems(products) in order_item table
        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['product_id'];
            $size = $cartItem['size'];
            $color = $cartItem['color'];
            $amount = $cartItem['amount'];
    
            $insertOrderItemSQL = "INSERT INTO order_item (order_id, product_id, size, color, amount) 
                    VALUES (:orderId, :productId, :size, :color, :amount)";
    
            //prepare the sql statement
            $stmt = getDB()->prepare($insertOrderItemSQL);
            $stmt->execute([
                ':orderId' => $orderId,
                ':productId' => $productId,
                ':size' => $size,
                ':color' => $color,
                ':amount' => $amount
            ]);
        }
    } catch (PDOException $e) {
        // Fehlerbehandlung, falls ein Fehler auftritt
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }    
}

function transformTmpOrderToOrder($userId, $orderCode){
    //change to final order
    createOrder($userId, $orderCode);
    deleteTmpOrders($userId);
    $_SESSION['orderCode'] = '';
    removeAllProductsFromCart($userId);
}  

//TODO nehme values von temp order
function createOrder($userId, $orderCode){
    try {  
        //shipping address string for orders table
        $shipping_address = userShippingAddressForOderToString($userId);
        $shipping_method = getShippingMethodIdFromTmpOrder($userId); 
        $insertOrderSQL = "INSERT INTO orders (user_id, shipping_address, paid, delivered, shipping_method, order_code) 
                VALUES (:userId, :shipping_address, FALSE, FALSE, :shipping_method, :order_code)";
    
        // Prepared Statement 
        $stmt = getDB()->prepare($insertOrderSQL);
        $stmt->execute([
            ':userId' => $userId,
            ':shipping_address' => $shipping_address,
            ':shipping_method' => $shipping_method,
            ':order_code' => $orderCode
        ]);
    
        //get created OrderId
        $orderId = getOrderIdByOrderCode($orderCode);
    
        //get cartItems to set in order
        $cartItems = getCartItemsForUserId($userId); // Diese Funktion sollten Sie entsprechend implementieren
    
        //insert cartItems(products) in order_item table
        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['product_id'];
            $size = $cartItem['size'];
            $color = $cartItem['color'];
            $amount = $cartItem['amount'];
    
            $insertOrderItemSQL = "INSERT INTO order_item (order_id, product_id, size, color, amount) 
                    VALUES (:orderId, :productId, :size, :color, :amount)";
    
            //prepare the sql statement
            $stmt = getDB()->prepare($insertOrderItemSQL);
            $stmt->execute([
                ':orderId' => $orderId,
                ':productId' => $productId,
                ':size' => $size,
                ':color' => $color,
                ':amount' => $amount
            ]);
        }
    } catch (PDOException $e) {
        // Fehlerbehandlung, falls ein Fehler auftritt
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }    
}

//get the orderId of your currently working order by your random order_code
function getTmpOrderIdByOrderCode($order_code) {
   $sql = "SELECT order_id FROM tmp_orders WHERE order_code = ".$order_code;
   $result = getDB()->query($sql);
   $orderId = $result->fetch();
   return $orderId[0];
}

//get the orderId of the temporary order of your currently working order by your random order_code
function getOrderIdByOrderCode($order_code) {
    $sql = "SELECT order_id FROM orders WHERE order_code = :ordercode ;";
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':ordercode' => $order_code
    ]);
    $orderId = $stmt->fetch();
    return $orderId[0];
 }

 function getOrderDataById($orderId, $userId){
    $sql = "SELECT shipping_address, paid, delivered, shipping_method, order_code FROM orders WHERE order_id = :orderid AND user_id = :userid ;";
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':orderid' => $orderId,
        ':userid'=> $userId
    ]);
        
    // false if connection error to DB
    if($stmt === false){
        return false;
    }
    //get the user data as array, where every index is a column
    $orderData = [];
    while ($row = $stmt->fetch()) {
        $orderData[] = $row;
    }

    return $orderData[0];
 }

 function getOrderItemsByOrderId($orderId){
    $sql = "SELECT * FROM order_item WHERE order_id = ".$orderId.";";
    $result = getDB()->query($sql);
    
    // false if connection error to DB
    if($result === false){
        return false;
    }
    //get the user data as array, where every index is a column
    $orderItems = [];
    while ($row = $result->fetch()) {
        $orderItems[] = $row;
    }

    return $orderItems;
 }

 function getShippingMethodIdFromTmpOrder(int $userId){
    $sql = "SELECT shipping_method FROM tmp_orders WHERE user_id = :userid ;";
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':userid' => $userId
    ]);
    $shippingMethod = $stmt->fetch();
    return $shippingMethod[0];
 }


 function getShippingMethodPriceById(int $shippingMethodId){
    $sql = "SELECT price FROM shipping_method WHERE shipping_method_id = :shippingmethodid ;";
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':shippingmethodid' => $shippingMethodId
    ]);
    $price = $stmt->fetch();
    return $price[0];
 }

 function getOrderShippingPriceById(int $orderId){
    $sql = 'SELECT shipping_method.price
    FROM shipping_method
    INNER JOIN orders ON orders.shipping_method = shipping_method.shipping_method_id
    WHERE orders.order_id = :orderid;';
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':orderid' => $orderId
    ]);
    $price = $stmt->fetch();
    return $price[0];
 }

 function updateOrderStatusToPaid($orderId){
    try {    
        // SQL Prepared Statement
        $sql = "UPDATE orders SET paid = TRUE WHERE order_id = :orderid;";
        // Prepared Statement
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
            ':orderid'=>$orderId
        ]);
    }catch(PDOException $e) {
        // Fehlerbehandlung, falls ein Fehler auftritt
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }
 }

 function setGelatoOrderId($orderId, $gelatoId){
    try {    
        // SQL Prepared Statement
        $sql = "UPDATE orders SET gelato_id = :gelatoid WHERE order_id = :orderid;";
        // Prepared Statement
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
            ':orderid'=> $orderId,
            ':gelatoid' => $gelatoId
        ]);
    }catch(PDOException $e) {
        // Fehlerbehandlung, falls ein Fehler auftritt
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }
 }

 function getShippingMethodPriceFromTmpOrderById(int $userId){
    $sql = 'SELECT shipping_method.price
    FROM shipping_method
    INNER JOIN tmp_orders ON tmp_orders.shipping_method = shipping_method.shipping_method_id
    WHERE tmp_orders.user_id = :userid;';
    //prepare the sql statement
    $stmt = getDB()->prepare($sql);
    $stmt->execute([
        ':userid' => $userId
    ]);
    $price = $stmt->fetch();
    return $price[0];
 }

