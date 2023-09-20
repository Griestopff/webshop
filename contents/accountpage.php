<nav>
    <a href=<?php echo($baseurl."index.php/account")?>>Profil</a>
    <a href=<?php echo($baseurl."index.php/account/addresses")?>>Anschriften</a>
    <a href=<?php echo($baseurl."index.php/account/orders")?>>Bestellungen</a>
    <a href=<?php echo($baseurl."index.php/account/wishlist")?>>Wunschliste</a>
    <a class="right" href=<?php echo($baseurl."index.php/logout")?>>Logout</a>           
</nav>

<?php
    if(userIsLoggedIn($userId)){
        // Include the specific content
        // Check if the route contains '/product/orders'
        if(strpos($route, '/account/orders') !== false){
            include(__DIR__."/account_contents/account_orders.php");
        // Check if the route contains '/cart'
        }elseif(strpos($route, '/account/addresses') !== false){
            include(__DIR__."/account_contents/account_addresses.php");
        // Check if the route contains '/cart'
        }elseif(strpos($route, '/account/wishlist') !== false){
            include(__DIR__."/account_contents/account_wishlist.php");
        // Check if the route contains '/cart'
        }else{
            include(__DIR__."/account_contents/account_user.php");
        }
    }else{
        echo("<div class='alert alert-warning text-center' role='alert'>
        Du bist nicht eingeloggt!
        </div>");
        $redirect = $baseurl.'index.php/login';
        header("Location: $redirect");
        exit();
    }
?>