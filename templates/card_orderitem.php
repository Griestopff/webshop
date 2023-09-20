<?php
    $product = getProductByOrderItemId($orderItem['order_item_id']);
?>
<div class="col-md-4">
    <!-- Kleinere Card 1 -->
    <div class="card">
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Produkt:</strong> <?php echo($product['product_name']);?>
                </li>
                <li class="list-group-item">
                    <strong>Größe:</strong> <?php echo($orderItem['size']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Farbe:</strong> <?php echo($orderItem['color']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Anzahl:</strong> <?php echo($orderItem['amount']); ?>
                </li>
                <li class="list-group-item">
                    <strong>Preis:</strong> <?php echo($product['price']);?>€
                </li>
            </ul>
        </div>
    </div>
</div>