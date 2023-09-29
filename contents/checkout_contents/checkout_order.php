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
    <br>
    <div class="container">
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
        