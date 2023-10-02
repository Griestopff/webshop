
                <!-- Card of one order -->
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <?php echo("Bestellnummer:<br>".$order['order_code']);?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Lieferadresse:</strong> <?php echo($order['shipping_address']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Bezahlt:</strong> <?php 
                                if($order['paid'] == 1){
                                    echo('<span style="color:green"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </svg></span>');
                                }else{
                                    echo('<span style="color:red"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                        </svg></span>');} ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Geliefert:</strong> <?php
                                if($order['delivered'] == 1){
                                    echo('<span style="color:green"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </svg></span>');
                                }else{
                                    echo('<span style="color:red"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                        </svg></span>');} ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Versand:</strong> <?php 
                                if($order['shipping_method'] == 1){
                                    echo('Standard Versand (4-7 Werktage)');
                                }else{
                                    echo('Express Versand (3-6 Werktage)');
                                } ?>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <!-- Cards of order_items -->
                        <div class="row">
                            <?php
                                foreach ($orderItems as $orderItem) {
                                    include('./templates/card_orderitem.php');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <hr>
        
    