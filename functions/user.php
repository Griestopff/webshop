<?php

function getCurrentUserId(){
    // if no userId set, generate new one
    $userId = random_int(0, time());

    // first checks the cookie userId
    if(isset($_COOKIE['userId'])){
        $userId = (int) $_COOKIE['userId'];
    }

    // if there is a session id use this
    if(isset($_SESSION['userId'])){
        $userId = (int) $_SESSION['userId'];
    }
    
    return $userId;
}

function getCurrentCookieUserId(){
    // if no userId set, generate new one
    $userId = random_int(0, time());

    // first checks the cookie userId
    if(isset($_COOKIE['userId'])){
        $userId = (int) $_COOKIE['userId'];
    }

    //without session part because if so, you can edit the cart without logged in because your userid is saved in cookie, altrouugh the session is set
    return $userId;
}

//TODO example User, make register
function insertNewUser(){
    $username = "Griestopf";
    $password = password_hash("12345678", PASSWORD_DEFAULT);
    $email = "christophmanitz@gmail.com";
    $first_name = "Christoph";
    $last_name = "Manitz";
    $registercode = rand(0,100000);
    $approved = 1;

    $sql = 'INSERT INTO user SET user_name="'.$username.'", password="'.$password.'", email="'.$email.'", first_name="'.$first_name.'", last_name="'.$last_name.'", registercode="'.$registercode.'", approved="'.$approved.'"';

    try {
        // Insert in table
        $sql = 'INSERT INTO user SET user_name = :username, password = :password, email = :email, first_name = :first_name, last_name = :last_name, registercode = :registercode, approved = :approved';
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
          ':username'=>$username,
          ':password'=>$password,
          ':email'=>$email,
          ':first_name'=>$first_name,
          ':last_name'=>$last_name,
          ':registercode'=>$registercode,
          ':approved'=>$approved
        ]);
        
      } catch(PDOException $e) {
        // Handle any errors that occur during the insertion e.g. duplicate
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
      }
}

