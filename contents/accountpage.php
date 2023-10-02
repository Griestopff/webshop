<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbarAccount" style="margin:10px">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbarAccount" style="margin-left:20px">
    <ul class="navbar-nav">
            <li class="nav-item">
    <a href=<?php echo($baseurl."index.php/account")?>>Profil</a>
</li><li class="nav-item">
    <a href=<?php echo($baseurl."index.php/account/addresses")?>>Anschriften</a>
    </li><li class="nav-item">
    <a href=<?php echo($baseurl."index.php/account/orders")?>>Bestellungen</a>
    </li><li class="nav-item">
    <a href=<?php echo($baseurl."index.php/account/wishlist")?>>Wunschliste</a>
    </li><li class="nav-item">
    <a class="right" href=<?php echo($baseurl."index.php/logout")?>>Logout</a> 
</li>
</ul> 
    </div>         
</nav>

<?php
        // Include the specific content
        // Check if the route contains '/product/orders'
        if(strpos($route, '/account/orders') !== false){
            ?>  <div class="container">
            <?php
            include(__DIR__."/account_contents/account_orders.php");
            ?> 
                </div>
            <?php
        // Check if the route contains '/cart'
        }elseif(strpos($route, '/account/addresses') !== false){
            ?>  <div class="container">
                    <br>
                    <div class="row">
            <?php
                        include(__DIR__."/account_contents/account_addresses.php");
            ?>      </div>
                    <br>
                </div>
            <?php
        // Check if the route contains '/cart'
        }elseif(strpos($route, '/account/wishlist') !== false){
            include(__DIR__."/account_contents/account_wishlist.php");
        // Check if the route contains '/cart'
        }elseif(strpos($route, '/account/deleteUser') !== false){
            include(__DIR__."/account_contents/account_delete.php");
        // Check if the route contains '/cart'
        }else{
            ?>  <div class="container">
                <br>
            <?php
            include(__DIR__."/account_contents/account_user.php");
            ?> 
                </div>
            <?php
        }
?>