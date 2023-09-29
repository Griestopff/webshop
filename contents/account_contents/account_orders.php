<br>    
<?php
    $orders = getAllOrdersByUserId($userId);
    foreach ($orders as $order) {
        $orderItems = getOrderItemsByOrderId($order['order_id']);
        include('./templates/card_order.php');
    }
?>
        
    