//TODO profil oder redirect siehe auch function redirectIfNotLoggedIn()
function login($user, $password):bool{
    // get user id and password-hash
    if((strpos($user, "@") !== false) && (strpos($user, ".") !== false)){
        //email
        $sql = 'SELECT user_id, password FROM user WHERE email="'.$user.'"';
    }else{
        //username
        $sql = 'SELECT user_id, password FROM user WHERE user_name="'.$user.'"';
    }
    
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $userData = [];
    while ($row = $result->fetch()) {
        $userData[] = $row;
    }
    //checks if a colummn with given email/name and password is set
    if(count($userData) < 1){
        return false;
    //has to be exact one column with these credentials, then sets session value for userId (login)
    }elseif(count($userData) == 1){
        if(password_verify($password, $userData[0]["password"])){
            $_SESSION['userId'] = strval($userData[0]['user_id']);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function userIsLoggedIn($userId):bool{
    // Überprüfen, ob die Session-Variable "benutzername" gesetzt ist
    if ((isset($_SESSION['userId'])) && ($_SESSION['userId'] == $userId)) {
        return true;
    } else {
       return false;
    }
}

function logout(){
    session_destroy();
}

function getUserNameByID($userId){
    $sql = 'SELECT user_name FROM user WHERE user_id="'.$userId.'"';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $userData = [];
    while ($row = $result->fetch()) {
        $userData[] = $row;
    }

    return $userData[0]['user_name'];
}

function getUserDataById($userId){
    $sql = 'SELECT user_name, email, first_name, last_name FROM user WHERE user_id="'.$userId.'"';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $userData = [];
    while ($row = $result->fetch()) {
        $userData[] = $row;
    }

    return $userData[0];
}

function UserHasBillingAddress($userId){
    $sql = 'SELECT COUNT(billing_address_id) AS billing_address_count FROM billing_address WHERE user_id = '.$userId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $count = $result->fetch();
    if($count['billing_address_count'] == 1){
        return true;
    }else{
        return false;
    }
}

function getBillingAddressByUserId($userId){
    $sql = 'SELECT location, postal_code, street, number, additional_info FROM billing_address WHERE user_id='.$userId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $billingAddress = [];
    while ($row = $result->fetch()) {
        $billingAddress[] = $row;
    }

    return $billingAddress[0];
}

function UserHasShippingAddress($userId){
    $sql = 'SELECT COUNT(shipping_address_id) AS shipping_address_count FROM shipping_address WHERE user_id = '.$userId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $count = $result->fetch();
    if($count['shipping_address_count'] == 1){
        return true;
    }else{
        return false;
    }
}

function getShippingAddressByUserId($userId){
    $sql = 'SELECT location, postal_code, street, number, additional_info, person FROM shipping_address WHERE user_id='.$userId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $shippingAddress = [];
    while ($row = $result->fetch()) {
        $shippingAddress[] = $row;
    }

    return $shippingAddress[0];
}

function getAllOrdersByUserId($userId){
    $sql = 'SELECT order_id, shipping_address, paid, delivered, shipping_method, order_code FROM orders WHERE user_id='.$userId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $userOrders = [];
    while ($row = $result->fetch()) {
        $userOrders[] = $row;
    }

    return $userOrders;
}

function getAllOrderItemsByOrderId($orderId){
    $sql = 'SELECT order_item_id, product_id, size, color, amount FROM order_item WHERE order_id='.$orderId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $orderItems = [];
    while ($row = $result->fetch()) {
        $orderItems[] = $row;
    }

    return $orderItems;
}

function addProductToWishlist($productId){
    try {
        // Insert in table
        $sql = 'INSERT INTO wishlist SET user_id = :userid, product_id = :productid';
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
          ':userid'=>getCurrentUserId(),
          ':productid'=>$productId
        ]);
        
        // set cookie for alert for "successfully added"
        $cookieValue = 1;
        // 400sec
        $cookieExpiration = time() + (400 * 1); 
        // path from main domain
        $cookiePath = "/"; 
        setcookie('addedToWishlist', $cookieValue, $cookieExpiration,$cookiePath );

      } catch(PDOException $e) {
        // Handle any errors that occur during the insertion e.g. duplicate
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();

        // set cookie for alert for "already in wishlist"
        $cookieValue = 1;
        // 400sec
        $cookieExpiration = time() + (400 * 1); 
        // path from main domain
        $cookiePath = "/"; 
        setcookie('alreadyInWishlist', $cookieValue, $cookieExpiration,$cookiePath );
      }
}

function removeProductFromWishlist($userId, $productId){
    try {
        // Remove the product from the cart table
        $sql = "DELETE FROM wishlist WHERE user_id = :userId AND product_id = :productId";
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
          ':userId'=>$userId,
          ':productId'=>$productId
        ]);

        // set cookie for alert "succesfully removed"
        $cookieValue = 1;
        // 400sec
        $cookieExpiration = time() + (400 * 1); 
        // path from main domain
        $cookiePath = "/"; 
        setcookie('removedFromWishlist', $cookieValue, $cookieExpiration,$cookiePath );
        
      } catch(PDOException $e) {
        // Handle any errors that occur during the insertion e.g. duplicate
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();

        // set cookie for alert "couldnt removed"
        $cookieValue = 1;
        // 400sec
        $cookieExpiration = time() + (400 * 1); 
        // path from main domain
        $cookiePath = "/"; 
        setcookie('couldntRemoveFromWishlist', $cookieValue, $cookieExpiration,$cookiePath);
      }
}

function getAllWishlistItemsByUserId($userId){
    $sql = 'SELECT product.product_name, product.price, product.product_id
    FROM product
    INNER JOIN wishlist ON product.product_id = wishlist.product_id
    WHERE wishlist.user_id = '.$userId.';';

    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $wishlistProducts = [];
    while ($row = $result->fetch()) {
        $wishlistProducts[] = $row;
    }

    return $wishlistProducts; 
}

function changeAddress($addressType, $userId, $location, $street, $number, $postal_code, $additional_info, $person){
    try {    
        // SQL Prepared Statement
        if($addressType == 'billing'){
            $sql = "UPDATE billing_address SET
                    location = :location,
                    postal_code = :postal_code,
                    street = :street,
                    number = :number,
                    additional_info = :additional_info
                WHERE user_id = :user_id";

            // Prepared Statement
            $stmt = getDB()->prepare($sql);
            $stmt->execute([
            ':location'=>$location,
            ':postal_code'=>$postal_code,
            ':street'=>$street,
            ':number'=>$number,
            ':additional_info'=>$additional_info,
            ':user_id'=>$userId
            ]);
        }elseif($addressType == 'shipping'){
            $sql = "UPDATE billing_address SET
                    location = :location,
                    postal_code = :postal_code,
                    street = :street,
                    number = :number,
                    additional_info = :additional_info,
                    person = :person
                WHERE user_id = :user_id";

            // Prepared Statement
            $stmt = getDB()->prepare($sql);
            $stmt->execute([
            ':location'=>$location,
            ':postal_code'=>$postal_code,
            ':street'=>$street,
            ':number'=>$number,
            ':additional_info'=>$additional_info,
            ':user_id'=>$userId,
            ':person'=>$person
            ]);
        }
        
    
        
    } catch (PDOException $e) {
        // Handle any errors that occur during the update
         echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }
}

