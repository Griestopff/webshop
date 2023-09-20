<!DOCTYPE html>
<html>
  <head>
    <title>Mein Shop</title>
    
    <link rel="stylesheet" href=<?php echo($baseurl."styles/bootstrap/css/bootstrap.css")?>>
    <link rel="stylesheet" href=<?php echo($baseurl."styles/style.css")?>>
    <link rel="stylesheet" href=<?php echo($baseurl."styles/header.css")?>>
    <link rel="stylesheet" href=<?php echo($baseurl."styles/footer.css")?>>

    <!-- #TODO local download -->
    <!-- jQuery 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     Bootstrap JS 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->
  </head>
  <body>
    <?php
      #TODO
      #if(userIsLoggedIn($userId)){
      #  echo("<p>Hallo ".getUserNameByID($userId)."!</p>");
      #}else{
      # 
      #}
    ?>

      <nav>
            <a href=<?php echo($baseurl)?>>Startseite</a>
            <a href=<?php echo($baseurl."index.php/search")?>>Produkte</a>
            <a href=<?php echo($baseurl."index.php/imprint")?>>Über uns</a>
            <?php
              if(!userIsLoggedIn($userId)){
                
            echo('<a href="'.$baseurl.'index.php/login" class="right">Login</a>
                  <a href="'.$baseurl.'index.php/register" class="right">Registrieren</a>');
              }else{
                echo('<a href="'.$baseurl.'index.php/account" class="right">Konto</a>');
              }
              ?>
            <a href=<?php echo($baseurl."index.php/cart")?> class="right">Warenkorb(<?php 

                echo($countCartItems).")"; 
                
                if(isset($_COOKIE['cartAdd']) && $_COOKIE['cartAdd'] == 1) {
                  # anderen checkmark erstellen, der kleiner ist und dann verschwindet
                  include('./elements/checkmark_header.html');
                  // Cookie löschen
                  unset($_COOKIE['cartAdd']);
                  setcookie('cartAdd', "", time() - 3600, '/');
                }
              ?></a>
      </nav>
