<?php

function getAllProducts(){
    $sql = 'SELECT * FROM product';
    $result = getDB()->query($sql);

    if(!$result){
        return [];
    }
    $products = [];
    while ($row = $result->fetch()) {
        $products[] = $row;
    }

    return $products;
}

function getProductById($productId){
    $sql = 'SELECT product_id, product_name, colors, sizes, description, keywords, price, category FROM product WHERE product_id=' . $productId;
    $stmt = getDB()->query($sql);
    $product = $stmt->fetch();

    return $product;
}

//TODO more filter options
function getProductsBySelection($maxprice, $category){
    if ($category == "all"){
        $sql = 'SELECT * FROM product WHERE price<='.$maxprice;
    }else{
        $sql = 'SELECT * FROM product WHERE category="'.$category.'" AND price<='.$maxprice;
    }
    $result = getDB()->query($sql);

    if(!$result){
        return [];
    }
    $products = [];
    while ($row = $result->fetch()) {
        $products[] = $row;
    }

    return $products;
}
//

#generates a select HTML field for productpage
function fillFormWithJsonOptions($selectName, $jsonField) {
    // Decodes JSON to Array
    $data = json_decode($jsonField, true);
    
    // Generate the HTML for the select field with options from the JSON data
    $html = '<select id="selectOption" name="'.$selectName.'" class="form-control">\n';
    foreach ($data as $value) {
        $html .= "<option value=\"$value\">$value</option>\n";
    }
    $html .= "</select>";
    
    // Return the generated HTML to output it in the form
    return $html;
}

function getProductByOrderItemId($orderItemId){
    $sql = 'SELECT product.product_name, product.price
    FROM product
    INNER JOIN order_item ON product.product_id = order_item.product_id
    WHERE order_item.order_item_id = '.$orderItemId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }
    $product = $result->fetch();
    // contains $product['product_name'] and $product['price]']
    return $product;
}

function productIsInWishlist($userId, $productId){
    $sql = 'SELECT COUNT(wishlist_id) AS wishlist_id_count FROM wishlist WHERE user_id = '.$userId.' AND product_id = '.$productId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $count = $result->fetch();
    if($count['wishlist_id_count'] == 1){
        return true;
    }else{
        return false;
    }
}

function productIsInCart($userId, $productId){
    $sql = 'SELECT COUNT(cart_id) AS cart_id_count FROM cart WHERE user_id = '.$userId.' AND product_id = '.$productId.';';
    $result = getDB()->query($sql);
    // false if connection error to DB
    if($result === false){
        return false;
    }

    $count = $result->fetch();
    if($count['cart_id_count'] == 1){
        return true;
    }else{
        return false;
    }
}

function getImagesByProductId($directory, $prefix) {
    $files = array();
  
    // Überprüfen, ob das Verzeichnis existiert und lesbar ist
    if (is_dir($directory) && is_readable($directory)) {
        // Verzeichnisinhalt lesen
        $dirContents = scandir($directory);
  
        // Durch die Dateien im Verzeichnis iterieren
        foreach ($dirContents as $file) {
          
            // Überprüfen, ob der Dateiname mit dem gewünschten Präfix beginnt
            if (strpos($file, $prefix) === 0) {
                // Den vollständigen Pfad zur Datei erstellen
                $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                $pathPartsFiles = explode("/",$filePath);
                $newPath = "/".$pathPartsFiles[2]."/".$pathPartsFiles[3];
  
                // Nur Dateien (keine Verzeichnisse) hinzufügen
                if (is_file($filePath)) {
                    $files[] = $newPath;
                }
            }
        }
    }
  
    return $files;
  }

  function getProductColorImgId($productId, $color){
    try {    
        // SQL Prepared Statement
        $sql = 'SELECT img_id FROM product_color_img WHERE product_id = :productid AND color = :color;';
        //prepare the sql statement
        $stmt = getDB()->prepare($sql);
        $stmt->execute([
            ':productid' => $productId,
            ':color' => $color
        ]);
        // false if connection error to DB
        if($stmt === false){
            return 1;
        }
        $imgId = $stmt->fetch();
        // false if connection error to DB
        if($imgId === false || $imgId === NULL){
            return 1;
        }
        
        return $imgId[0];
    } catch (PDOException $e) {
        // Handle any errors that occur during the update
        // echo "Es ist ein Fehler aufgetreten: " . $e->getMessage();
        return 1;
    }
  }
