<?php 
    //saves url, so after add/remove to wishlist can redirect from routes.php back here
    $_SESSION['redirect'] = $url;
    if(productIsInWishlist($userId, $product['product_id'])){  
            echo("<a href=".$baseurl."index.php/wishlist/remove/".$product['product_id']."><img src='".$baseurl."styles/svg/bookmark-heart-fill.svg' alt='Produkt in der Wunschliste, hier klicken zum entfernen' width='25' height='25'></a>");
    }else{
            echo("<a href=".$baseurl."index.php/wishlist/add/".$product['product_id']."><img src='".$baseurl."styles/svg/bookmark-heart.svg' alt='Produkt nicht in der Wunschliste, hier klicken zum hinzufügen' width='25' height='25'></a>");
    }
?>