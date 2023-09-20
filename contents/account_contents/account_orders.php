<br>    
<?php
    $orders = getAllOrdersByUserId($userId);
    foreach ($orders as $order) {
        include('./templates/card_order.php');
    }
?>
        
    
