<?php
                #TODO funktiniert nicht
    redirectIfNotLogged("/cart", $userId);
    
    $billingAddress = getBillingAddressByUserId($userId);
?>
<div class="container">
  <div class="row justify-content-center">
  <p>Kontrolliere deine Versandinformationen. Falls diese nicht korrekt sein sollten, kannst du sie in deinem <a href="<?php echo($baseurl.'index.php/account/addresses');?>">Profil.</a></p>

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
                            </li>                        </ul>
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
                            </li>                        </ul>
                    </div>
            </div>
            </div>
    <?php
    }
    ?>
    </div>
    <a href="paymentSelection"><button class="btn btn-primary btn-block">Weiter zur Zahlungsmethode</button></a>

    </div>
</div>
    <br>


