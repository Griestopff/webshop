<?php
// GETs set if update button was pressed -> do for cartitem where button was pressed
if(isset($_GET['cartItem'])){
    if(isset($_GET['size']) && isset($_GET['color']) && isset($_GET['amount']) && isset($_GET['product_id'])){
      
      updateCartItem($_GET['cartItem'], $userId, $_GET['product_id'], $_GET['color'], $_GET['size'], $_GET['amount']);
      // Cookie setzen
      $cookieValue = $_GET['cartItem'];
      // Gültigkeit von 1 Tag
      $cookieExpiration = time() + (86400 * 1); 
      if (hasCookieConsent()) {
        setcookie('cartUpdated', $cookieValue, $cookieExpiration);
      }
      header("Location: ".$baseurl."index.php/cart");
      exit();
    }
    
  }
  $show_checkmark = 0;
  if(isset($_COOKIE['cartUpdated'])) {
    $show_checkmark = $_COOKIE['cartUpdated'];
    // delete cookie 
    unset($_COOKIE['cartUpdated']);
    if (hasCookieConsent()) {
        setcookie('cartUpdated', "", time() - 3600);
    }
  } 
?>
<div id="banner">
     Warenkorb
</div>
<div class="container">
<section id="cartItems">
    <?php 
        $cartItems = getCartItemsForUserId($userId);
        // generates CartItemField (with information and select fields) for every item in cart
        foreach($cartItems as $cartItem){
            include("./templates/cartItem.php");
        }
        if(count($cartItems) < 1){
            echo("<div class='alert alert-warning text-center' role='alert'>
            Du hast keine Produkte in deinem Warenkorb.
                              </div>");
          }
    ?>
</section>
        </div>
<hr>
<div class="container">
        <div class="row">
            <!--#TODO Versandinformationen page-->
            <p><small style="opacity: 0.5;">inkl. MwSt. zzgl. Versandkosten</small><br><b>Gesamtpreis: <?php echo(getCartPriceSum($userId)); ?>€</b></p>
        </div><!-- Bezahlen-Button 
    #TODO wenn eingeloggt normal umleiten, wenn nicht zum loginpage, aber wenn dann eingeloggt wieder zu checkout (und nicht account) umleiten-->
   
    <?php
    if(userIsLoggedIn($userId)){
        if(userApproved($userId)){
            if(everyCartItemHasColorAndSize($userId)){
                if(userHasCompletShippingInformation($userId)){
                    echo('<a href="'.$baseurl.'index.php/checkout/shipping"style="text-decoration:none"><div class="row"><button class="btn btn-warning btn-block"><b>Bestellen</b></button></div></a>');
                }else{
                    echo("<div class='alert alert-warning text-center' role='alert'>
                    Deine hinterlegten Versandinformationen sind unvollständig. Du kannst sie <a href='".$baseurl."index.php/account/addresses'>hier</a> ändern 
                    </div>");
                }
            }else{
                echo("<div class='alert alert-warning text-center' role='alert'>
                    Wähle für jedes Produkt eine Größe und eine Farbe!
                    </div>");
            }
        }else{
            echo("<div class='alert alert-warning text-center' role='alert'>
            Bitte bestätige vorher deinen Account! Du kannst dich <a href='".$baseurl."index.php/account'>hier</a> per Email bestätigen 
            </div>");
        }
        
    }else{
        echo('<a href="'.$baseurl.'index.php/login" style="text-decoration:none"><div class="row"><button class="btn btn-warning btn-block"><b>Bestellen</b></button></div></a>');
    }
    ?>
   
</div>
<br>


