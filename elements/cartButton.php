<?php 
    //saves url, so after add/remove to wishlist can redirect from routes.php back here
    $_SESSION['redirect'] = $url;
    if(productIsInCart($userId, $product['product_id'])){  
            //cant remove from cart here, because its possible that this product ist more then one times in cart with different colors or sizes, and it would remove all of thiscart items
            echo("<a href=".$baseurl."index.php/cart/add/".$product['product_id']."><img src='".$baseurl."styles/svg/cart-check-fill.svg' alt='Produkt ist im Warenkorb, hier klicken zum entfernen' width='25' height='25'></a>");
    }else{
            echo("<a href=".$baseurl."index.php/cart/add/".$product['product_id']."><img src='".$baseurl."styles/svg/cart.svg' alt='Produkt nicht in der Wunschliste, hier klicken zum hinzufügen' width='25' height='25'></a>");
    }
?>