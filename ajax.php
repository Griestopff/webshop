<?php
if(isset($_GET['cart']) && isset($_GET['id']) && isset($_GET['color']) && isset($_GET['size'])) {
  if($_GET['cart'] == "add"){
    if((isset($_GET['color'])) && (isset($_GET['size']))){
      addProductToCart($userId,$_GET['id'], $_GET['color'], $_GET['size'], 1);
    }else{
      addProductToCart($userId,$_GET['id'], NULL, NULL, 1);
  }
  }
  
  $countCartItems = countProductsInCart($userId);
  ?>
  <button type="button" id="ajaxCart" class="btn btn-outline-secondary" style="margin-rigth:10px">
  <a href=<?php echo($baseurl."index.php/cart")?> class="nav-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
      <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    <?php 
      echo("(<b>".$countCartItems."</b>)"); 
      if(isset($_COOKIE['cartAdd']) && $_COOKIE['cartAdd'] == 1) {
        # anderen checkmark erstellen, der kleiner ist und dann verschwindet
        // Cookie löschen
        unset($_COOKIE['cartAdd']);
        if (hasCookieConsent()) {
          setcookie('cartAdd', "", time() - 3600, '/');
        }
        include('./elements/checkmark_header.html');
      }
    ?>
  </a>
</button>
<div id="cartSuccess" >
  <div class='alert alert-success text-center'>
    <b>Produkt erfolgreich zum Warenkorb hinzugefügt!</b><br>
  </div>
</div><?php
}


// check if get variables set
if(isset($_GET['color']) && isset($_GET['size']) && isset($_GET['id'])) {
    //get values
    $color = $_GET['color'];
    $id = $_GET['id'];
    $size = $_GET['size'];
    $availability = checkGelatoAvailability($id, $color,  $size);
    if($availability == "stock"){
      echo('
      <div id="ava" class="row" style="margin:0px">
      <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:green">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </svg>
      <small>Verfügbar in '.$size.'/'.$color.', versandfertig in 1-3 Werktagen</small>
      </button>
      </div>
      ');
    }elseif($availability == "nonstock"){
      echo('
      <div id="ava" class="row" style="margin:0px">
      <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:red">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>
            <small>Nicht auf Lager in '.$size.'/'.$color.'</small>
            </button>
      </div>
      ');
    }else{
      echo('
      <div id="ava" class="row" style="margin:0px">
      <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:red">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>
            <small>Keine Information zur Verfügbarkeit in '.$size.'/'.$color.'</small>
            </button>
      </div>
      ');
    }
    
}else{
  echo('
      <div id="ava" class="row" style="margin:0px">
      <button type="button" class="btn btn-outline-secondary btn-no-hover" style ="color:red">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
            </svg>
            <small>Information zur Verfügbarkeit nicht Abrufbar</small>
            </button>
      </div>
      ');
}


            



?>
