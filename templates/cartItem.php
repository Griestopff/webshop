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
      <h3><?php echo($cartItem[2]);?></h3>
      <form>
        <div class="row">
          <div class="col-md-3">
            <label for="sizeSelect">Size:</label>
            <?php echo(fillFormWithJsonOptionsCart("size", $productSizesAndColors[0], $cartItem[4]));?>
          </div>
          <div class="col-md-3">
            <label for="color">Color:</label>
            <?php echo(fillFormWithJsonOptionsCart("color", $productSizesAndColors[1], $cartItem[5]));?>
          </div>
          <div class="col-md-3">
            <input type="hidden" name="product_id" value="<?php echo($cartItem[1]);?>">
            <label for="quantity">Quantity:</label>
            <input type="number" name="amount" id="amount" min="1" class="form-control" value="<?php echo($cartItem[6]);?>">
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-warning" name="cartItem" value="<?php echo($cartItem[0]);?>"><!--Update--> 
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
              </svg>
              <?php
                if($show_checkmark == $cartItem[0]) {
                  //show checkmark
                  include('./elements/checkmark.html');
                  $show_checkmark = 0;
                }
              ?>
            </button>
            <a href=<?php echo($baseurl."index.php/cart/remove/".$cartItem[0])?>>
              <button type="button" class="btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                </svg>
              </button>
            </a> 
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="cartPrice">
    <p><?php echo($cartItem[3]);?>€</p>
  </div>
</div>
