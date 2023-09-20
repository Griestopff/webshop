<div id="banner">
     Deine Bestellung
</div>
<section id="cartItems">
    <?php 
        $cartItems = getCartItemsForUserId($userId);
        // generates CartItemField (with information and select fields) for every item in cart
        foreach($cartItems as $cartItem){
            include("./templates/orderItem.php");
        }
    ?>
</section>
<div class="container">
    <div class="row">
    <div class="col-md-6 offset-md-3">
<form action=<?php echo($baseurl.'index.php/checkout/paymentComplete');?> method="post">
        <input type="hidden" name="token" value="<?php echo($_GET['token']);?>">
        <input type="hidden" name="PayerID" value="<?php echo($_GET['PayerID']);?>">
        <button type="submit" name="paymentComplete" class="btn btn-block btn-primary" value="Kostenpflichtig bestellen">Kostenpflichtig bestellen</button>
</form>
    </div>
    </div>
    </div>