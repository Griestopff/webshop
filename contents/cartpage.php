<div id="banner">
     Warenkorb
</div>
<section id="cartItems">
    <?php 
        $cartItems = getCartItemsForUserId($userId);
        // generates CartItemField (with information and select fields) for every item in cart
        foreach($cartItems as $cartItem){
            include("./templates/cartItem.php");
        }
    ?>
</section>
<hr>
<div class="warenkorb-box">
    <p>Gesamtpreis: <?php echo(getCartPriceSum($userId)); ?>€</p>
    <!-- Bezahlen-Button 
    #TODO wenn eingeloggt normal umleiten, wenn nicht zum loginpage, aber wenn dann eingeloggt wieder zu checkout (und nicht account) umleiten-->
    <?php
    if(userIsLoggedIn($userId)){
        if(userApproved($userId)){
            if(everyCartItemHasColorAndSize($userId)){
                if(userHasCompletShippingInformation($userId)){
                    echo('<a href="'.$baseurl.'index.php/checkout/shipping"><button class="btn btn-primary btn-block">Bezahlen</button></a>');
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
        echo('<a href="'.$baseurl.'index.php/login"><button class="btn btn-primary btn-block">Bezahlen</button></a>');
    }
    ?>
</div>



