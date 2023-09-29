<div class="container">
    <h2>Zahlungsmethode</h2>
    <form action=<?php echo($baseurl.'index.php/checkout/paymentSelection');?> method="post">
        <div class="form-group">
            <label for="PayPal"><b>PayPal</b></label>
            <input type="radio" name="payment" value="paypal" id="PayPal">
        </div>
        <br>
        <div class="form-group">
            <button class="btn btn-warning" type="submit" value="Wählen">Wählen</button>
        </div>
    </form>
</div>
<br>
