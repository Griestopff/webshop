<!DOCTYPE html>
<html>
  <head>
    <title>SHXRT</title>
    
    <link rel="stylesheet" href=<?php echo($baseurl."styles/bootstrap/css/bootstrap.css")?>>
    <link rel="stylesheet" href=<?php echo($baseurl."styles/style.css")?>>
    <link rel="stylesheet" href=<?php echo($baseurl."styles/header.css")?>>
    <link rel="stylesheet" href=<?php echo($baseurl."styles/footer.css")?>>

    
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?php echo($baseurl."styles/svg/shxrt.svg");?>" type="image/x-icon">

  </head>
  <body>
    

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href=<?php echo($baseurl)?>>
          <img src="/styles/svg/shxrt.svg" width="30" height="30" alt="">
          <b>SHXRT</b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar" style="margin-left:20px">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href=<?php echo($baseurl)?>>Startseite</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=<?php echo($baseurl."index.php/search")?>>Produkte</a>
            </li>
            <?php
              if(!userIsLoggedIn($userId)){
                echo('
                <li class="nav-item">
                  <a href="'.$baseurl.'index.php/login" class="nav-link">Login</a>
                </li>
                <!--<li class="nav-item">
                  <a href="'.$baseurl.'index.php/register" class="nav-link">Registrieren</a>
                </li>-->
                ');
              }else{
                echo('
                <li class="nav-item">  
                  <a href="'.$baseurl.'index.php/account" class="nav-link">Konto</a>
                </li>
                ');
              }
            ?>
            <li class="nav-item">
              <a class="nav-link" href=<?php echo($baseurl."index.php/imprint")?>>Über uns</a>
            </li>
          </ul>
        </div>
        <li class="nav-item" style="margin-right:20px">
          <button type="button" class="btn btn-outline-secondary" style="margin-rigth:10px">
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
                  setcookie('cartAdd', "", time() - 3600, '/');
                  include('./elements/checkmark_header.html');
                }
              ?>
            </a>
          </button>
        </li>
      </nav>



    <!--  hallo 
  hallo-->