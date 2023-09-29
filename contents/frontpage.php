<!--The frontpage is the first page the user sees-->
<?php
  checkWishlistCookie();
?>
<div id="banner">
      Mein Shop
</div>

<!--defines a responsive layout via Bootstraps row class to place the cards of the products-->
<br>
<div class="container">
  <div class="row justify-content-center">

    <?php 
    // Select all products from the database
    $products = getAllProducts();
  
    // Loop through each product and include the card template
    foreach ($products as $product) {
      include('./templates/card_frontpage.php');
    }
    ?>

  </div>
</div>
  
  
  