//TODO didnt work
function redirectIfNotLogged(string $sourceTarget, $userId)
{
    if (userIsLoggedIn($userId)) {
        return;
    }
    $_SESSION['redirectTarget'] = $baseurl . 'index.php' . $sourceTarget;
    header("Location: " . $baseurl . "index.php/login");
    exit();
}

//TODO same name for billing and shipping address, use different names
//changes the address values from table and the user real name to one string, for orders table
function userShippingAddressForOderToString($userId){
    $userData = getUserDataById($userId);
    $name = $userData['first_name']." ".$userData['last_name'];
    
    if(UserHasShippingAddress($userId)){
        $address = getShippingAddressByUserId($userId);
    }else{
        $address = getBillingAddressByUserId($userId);
    }
    $completeAddress = $name.", ".$address['street']." ".$address['number'].", ".$address['postal_code']." ".$address['location'].", ".$address['additional_info'];
    return $completeAddress;
}

//insert a shipping address for the user, if it isnt set 
function addShippingAddress($userId):void{
    #TODO benötigt eigenen Namen für die Anschrift
    if(!UserHasShippingAddress($userId)){
        try {
            // Insert in table
            $sql = "INSERT INTO shipping_address SET user_id = :userId;";
            $stmt = getDB()->prepare($sql);
            $stmt->execute([
            ':userId'=>$userId
            ]);
            
        } catch(PDOException $e) {
            // Handle any errors that occur during the insertion e.g. duplicate
            // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
        }
    }
}

//delets the shipping address for the user, if exists 
function deleteShippingAddress($userId):void{
    if(UserHasShippingAddress($userId)){
        try {
            // Remove the address from the table
            $sql = "DELETE FROM shipping_address WHERE user_id = :userId;";
            $stmt = getDB()->prepare($sql);
            $stmt->execute([
            ':userId'=>$userId
            ]);
        } catch(PDOException $e) {
            // Handle any errors that occur during the insertion e.g. duplicate
            // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
        }
    }   
}

//checks if there is no emtpy field in a address, if there is no shipping address - only look at billing address
function userHasCompletShippingInformation($userId):bool{
    //checks billing_address and shipping_address
    if(UserHasShippingAddress($userId)){
        $sql = "SELECT COUNT(shipping_address_id) AS null_count
        FROM shipping_address
        WHERE user_id = ".$userId." AND (location IS NULL OR street IS NULL OR number IS NULL OR postal_code IS NULL OR location = '' OR street = '' OR number = '' OR postal_code = '' );";
        $countNullShipping = getDB()->prepare($sql);
        $countNullShipping->execute();
      
        // if the request returns false or NULL because of an empty set or error
        if($countNullShipping === false){
            $countShipping = 0;
        }else{
            $countShipping = $countNullShipping->fetchColumn();
            if ($countShipping == NULL){
                $countShipping = 0;
            }
        }
        
        $sql = "SELECT COUNT(billing_address_id) AS null_count
        FROM billing_address
        WHERE user_id = ".$userId." AND (location IS NULL OR street IS NULL OR number IS NULL OR postal_code IS NULL OR location = '' OR street = '' OR number = '' OR postal_code = '' );";
        $countNullBilling = getDB()->prepare($sql);
        $countNullBilling->execute();
      
        // if the request returns false or NULL because of an empty set or error
        if($countNullBilling === false){
            $countBilling = 0;
        }else{
            $countBilling = $countNullBilling->fetchColumn();
            if ($countBilling == NULL){
                $countBilling = 0;
            }
        }
        //$countShipping - amount of columns with NULL values
        if($countShipping + $countBilling < 1){
          return true;
        }else{
          return false;
        }
    }else{
        //checks only billing_address, because there is no shipping_address
        $sql = "SELECT COUNT(billing_address_id) AS null_count
        FROM billing_address
        WHERE user_id = ".$userId." AND (location IS NULL OR street IS NULL OR number IS NULL OR postal_code IS NULL OR location = '' OR street = '' OR number = '' OR postal_code = '' );";
        $countNull = getDB()->prepare($sql);
        $countNull->execute();
      
        // if the request returns false or NULL because of an empty set or error
        if($countNull === false){
            return true;
        }
        $count = $countNull->fetchColumn();
        if ($count == NULL){
            return true;
        }
      
        //$count - amount of columns with NULL values in billing_address
        if($count < 1){
          return true;
        }else{
          return false;
        }
    }
}
