<?php

function addProductToCart(int $userId, int $productId, $color, $size, $amount){
    try {
        // Insert the product into the cart table (calls the procedure)
        $sql = "CALL addProductToCart(:productId, :userId, :color, :size, :amount);";
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
          ':userId'=>$userId,
          ':productId'=>$productId,
          ':color'=>$color,
          ':size'=>$size,
          ':amount'=>$amount
        ]);

      } catch(PDOException $e) {
        // Handle any errors that occur during the insertion e.g. duplicate
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
      }
}

function removeProductFromCart(int $userId, int $cartId){
  try {
      // Remove the product from the cart table
      $sql = "DELETE FROM cart WHERE user_id = :userId AND cart_id = :cartId";
      $stmt = getDB()->prepare($sql);
      $stmt->execute([
        ':userId'=>$userId,
        ':cartId'=>$cartId
      ]);
      
    } catch(PDOException $e) {
      // Handle any errors that occur during the insertion e.g. duplicate
      // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }
}

function removeAllProductsFromCart(int $userId){
  try {
      // Remove the product from the cart table
      $sql = "DELETE FROM cart WHERE user_id = :userId;";
      $stmt = getDB()->prepare($sql);
      $stmt->execute([
        ':userId'=>$userId
      ]);
      
    } catch(PDOException $e) {
      // Handle any errors that occur during the insertion e.g. duplicate
      // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
    }
}

function countProductsInCart(int $userId){
    // addition of amounts from all cart row from user
    $sql = 'SELECT SUM(amount) FROM cart WHERE user_id=' . $userId;
    $cartResult = getDB()->prepare($sql);
    $cartResult->execute();

    // if the request returns false or NULL because of an empty set or error
    if($cartResult === false){
        return 0;
    }
    $cartItems = $cartResult->fetchColumn();
    if ($cartItems == NULL){
        return 0;
    }

    return $cartItems;
}

function getCartItemsForUserId(int $userId){
  // get all information from cart plus product name and price (not stored in cart)
  $sql = "SELECT cart.cart_id, cart.product_id, product.product_name, product.price, cart.size, cart.color, cart.amount FROM cart JOIN product ON(cart.product_id = product.product_id) WHERE user_id =".$userId;

  $result = getDB()->query($sql);
  if($result === false){
    return 0;
  }

  $cartItems = [];
  while ($row = $result->fetch()) {
      $cartItems[] = $row;
  }

  return $cartItems;
}

#generates a select HTML field for cartitems
function fillFormWithJsonOptionsCart($selectName, $jsonField, $selected) {
  // Decodes JSON (colors and sizes of a product) to Array
  $data = json_decode($jsonField, true);
  
  // Generate the HTML for the select field with options from the JSON data
  $html = "<select name=\"$selectName\">";
  // if no color or size in cart selected
  if ($selected == NULL){
    $value = "";
    $html .= "<option value=\"$value\" selected>Wählen</option>\n";
  }
  // a option tag for every entry (color or size)
  foreach ($data as $value) {
      if ($value != $selected){
        $html .= "<option value=\"$value\">$value</option>\n";
      }else{
        $html .= "<option value=\"$value\" selected>$value</option>\n";
      }
      
  }
  $html .= "</select>";
  
  // Return the generated HTML to output it in the form
  return $html;
}

#get the sizes and colors of a product in the cart
function cartItemsToProductSizesColors($cartId){
  try {
    $sql = "SELECT product.sizes, product.colors FROM cart JOIN product ON cart.product_id = product.product_id WHERE cart.cart_id = ".$cartId;
    $result = getDB()->query($sql);
    if($result === false){
      return 0;
    }else{
      
     
      while ($row = $result->fetch()) {
        $productFields = $row;
        //var_dump($row);
      }
      //echo($productFields[0]); 
      // echo($productFields[1]); 
      
      return $productFields;
    }
  }catch(PDOException $e) {
    // Handle any errors that occur during the insertion e.g. duplicate
    //echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
  } 
}

function updateCartItem($cartId, $userId, $productId, $color, $size, $amount){
  // updates a cartitem via procedure to correct if it generates a doubled row, etc.
  $sql = "CALL updateProductInCart(:cartId, :userId, :productId, :color, :size, :amount);";
  $stmt = getDB()->prepare($sql);
  $stmt->execute([
    ':cartId'=>$cartId,
    ':userId'=>$userId,
    ':productId'=>$productId,
    ':color'=>$color,
    ':size'=>$size,
    ':amount'=>$amount
  ]);
}


function getCartPriceSum($userId){;
  $sql = 'SELECT cart.user_id, SUM(product.price * cart.amount) AS cart_total
          FROM cart
          JOIN product ON cart.product_id = product.product_id
          WHERE cart.user_id = :userId;';

  $stmt = getDB()->prepare($sql);
  $stmt->execute([
    ':userId'=>$userId
  ]);
  $sum = $stmt->fetch();
  
  if($sum['cart_total'] == NULL){
    return 0;
  }
  return $sum['cart_total'];
}

function changeCartToSessionUser(){
  $cookieId = getCurrentCookieUserId();
  $sessionId = getCurrentUserId();

  $items = getCartItemsForUserId($cookieId);
  foreach ($items as $item){
    removeProductFromCart($cookieId, $item['cart_id']);
    addProductToCart($sessionId, $item['product_id'], $item['color'], $item['size'], $item['amount']);
  }

}

function everyCartItemHasColorAndSize($userId){
  $sql = "SELECT COUNT(cart_id) AS null_count
  FROM cart
  WHERE user_id = ".$userId." AND (size IS NULL OR color IS NULL);";
  $countNull = getDB()->prepare($sql);
  $countNull->execute();

  // if the request returns false or NULL because of an empty set or error
  if($countNull === false){
      return true;
  }
  $count = $countNull->fetchColumn();
  if ($count == NULL){
      return true;
  }

  if($count < 1){
    return true;
  }else{
    return false;
  }
}
