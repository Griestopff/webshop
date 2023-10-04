<?php
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
    <img src="<?php echo('/img/'.$cartItem[1].'_'.getProductColorImgId($cartItem[1], $cartItem[5]).'.png'); ?>" alt="Product Image" style="width: 80px; margin-right: 10px;">
    <div>
      <h3> <?php echo($cartItem[2]);?></h3>
      <form>
      <button type="button" class="btn btn-outline-secondary btn-no-hover"><label>Größe: <?php echo($cartItem[4]." ");?></label></button>
      <button type="button" class="btn btn-outline-secondary btn-no-hover"><label>Farbe: <?php echo($cartItem[5]." ");?></label></button>
      <button type="button" class="btn btn-outline-secondary btn-no-hover"><label>Anzahl: <?php echo($cartItem[6]." ");?></label></button>
      </form>
    </div>
  </div>
  <div class="cartPrice">
    <p><?php echo($cartItem[3]);?>€</p>
  </div>
</div>
