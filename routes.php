<?php
// script to manage the URL content


$userId = getCurrentUserId();
// get the route from URL
$url = $_SERVER['REQUEST_URI'];



$indexPHPPosition = strpos($url, 'index.php');
$route = substr($url, $indexPHPPosition);
$route = str_replace('index.php', '', $route);

// part before index.php/...
$baseurl = explode("index.php", $url)[0];

// Debugging
// var_dump($route);
// var_dump($baseurl);

########### CART #########
// check if the route contains '/cart/add'
if (strpos($route, '/cart/add') !== false){
    // falls vor .../index.php noch was steht
    $source = explode('/cart/add',$route);
    $route = '/cart/add'.$source[1];

    // set cookie for checkmark in header
    $cookieValue = 1;
    // 1 day expiration
    $cookieExpiration = time() + (86400 * 1); 
    // path from main domain
    $cookiePath = "/"; 
    setcookie('cartAdd', $cookieValue, $cookieExpiration,$cookiePath );
   
    $routeParts = explode('/',$route);
    $productId = (int)$routeParts[3];
    // content of route parts on (1) frontpage and (2) productpage
    # (1) array(4) { [0]=> string(0) "" [1]=> string(4) "cart" [2]=> string(3) "add" [3]=> string(1) "1" } 
    # (2) array(5) { [0]=> string(0) "" [1]=> string(4) "cart" [2]=> string(3) "add" [3]=> string(1) "2" [4]=> string(18) "?size=S&color=blue" } 
    // Debugging
    // var_dump(count($routeParts));

    if((isset($_GET['color'])) && (isset($_GET['size']))){
        addProductToCart($userId,$productId, $_GET['color'], $_GET['size'], 1);
    }else{
        addProductToCart($userId,$productId, NULL, NULL, 1);
    }

    header("Location: ".$_SESSION['redirect']);
    exit();
}

// check if the route contains '/cart/remove'
if (strpos($route, '/cart/remove') !== false){
   
    // falls vor .../index.php noch was steht
    $product_remove = explode('/cart/remove',$route);
    $route = '/cart/remove'.$product_remove[1];

    $routeParts = explode('/',$route);
    $cartId = (int)$routeParts[3];
    
    removeProductFromCart($userId,$cartId);
    
    // Redirect the user to the cartpage (only there you can remove cartItems)
    header("Location: ".$baseurl."index.php/cart");
    exit();
}

########### LOGIN #########
// check if the route contains '/logoute'
if (strpos($route, '/logout') !== false){
   
    logout();
    
    // Redirect the user to the homepage
    header("Location: ".$baseurl."index.php");
    exit();
}

// check if the route contains '/login' to login the user
if (strpos($route, '/login') !== false){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        //filter special characters
        $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password');
        if(login($_POST["username"], $_POST["password"])){
            // DEBUGGING
            //echo("Erfolgreich eingeloggt mit der UserID: ".$userId);
            changeCartToSessionUser();
            $redirectTarget = $baseurl.'index.php/account';
            #TODO funktiniert nicht
            if (isset($_SESSION['redirectTarget'])) {
                $redirectTarget = $_SESSION['redirectTarget'];
            }
            header("Location: " . $redirectTarget);
            exit();
        }else{
          echo("<div class='alert alert-danger text-center' role='alert'>
                Die Zugangsdaten sind nicht korrekt oder unvollständig!
                </div>");
        }
      }
    
}

