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

########### PROFIL ###########

if (strpos($route, '/account') !== false){
    if(isset($_POST['userDelete']) && isset($_POST['userDeleteCode']) && isset($_POST['userEmail'])
        && $_POST['userDeleteCode'] !== NULL && $_POST['userDeleteCode'] !== ''
        && $_POST['userEmail'] !== NULL && $_POST['userEmail'] !== ''){
            //TODO baseurl hinzufügen
            $link = '<a href="http://shxrt.de/index.php/account/deleteUser">Link</a>';
            //insert the delte code with userid
            if(insertDeleteCode($userId, $_POST['userDeleteCode'])){
                //send email with the delete code and link to the form
                create_email("Rufen folgenden Link auf und gebe deinen Code: ".$_POST['userDeleteCode']." ein um deinen Account zu löschen:", $link, $_POST['userEmail'], NULL, "Account loeschen");
                echo("<div class='alert alert-success text-center' role='alert'>
                        Du hast eine Email erhalten.
                        </div>");
            }else{
                echo("<div class='alert alert-danger text-center' role='alert'>
                Es ist ein Fehler aufgetreten!
                </div>");
            }
            
    }
}
if (strpos($route, '/account/deleteUser') !== false){
    if(isset($_POST['delete']) && isset($_POST['deleteCode']) && isset($_POST['password'])
    && $_POST['deleteCode'] !== NULL && $_POST['deleteCode'] !== ''
    && $_POST['password'] !== NULL && $_POST['password'] !== ''){
        //TODO
        $userData = getUserDataById($userId);
        //authentification with password
        if(password_verify($_POST['password'], $userData["password"])){
            if(userHasDeleteCode($userId, $_POST['deleteCode'])){
                    deleteUserById($userId);
                    logout();
                    $redirect = $baseurl.'index.php/login';
                    header("Location: $redirect");
                    exit();
            }else{
                //no column with delete code and userId
                echo("<div class='alert alert-danger text-center' role='alert'>
                Der Account wurde nicht zum löschen freigegeben!
                </div>");
            }
        }else{
            //incorrect password
            echo("<div class='alert alert-danger text-center' role='alert'>
                Dein Passwort ist ungültig!
                </div>");
        }
    }
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
                $orderCode = $_SESSION['orderCode'];
                transformTmpOrderToOrder($userId, $orderCode);
                createInvoice($userId, $orderCode);
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

########### REGISTER #########

if (strpos($route, '/register') !== false){
    //every value for registration needs a value
    if((isset($_POST['username']) && $_POST['username'] !== NULL) &&
    (isset($_POST['first_name']) && $_POST['first_name'] !== NULL) &&
    (isset($_POST['last_name']) && $_POST['last_name'] !== NULL) &&
    (isset($_POST['email']) && $_POST['email'] !== NULL) &&
    (isset($_POST['emailRepeat']) && $_POST['emailRepeat'] !== NULL) &&
    (isset($_POST['password']) && $_POST['password'] !== NULL) &&
    (isset($_POST['confirm_password']) && $_POST['confirm_password'] !== NULL)){
        //replace not allowed characters for the names
        $username = preg_replace('/[^a-zA-Z0-9ßäöüÄÖÜ]/u', '', $_POST['username']);
        $first_name = preg_replace('/[^a-zA-Z0-9ßäöüÄÖÜ ]/u', '', $_POST['first_name']);
        $last_name = preg_replace('/[^a-zA-Z0-9ßäöüÄÖÜ ]/u', '', $_POST['last_name']);
        $email = $_POST['email'];
        $emailRepeat = $_POST['emailRepeat'];
        //checks if the passwort contains not allowed characters
        $password = checkPassword($_POST['password']);
        $passwordConfirm = checkPassword($_POST['confirm_password']);
        //checks if email has the format of a email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && filter_var($emailRepeat, FILTER_VALIDATE_EMAIL)) {
            //checks if both emails and boths passwords are equal
            if($email == $emailRepeat){
                if($password == $passwordConfirm){
                    //checks if password contains illegal chars (from checkPassword-Method)
                    if($password !== false){
                        //checks if the email or username is already taken
                        if(!userOrEmailTaken($username, $email)){
                            echo("<div class='alert alert-success text-center' role='alert'>
                            Deine Registrierung war erfolgreich, du erhälst eine Email zum bestätigen danach kannst du dich einloggen!
                            </div>");
                            $insertSuccessfull = insertNewUser($username, $password, $email, $first_name, $last_name);
                            //if insertion of user was successfull login the user
                            if($insertSuccessfull){
                                login($username, $password);
                                //same as for the "/login" route
                                changeCartToSessionUser();
                                $redirectTarget = $baseurl.'index.php/account';
                                header("Location: " . $redirectTarget);
                                exit();
                            }
                        }else{
                            //username or email already taken
                            echo("<div class='alert alert-danger text-center' role='alert'>
                            Der Username oder die Email ist bereits vohanden!
                            </div>");
                        }
                    }else{
                        //password has illegal chars
                        echo("<div class='alert alert-danger text-center' role='alert'>
                        Es sind nicht erlaubt Zeichen im Passwort vorhanden!
                        </div>");
                    }
                }else{
                    //passwords not equal
                    echo("<div class='alert alert-danger text-center' role='alert'>
                    Dein Passwort stimmt nicht überein!
                    </div>");
                }
            }else{
                //emails not equal
                echo("<div class='alert alert-danger text-center' role='alert'>
                Deine Email stimmt nicht überein!
                </div>");
            }
        }else{
            //illegal email format
            echo("<div class='alert alert-danger text-center' role='alert'>
                Das ist kein gültige Email!
                </div>");
        }
    }
}