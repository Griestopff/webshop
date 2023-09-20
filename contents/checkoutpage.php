<?php
if(!userIsLoggedIn($userId)){
    # redirect to the loginpage
    echo("<div class='alert alert-warning text-center' role='alert'>
           Du bist nicht eingeloggt!
           </div>");
    $redirect = $baseurl.'index.php/login';
    header("Location: $redirect");
    exit();
}else{

    // Include the specific content
        // Check the rout
        if(strpos($route, '/checkout/shipping') !== false){
            echo("<b>Versand</b> ---> Zahlungsmethode ---> Bestellübersicht ---> Fertig<hr>");
            include(__DIR__."/checkout_contents/checkout_shipping.php");
        }elseif(strpos($route, '/checkout/paymentSelection') !== false){
            echo("<b>Versand</b> ---> <b>Zahlungsmethode</b> ---> Bestellübersicht ---> Fertig<hr>");
            include(__DIR__."/checkout_contents/checkout_payment.php");
        }elseif(strpos($route, '/checkout/order') !== false){
            echo("<b>Versand</b> ---> <b>Zahlungsmethode</b> ---> <b>Bestellübersicht</b> ---> Fertig<hr>");
            include(__DIR__."/checkout_contents/checkout_order.php");
        }elseif(strpos($route, '/checkout/paymentComplete') !== false){
            echo("<b>Versand</b> ---> <b>Zahlungsmethode</b> ---> <b>Bestellübersicht</b> ---> <b>Fertig</b><hr>");
            include(__DIR__."/checkout_contents/checkout_complete.php");
        }else{
            include(__DIR__."/checkout_contents/checkout_error.php");
        }

}
?>