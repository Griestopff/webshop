<?php
  checkWishlistCookie();
?>
<div class="container">
  <div class="row justify-content-center">
    <?php
      $wishlistProducts = getAllWishlistItemsByUserId($userId);
      
      //if no products in wishlist
      if(count($wishlistProducts) < 1){
        echo("<p>Du hast noch keine Produkte in deiner Wunschliste!</p>");
      }else{
         //if there are products in the wishlist, show them
        foreach ($wishlistProducts as $product) {
          include('./templates/card_frontpage.php');
        }
      }
    ?>
  </div>
</div>