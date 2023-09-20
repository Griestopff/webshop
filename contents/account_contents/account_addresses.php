<?php
    $billingAddress = getBillingAddressByUserId($userId);

    if (strpos($route, '/account/addresses/edit') !== false){
        if (strpos($route, '/account/addresses/edit/billing') !== false){
?>
<form method="post">
    <div class="card">
        <div class="card-header">
            <h5>Rechnungsaddresse
                <?php
                    //link to editpage for address
                    echo("<a href=".$baseurl."index.php/account/addresses/edit/billing"."><img src='".$baseurl."styles/svg/pencil-square.svg' alt='Produkt ist im Warenkorb, hier klicken zum entfernen' width='25' height='25'></a>");
                    if(!UserHasShippingAddress($userId)){
                        echo("und Lieferaddresse");
                    }
                ?>
            </h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Ort:</strong> 
                    <input type="text" id="location" name="location" placeholder="Ort" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($billingAddress['location']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Postleitzahl:</strong> 
                    <input type="text" id="postal_code" name="postal_code" placeholder="Postleitzahl" pattern="^[0-9]+$" value="<?php echo($billingAddress['postal_code']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Straße:</strong> 
                    <input type="text" id="street" name="street" placeholder="Straße" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($billingAddress['street']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Hausnummer:</strong>
                    <input type="text" id="number" name="number" placeholder="Hausnummer" pattern="^[0-9]+$" value="<?php echo($billingAddress['number']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Zusatz:</strong> 
                    <input type="text" id="additional_info" name="additional_info" placeholder="Zusatz" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($billingAddress['additional_info']); ?>">
                </li>                        
            </ul>
        </div>
    </div>
    <input type="submit" value="Speichern">
</form>
<?php
        }
        if (strpos($route, '/account/addresses/edit/shipping') !== false){
            if(UserHasShippingAddress($userId)){
                $shippingAddress = getShippingAddressByUserId($userId);
?>
<br>
<form method="post">
    <div class="card">
        <div class="card-header">
            <h5>Lieferaddresse
                <?php
                    //link to editpage for address
                    echo("<a href=".$baseurl."index.php/"."><img src='".$baseurl."styles/svg/pencil-square.svg' alt='Produkt ist im Warenkorb, hier klicken zum entfernen' width='25' height='25'></a>");
                ?>
            </h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Person:</strong> 
                    <input type="text" id="person" name="person" placeholder="Vor- und Nachname" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($shippingAddress['person']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Ort:</strong> 
                    <input type="text" id="location" name="location" placeholder="Ort" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($shippingAddress['location']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Postleitzahl:</strong> 
                    <input type="text" id="postal_code" name="postal_code" placeholder="Postleitzahl" pattern="^[0-9]+$" value="<?php echo($shippingAddress['postal_code']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Straße:</strong> 
                    <input type="text" id="street" name="street" placeholder="Straße" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($shippingAddress['street']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Hausnummer:</strong>
                    <input type="text" id="number" name="number" placeholder="Hausnummer" pattern="^[0-9]+$" value="<?php echo($shippingAddress['number']); ?>">
                </li>
                <li class="list-group-item">
                    <strong>Zusatz:</strong> 
                    <input type="text" id="additional_info" name="additional_info" placeholder="Zusatz" pattern="^[a-zA-Z0-9\säöüßÄÖÜ.,]+$" value="<?php echo($shippingAddress['additional_info']); ?>">
                </li>                         
            </ul>
        </div>
    </div>
    <input type="submit" value="Speichern">
</form>
<?php
            }
        }
    }else{
?>
<br>
<div class="card">
    <div class="card-header">
        <h5>Rechnungsaddresse
            <?php
                //link to editpage for address
                echo("<a href=".$baseurl."index.php/account/addresses/edit/billing"."><img src='".$baseurl."styles/svg/pencil-square.svg' alt='Produkt ist im Warenkorb, hier klicken zum entfernen' width='25' height='25'></a>");
                if(!UserHasShippingAddress($userId)){
                    echo("und Lieferaddresse");
                    echo("<a href=".$baseurl."index.php/account/addresses/add/shipping"."><img src='".$baseurl."styles/svg/file-earmark-plus.svg' alt='Lieferaddresse hinzufügen' width='25' height='25'></a>");
                    
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
            </li>                        
        </ul>
    </div>
</div>
<?php
        if(UserHasShippingAddress($userId)){
            $shippingAddress = getShippingAddressByUserId($userId);
?>
<br>
<div class="card">
    <div class="card-header">
        <h5>Lieferaddresse
            <?php
                //link to editpage for address
                echo("<a href=".$baseurl."index.php/account/addresses/edit/shipping"."><img src='".$baseurl."styles/svg/pencil-square.svg' alt='Produkt ist im Warenkorb, hier klicken zum entfernen' width='25' height='25'></a>");
                echo("<a href=".$baseurl."index.php/account/addresses/delete/shipping"."><img src='".$baseurl."styles/svg/file-earmark-x.svg' alt='Lieferaddresse entfernen' width='25' height='25'></a>");
            ?>
        </h5>
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

<?php
        }
    }
?>
<br>

<!--
    The regular expression `^[a-zA-Z0-9\säöüßÄÖÜ.,]+$` has the following meaning:

- `^`: This is an anchor that marks the beginning of the string. The regular expression starts with this character.

- `[a-zA-Z0-9\säöüßÄÖÜ.,]`: This is the main part of the regular expression and defines which characters are allowed in the string. Here's what each part means:

  - `[a-zA-Z0-9]`: This part allows letters from A to Z (both lowercase and uppercase) as well as numbers from 0 to 9. These are alphanumeric characters.

  - `\s`: This allows whitespace characters, including spaces, tabs, and line breaks. `\s` is an escape sequence for whitespace.

  - `äöüßÄÖÜ.,`: These characters are explicitly listed and allow the umlauts (ä, ö, ü, Ä, Ö, Ü), the German sharp s (ß), period (.), and comma (,). They are included directly in the regular expression.

- `+`: This quantifier means "one or more." It requires that at least one allowed character is present.

- `$`: This is an anchor that marks the end of the string. The regular expression ends with this character.

In summary, this regular expression allows letters, numbers, whitespace, umlauts, the German sharp s, period, and comma in the string. All other characters are not allowed. The regular expression ensures that the input conforms to specific criteria before it is accepted.
-->

