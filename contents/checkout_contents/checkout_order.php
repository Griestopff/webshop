<div id="banner">
     Deine Bestellung
</div>
<div class="container">
    <section id="cartItems">
        <?php 
            $cartItems = getCartItemsForUserId($userId);
            // generates CartItemField (with information and select fields) for every item in cart
            foreach($cartItems as $cartItem){
                include("./templates/orderItem.php");
            }
        ?>
    </section>
    <hr>
    <div class="container"><?php
    $billingAddress = getBillingAddressByUserId($userId);
    $userData = getUserDataById($userId);
?>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Rechnungsaddresse
                    <?php
                        if(!UserHasShippingAddress($userId)){
                            echo("und Lieferaddresse");
                        }
                    ?>
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Person:</strong> <?php echo($userData['first_name']." ".$userData['last_name']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Ort:</strong> <?php echo($billingAddress['location']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Postleitzahl:</strong> <?php echo($billingAddress['postal_code']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Straße:</strong> <?php echo($billingAddress['street']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Hausnummer:</strong> <?php echo($billingAddress['number']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Zusatz:</strong> <?php echo($billingAddress['additional_info']); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
<?php
    if(UserHasShippingAddress($userId)){
        $shippingAddress = getShippingAddressByUserId($userId);
?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Lieferaddresse</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Person:</strong> <?php echo($shippingAddress['person']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Ort:</strong> <?php echo($shippingAddress['location']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Postleitzahl:</strong> <?php echo($shippingAddress['postal_code']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Straße:</strong> <?php echo($shippingAddress['street']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Hausnummer:</strong> <?php echo($shippingAddress['number']); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Zusatz:</strong> <?php echo($shippingAddress['additional_info']); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
<?php
    }
?>
    </div>
        
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <p><b>Gesamtpreis: <?php echo(getCartPriceSum($userId)); ?>€</b><small style="opacity: 0.5;"> inkl. MwSt.</small><br><small style="opacity: 0.5;">Versandkosten: <?php echo(getShippingMethodPriceFromTmpOrderById($userId)); ?>€</small></p>
        </div>
        <div class="row">
            <form action=<?php echo($baseurl.'index.php/checkout/paymentComplete');?> method="post">
                <input type="hidden" name="token" value="<?php echo($_GET['token']);?>">
                <input type="hidden" name="PayerID" value="<?php echo($_GET['PayerID']);?>">
                <div class="row"><button type="submit" name="paymentComplete" class="btn btn-block btn-warning" value="Kostenpflichtig bestellen">Kostenpflichtig bestellen</button></div>
            </form>
        </div>
    </div>
    <br>
</div>
        

