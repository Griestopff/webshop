<?php
// GETs set if update button was pressed -> do for cartitem where button was pressed
if(isset($_GET['cartItem']) && ($cartItem[0] == $_GET['cartItem'])){
  if(isset($_GET['size']) && isset($_GET['color']) && isset($_GET['amount'])){
    
    updateCartItem($_GET['cartItem'], $userId, $cartItem[1], $_GET['color'], $_GET['size'], $_GET['amount']);
    // Cookie setzen
    $cookieValue = $_GET['cartItem'];
    // Gültigkeit von 1 Tag
    $cookieExpiration = time() + (86400 * 1); 
    setcookie('cartUpdated', $cookieValue, $cookieExpiration);
    header("Location: ".$baseurl."index.php/cart");
    exit();
  }
  
}
#$cartItem[0] = cart_id
#$cartItem[1] = product_id
#$cartItem[2] = product_name
#$cartItem[3] = price
#$cartItem[4] = size;
#$cartItem[5] = color;
#$cartItem[6] = amount;

$productSizesAndColors = cartItemsToProductSizesColors($cartItem[0])  
?>

<div class="col cartColumn" >
  <div class="cartColumnContent">
    <img src="<?php echo('/img/'.$cartItem[1].'_1.png'); ?>" alt="Product Image" style="width: 80px; margin-right: 10px;">
    <div>
      <h3> <?php echo($cartItem[2]);?></h3>
      <form>

        <label for="sizeSelect">Size:</label>
          <?php echo(fillFormWithJsonOptionsCart("size", $productSizesAndColors[0], $cartItem[4]));?>

        <label for="color">Color:</label>
          <?php echo(fillFormWithJsonOptionsCart("color", $productSizesAndColors[1], $cartItem[5]));?>
          
        <label for="quantity">Quantity:</label>
        <input type="number" name="amount" id="amount" min="1" value="<?php echo($cartItem[6]);?>">
        <button type="submit" name="cartItem" value="<?php echo($cartItem[0]);?>">Update</button>
        
        <?php 
          if(isset($_COOKIE['cartUpdated']) && $_COOKIE['cartUpdated'] == $cartItem[0]) {
            // delete cookie 
            unset($_COOKIE['cartUpdated']);
            setcookie('cartUpdated', "", time() - 3600);
            // show checkmark
            include('./elements/checkmark.html');
          }
        ?>

      </form>

      <a href=<?php echo($baseurl."index.php/cart/remove/".$cartItem[0])?>>Löschen</a>
      
    </div>
  </div>
  <div class="cartPrice">
    <p><?php echo($cartItem[3]);?>€</p>
    
  </div>
</div>
