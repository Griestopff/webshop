<?php
    $parts = explode("/", $route);
    //$parts[0]='', $parts[1]='product', $parts[2]=product_id
    
    $product = getProductById($parts[2]);

    checkWishlistCookie();

    #check which product (color-size combination) is available
    $products_available = [];
    $products_not_available = [];

    #TODO distiguish "stock" "nonstock" and "unknown"
    foreach(json_decode($product["colors"]) as $color){
      foreach(json_decode($product["sizes"]) as $size){
        $availability = checkGelatoAvailability($parts[2], $color,  $size);
        if($availability == "stock"){
          $pair = [$color, $size];
          array_push($products_available, $pair);
        }else if($availability == "nonstock"){
          $pair = [$color, $size];
          array_push($products_not_available, $pair);
        }else if($availability == "unknown"){
          $pair = [$color, $size];
          array_push($products_not_available, $pair);
        }else{
          $pair = [$color, $size];
          array_push($products_not_available, $pair);
        }
      }
    }

    $directory = '../htdocs/img';
    $prefix = $product['product_id'].'_';
    $matchingFiles = getImagesByProductId($directory, $prefix);
    // $matchingFiles enthält jetzt ein Array mit den Dateien, die den gewünschten Präfix haben

?>
<br>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="slideshow-container unselectable">
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <?php
        foreach($matchingFiles as $file){
          echo('<img id="productImage" src="'.$file.'" alt="Product Image" class="img-fluid slideshow-img shxrt-img">');
        }
        ?>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>
    </div>
    <div class="col-md-6" style="margin-top:20px">
      <h2>
        <b><?php  echo($product['product_name']);?></b>
        <?php 
          include("./elements/wishlistButton.php");
        ?>
      </h2>
      <p>
        <span class="lead"><?php  echo($product['price']);?>€ </span>
        <!--#TODO Versandinformationen page-->
        <small style="opacity: 0.5;">inkl. MwSt. zzgl. Versandkosten</small>
      </p>
      <hr>
      <form action=<?php echo($baseurl."index.php/cart/add/".$product['product_id']."/")?>>
        <div class="form-group">
          <label for="sizeSelect">Size:</label>
          <?php echo(fillFormWithJsonOptions("size", $product['sizes']));?>
        </div>
        <div class="form-group">
          <label for="colorSelect">Color:</label>
          <?php echo(fillFormWithJsonOptions("color", $product['colors']));?>        
        </div>
        <br>
        <div class="row" style="margin:0px">
          <button type="submit" class="btn btn-warning">Zum Warenkorb</button>
        </div>
      </form>
      <br>
      <div class="row" style="margin:0px">
        
          
          <?php
          if(count($products_not_available) < 1 && count($products_available) > 0){
            echo('
            <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:green">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <small>Verfügbar, versandfertig in 1-3 Werktagen</small>
            </button>');
          }else if(count($products_not_available) > 0 && count($products_available) > 0){
            echo('
            <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:green">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <small>Verfügbar, versandfertig in 1-3 Werktagen</small>
            </button>
            ');
            $products_not_ava = "";
            foreach($products_not_available as $not){
              $products_not_ava = $products_not_ava.implode(" ", $not).", ";
            }
            echo('
            <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:red">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>
            <small>Nicht auf Lager: '.$products_not_ava.'</small>
            </button>');
          }else if(count($products_not_available) > 0 && count($products_available) < 1){
            #if no product available or no information from gelato
            $products_not_ava = "";
            foreach($products_not_available as $not){
              $products_not_ava = $products_not_ava.implode(" ", $not).", ";
            }
            echo('
            <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:red">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>
            <small>Nicht auf Lager: '.$products_not_ava.'</small>
            <!--<small>Es liegen keine Informationen zur Verfügbarkeit vor</small>-->
            </button>');
          }
          ?>
       
      </div>
      <br>
      <div class="row" style="margin:0px">
        <button type="button" class="btn btn-outline-secondary btn-no-hover">
          <small style="opacity: 0.5;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="10">
              <!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
              <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"></path>
            </svg> 
            Sichere Online-Zahlung mit 
            <svg viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-paypal">
              <title id="pi-paypal">PayPal</title>
              <path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"></path>
              <path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"></path>
              <path fill="#003087" d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z"></path>
              <path fill="#3086C8" d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z"></path>
              <path fill="#012169" d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z"></path>
            </svg>
          </small>
        </button>
      </div>
      <br>
      <br>
      <p><?php echo($product['description']);?></p>
    </div>
  </div>
</div>

<!-- image slideshow -->
<script>
  let slideIndex = 1;
  showSlides(slideIndex);
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("slideshow-img");
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
  }
</script>

