<?php
// script to include the rigth content to URL

// Get the number of items in the user's cart
$countCartItems = countProductsInCart($userId);

// Include the header file
include("header.php");

// Include the specific content
// Check if the route contains '/product'
if(strpos($route, '/product') !== false){
    include(__DIR__."/contents/productpage.php");
// Check if the route contains '/cart'
}elseif(strpos($route, '/cart') !== false){
    include(__DIR__."/contents/cartpage.php");
// Check if the route contains '/login'
}elseif(strpos($route, '/login') !== false){
    include(__DIR__."/contents/loginpage.php");
// Check if the route contains '/search'
}elseif(strpos($route, '/search') !== false){
    include(__DIR__."/contents/searchpage.php");
// Check if the route contains '/impressum'
}elseif(strpos($route, '/imprint') !== false){
    include(__DIR__."/contents/imprintpage.php");
// Check if the route contains '/account'
}elseif(strpos($route, '/account') !== false){
    include(__DIR__."/contents/accountpage.php");
// Check if the route contains '/checkout'
}elseif(strpos($route, '/checkout') !== false){
    include(__DIR__."/contents/checkoutpage.php");
// Default case: Include the front page content
}else{
    include(__DIR__."/contents/frontpage.php");
}

// Include the footer file
include("footer.php");