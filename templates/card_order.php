
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
                                <strong>Bezahlt:</strong> <?php echo($order['paid']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Geliefert:</strong> <?php echo($order['delivered']); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Versand:</strong> <?php echo($order['shipping_method']); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <!-- Cards of order_items -->
                        <div class="row">
                            <?php $orderItems = getAllOrderItemsByOrderId($order['order_id']);
                                foreach ($orderItems as $orderItem) {
                                    include('./templates/card_orderitem.php');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <br>
        
    