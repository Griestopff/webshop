<?php

//shows alerts on pages with wishlist button, if product was added or removed from wishlist
function checkWishlistCookie(){
    if(isset($_COOKIE['addedToWishlist']) && $_COOKIE['addedToWishlist'] == 1) {
        # show alert
        echo("<div class='alert alert-success text-center' role='alert'>
        Das Produkt wurde zu deiner Wunschliste hinzugefügt :)
        </div>");
        // delete the cookie
        unset($_COOKIE['addedToWishlist']);
        setcookie('addedToWishlist', "", time() - 3600, '/');
      }
      if(isset($_COOKIE['alreadyInWishlist']) && $_COOKIE['alreadyInWishlist'] == 1) {
        # show alert
        echo("<div class='alert alert-warning text-center' role='alert'>
        Das Produkt ist bereits in deiner Wunschliste :)
        </div>");      
        // delete the cookie
        unset($_COOKIE['alreadyInWishlist']);
        setcookie('alreadyInWishlist', "", time() - 3600, '/');
      }
      if(isset($_COOKIE['removedFromWishlist']) && $_COOKIE['removedFromWishlist'] == 1) {
        # show alert
        echo("<div class='alert alert-warning text-center' role='alert'>
        Das Produkt wurde von deiner Wunschliste entfernt :(
        </div>");      
        // delete the cookie
        unset($_COOKIE['removedFromWishlist']);
        setcookie('removedFromWishlist', "", time() - 3600, '/');
      }
      if(isset($_COOKIE['couldntRemoveFromWishlist']) && $_COOKIE['couldntRemoveFromWishlist'] == 1) {
        # show alert
        echo("<div class='alert alert-danger text-center' role='alert'>
        Das Produkt konnte ncht von deiner Wunschliste entfernt werden :)
        </div>");      
        // delete the cookie
        unset($_COOKIE['couldntRemoveFromWishlist']);
        setcookie('couldntRemoveFromWishlist', "", time() - 3600, '/');
      }
}