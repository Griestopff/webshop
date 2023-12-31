<?php
                #TODO funktiniert nicht
    redirectIfNotLogged("/cart", $userId);
    
    $billingAddress = getBillingAddressByUserId($userId);
    $userData = getUserDataById($userId);
?>
<div class="container">
    <div class="row">
    <p>Kontrolliere deine Versandinformationen. Falls diese nicht korrekt sein sollten, kannst du sie in deinem <a href="<?php echo($baseurl.'index.php/account/addresses');?>">Profil</a> ändern.</p>
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
    <hr>
    <form method="post">
        
            <div class="row">
                <p>Wähle bitte eine Versandart.</p>
                <div class="col-md-6">
                    <div class="card">
                    <div class="card-header">
                            <h5>Standard Versand</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <label for="standard">Standard (<?php echo(getShippingMethodPriceById(1)); ?>€) wählen </label>
                                <input type="radio" name="shipping" value="1" id="standard" required>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        Mittlere Lieferzeit: <b>4-7 Werktage</b>*, innerhalb Deutschlands<br>
                        <small style="opacity: 0.5;">*Die Lieferzeit umfasst den Eingang Ihrer Bestellung, die Produktion und die Lieferung an Ihren Kunden. Lieferzeiten und Versandkosten sind Schätzungen und können nicht garantiert werden. Die endgültigen Kosten und Lieferzeiten sehen Sie an der Kasse.</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Express Versand</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <label for="express">Express (<?php echo(getShippingMethodPriceById(2)); ?>€) wählen</label>
                                <input type="radio" name="shipping" value="2" id="express" required>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        Mittlere Lieferzeit: <b>3-6 Werktage</b>*, innerhalb Deutschlands<br>
                        <small style="opacity: 0.5;">*Die Lieferzeit umfasst den Eingang Ihrer Bestellung, die Produktion und die Lieferung an Ihren Kunden. Lieferzeiten und Versandkosten sind Schätzungen und können nicht garantiert werden. Die endgültigen Kosten und Lieferzeiten sehen Sie an der Kasse.</small>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" style="margin:0px">
            <button type="submit" class="btn btn-warning">Weiter zur Zahlungsmethode</button>
        </div>
    </div>

</form>
<br>