########### WISHLIST #########
// check if the route contains '/wishlist/add' to add a product to the wishlist of the user
if (strpos($route, '/wishlist/add') !== false){
    // falls vor .../index.php noch was steht
    $wish_add = explode('/wishlist/add',$route);
    $route = '/wishlist/add'.$wish_add[1];

    $routeParts = explode('/',$route);
    $productId = (int)$routeParts[3];
    
    if(userIsLoggedIn($userId)){
        addProductToWishlist($productId);
    }else{
        # redirect to the loginpage
        echo("<div class='alert alert-warning text-center' role='alert'>
        Du bist nicht eingeloggt!
        </div>");
        $redirect = $baseurl.'index.php/login';
        header("Location: $redirect");
        exit();
    }
    // Redirect to the page where user come from
    header("Location: ".$_SESSION['redirect']);
    exit();
}

if (strpos($route, '/wishlist/remove') !== false){
    // falls vor .../index.php noch was steht
    $wish_remove = explode('/wishlist/remove',$route);
    $route = '/wishlist/remove'.$wish_remove[1];

    $routeParts = explode('/',$route);
    $productId = (int)$routeParts[3];
    
    if(userIsLoggedIn($userId)){
        removeProductFromWishlist($userId, $productId);
    }else{
        # redirect to the loginpage
        echo("<div class='alert alert-warning text-center' role='alert'>
        Du bist nicht eingeloggt!
        </div>");
        $redirect = $baseurl.'index.php/login';
        header("Location: $redirect");
        exit();
    }
    
    // Redirect to the page where user come from
    header("Location: ".$_SESSION['redirect']);
    exit();
}

########### ADDRESSES #########

if (strpos($route, '/account/addresses/edit') !== false){
    if((isset($_POST['location'])) && (isset($_POST['street'])) && (isset($_POST['number'])) && (isset($_POST['postal_code'])) && (isset($_POST['additional_info']))){
        // remove special characters, allow letters, numbers, ".", ",", "/", "ß" and umlaute
        $person = preg_replace('/[^a-zA-Z0-9.,\/ßäöüÄÖÜ ]/u', '', $_POST['person']);
        $location = preg_replace('/[^a-zA-Z0-9.,\/ßäöüÄÖÜ]/u', '', $_POST['location']);
        $street = preg_replace('/[^a-zA-Z0-9.,\/ßäöüÄÖÜ]/u', '', $_POST['street']);
        $number = preg_replace('/[^0-9.,\/]/u', '', $_POST['number']);
        $postal_code = preg_replace('/[^0-9.,\/]/u', '', $_POST['postal_code']);
        $additional_info = preg_replace('/[^a-zA-Z0-9.,\/ßäöüÄÖÜ]/u', '', $_POST['additional_info']);

        // get route after .../index.php
        $route_part = explode('/account/addresses/edit',$route);
        $route = '/account/addresses/edit'.$route_part[1];

        $routeParts = explode('/',$route);
        $addressType = $routeParts[4];
        
        if(userIsLoggedIn($userId)){
            changeAddress($addressType, $userId, $location, $street, $number, $postal_code, $additional_info, $person);
        }
            
        else{
            # redirect to the loginpage
            echo("<div class='alert alert-warning text-center' role='alert'>
            Du bist nicht eingeloggt!
            </div>");
            $redirect = $baseurl.'index.php/login';
            header("Location: $redirect");
            exit();
        }
        
        // Redirect to the page where user come from
        $redirect = $baseurl.'index.php/account/addresses';
        header("Location: $redirect");
        exit();
    }
}

if (strpos($route, '/addresses/add/shipping') !== false){
    addShippingAddress($userId);
    // Redirect to the page where user come from
    $redirect = $baseurl.'index.php/account/addresses';
    header("Location: $redirect");
    exit();
}

if (strpos($route, '/addresses/delete/shipping') !== false){
    deleteShippingAddress($userId);
    // Redirect to the page where user come from
    $redirect = $baseurl.'index.php/account/addresses';
    header("Location: $redirect");
    exit();
}

########### CHECKOUT #########

if (strpos($route, '/checkout/shipping') !== false){
    if(everyCartItemHasColorAndSize($userId) && userHasCompletShippingInformation($userId) && userApproved($userId)){
        //TODO
        $_SESSION['checkoutStatus'] = 'RUNNING';
        createNewTmpOrder($userId, 1);
    }else{
        // Redirect to the page where user come from
        $redirect = $baseurl.'index.php/cart';
        header("Location: $redirect");
        exit();
    }
}

//creates order for Paypal
if (strpos($route, '/checkout/paymentSelection') !== false){
    //if logged in and a payment method was selected (paypal) create order with accesstoken
    if(userIsLoggedIn($userId) && userApproved($userId)){
        if(isset($_POST['payment'])){
            if($_POST['payment'] === 'paypal'){
                $accessToken = getAccessToken(); 
                createPayPalOrder($accessToken,[], $userId); 
            }#elseif($_POST['payment'] === otherPayments){
            #}
        }
    }else{
        # redirect to the loginpage
        echo("<div class='alert alert-warning text-center' role='alert'>
        Du bist nicht eingeloggt!
        </div>");
        $redirect = $baseurl.'index.php/login';
        header("Location: $redirect");
        exit();
    }
}

if (strpos($route, '/checkout/paymentComplete') !== false){
    //if user is logged in get cash from customer
    if(userIsLoggedIn($userId) && userApproved($userId)){
        #TODO
        #if(PAYPAL){}
        if(isset($_POST['token']) && isset($_POST['PayerID']) && isset($_SESSION['orderCode']) && $_SESSION['checkoutStatus'] == 'RUNNING'){
            //TODO check with internet if working
            if(paypalPaymentComplete($_POST['token'], $_POST['PayerID']) == 'COMPLETED') { 
                 transformTmpOrderToOrder($userId, $_SESSION['orderCode']);
                $_SESSION['checkoutStatus'] = 'COMPLETE';
                echo("<div class='alert alert-success' role='alert'>
                Deine Bestellung war erfolgreich! Sieh sie dir <a href='".$baseurl."index.php/account/orders'>hier</a> an.
              </div>");
           } 
        }
    }else{
        # redirect to the loginpage
        echo("<div class='alert alert-warning text-center' role='alert'>
        Du bist nicht eingeloggt!
        </div>");
        $redirect = $baseurl.'index.php/login';
        header("Location: $redirect");
        exit();
    }
}

########### CHECKOUT #########

if (strpos($route, '/register') !== false){
    

    if((isset($_POST['username']) && $_POST['username'] !== NULL) &&
    (isset($_POST['first_name']) && $_POST['first_name'] !== NULL) &&
    (isset($_POST['last_name']) && $_POST['last_name'] !== NULL) &&
    (isset($_POST['email']) && $_POST['email'] !== NULL) &&
    (isset($_POST['emailRepeat']) && $_POST['emailRepeat'] !== NULL) &&
    (isset($_POST['password']) && $_POST['password'] !== NULL) &&
    (isset($_POST['confirm_password']) && $_POST['confirm_password'] !== NULL)){
        $username = preg_replace('/[^a-zA-Z0-9ßäöüÄÖÜ]/u', '', $_POST['username']);
        $first_name = preg_replace('/[^a-zA-Z0-9ßäöüÄÖÜ ]/u', '', $_POST['first_name']);
        $last_name = preg_replace('/[^a-zA-Z0-9ßäöüÄÖÜ ]/u', '', $_POST['last_name']);
        $email = $_POST['email'];
        $emailRepeat = $_POST['emailRepeat'];
        $password = checkPassword($_POST['password']);
        $passwordConfirm = checkPassword($_POST['confirm_password']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && filter_var($emailRepeat, FILTER_VALIDATE_EMAIL)) {
            if($email == $emailRepeat){
                if($password == $passwordConfirm){
                    if($password !== false){
                        if(!userOrEmailTaken($username, $email)){
                            echo("<div class='alert alert-success text-center' role='alert'>
                            Deine Registrierung war erfolgreich, du erhälst eine Email zum bestätigen danach kannst du dich einloggen!
                            </div>");
                            $insertSuccessfull = insertNewUser($username, $password, $email, $first_name, $last_name);
                            if($insertSuccessfull){
                                //login user
                                //header zu profil
                            }
                        }else{
                            echo("<div class='alert alert-danger text-center' role='alert'>
                            Der Username oder die Email ist bereits vohanden!
                            </div>");
                        }
                    }else{
                        echo("<div class='alert alert-danger text-center' role='alert'>
                        Es sind nicht erlaubt Zeichen im Passwort vorhanden!
                        </div>");
                    }
                }else{
                    echo("<div class='alert alert-danger text-center' role='alert'>
                    Dein Passwort stimmt nicht überein!
                    </div>");
                }
            }else{
                echo("<div class='alert alert-danger text-center' role='alert'>
                Deine Email stimmt nicht überein!
                </div>");
            }
        }else{
            echo("<div class='alert alert-danger text-center' role='alert'>
                Das ist kein gültige Email!
                </div>");
        }
    }
}