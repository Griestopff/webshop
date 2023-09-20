Payment
<form action=<?php echo($baseurl.'index.php/checkout/paymentSelection');?> method="post">
        <label>
            <input type="radio" name="payment" value="paypal"> PayPal
        </label>
        <label>
            <input type="radio" name="payment" value="x"> Sonstiges
        </label>
        <input type="submit" value="Wählen">
    </form>

