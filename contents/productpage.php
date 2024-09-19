<?php
    $parts = explode("/", $route);
    //$parts[0]='', $parts[1]='product', $parts[2]=product_id
    
    $product = getProductById($parts[2]);

    checkWishlistCookie();

    $directory = '../htdocs/img';
    $prefix = $product['product_id'].'_';
    $matchingFiles = getImagesByProductId($directory, $prefix);
    // $matchingFiles enthält jetzt ein Array mit den Dateien, die den gewünschten Präfix haben

?>
<br>


<!-- TODO css auslagern!!!-->
<style>
        /* Standardmäßig zeigen wir den Inhalt für deaktiviertes JavaScript an */
        .js-enabled {
            display: none;
        }

        .animated-button {
          cursor: pointer;
          transition: transform 0.1s ease-in-out, background-color 0.1s ease-in-out;
        }

        .animated-button:active {
          transform: scale(0.9);
        }

        .animated-button:focus {
  outline: none; /* Entfernt den Fokus-Effekt */
}

#cartSuccess {
  transition: background-color 0.5s ease, transform 0.5s ease;
}

#cartSuccess.reload-feedback {
  transform: scale(1.08); /* Kleiner Vergrößerungseffekt */
}
    </style>



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

        
        <!-- Dieser Inhalt wird angezeigt, wenn JS deaktiviert ist -->
        <div class="row js-disabled" style="margin:0px">
          <button type="submit" class="btn btn-warning">Zum Warenkorb hinzufügen</button>
        </div>
        <!-- Dieser Inhalt wird angezeigt, wenn JS aktiviert ist -->
        <div class="row js-enabled animated-button" style="margin:0px">
          <button type="submit" id="jsActiveButton" class="btn btn-warning">Zum Warenkorb hinzufügen</button>
        </div>
        
        

      </form>
      <br>
      <!-- Wird erst angezeigt wenn produkt zum cart hinzugefügt -->
      <div id="cartSuccess" class="row" style="margin:0px">
      </div>
      <div id="availability" class="row" style="margin:0px">
        <button type="button" class="btn btn-outline-secondary btn-no-hover">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
          </svg>
          <small>Lade Information zur Verfügbarkeit</small>
        </button>
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
<br>



    <noscript>
        <!-- Diese Sektion wird nur angezeigt, wenn JavaScript deaktiviert ist -->
        <style>
            .js-disabled {
                display: block;
            }
            .js-enabled {
                display: none;
            }
        </style>
    </noscript>
   

    <script>
        // Wenn JavaScript aktiv ist, verbergen wir den Inhalt für deaktiviertes JS und zeigen die Alternative an
        document.querySelector('.js-disabled').style.display = 'none';
        document.querySelector('.js-enabled').style.display = 'block';
    </script>


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

  // Check stock availability for product with AJAX
  // get <select>-elements
  var colorDropdown = document.querySelector('select[name="color"]');
  var sizeDropdown = document.querySelector('select[name="size"]');

  // function to send ajax-request and include content
  function sendAjaxAvaRequest() {
    // XMLHttpRequest-object
    var xhttp = new XMLHttpRequest();

    // get select field values
    var selectedColor = colorDropdown.value;
    var selectedSize = sizeDropdown.value;

    // create URL for ajax request
    var url = "<?php echo($baseurl."index.php/ajax?color=");?>" + encodeURIComponent(selectedColor) + "&size=" + encodeURIComponent(selectedSize) + "&id=" +  encodeURIComponent(<?php echo($parts[2])?>);
    //var url = "http://shop/index.php/ajax?color=" + encodeURIComponent(selectedColor) + "&size=" + encodeURIComponent(selectedSize) + "&id=" +  encodeURIComponent(<?php echo($parts[2])?>);
    xhttp.open("GET", url, true);

    // function for successful request
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          // get specific part of response DOM
          var parser = new DOMParser();
          var doc = parser.parseFromString(this.responseText, "text/html");
          var spezifischerTeil = doc.getElementById('ava');

          // show response
          document.getElementById("availability").innerHTML = spezifischerTeil.innerHTML;
        }
    };

    // send request
    xhttp.send();
  }

// function to send ajax-request and include content
function sendAjaxCartRequest() {
    // XMLHttpRequest-object
    var xhttp = new XMLHttpRequest();

    // get select field values
    var selectedColor = colorDropdown.value;
    var selectedSize = sizeDropdown.value;

    // create URL for ajax request
    var url = "<?php echo($baseurl."index.php/ajax?cart=add");?>" + "&id=" +  encodeURIComponent(<?php echo($parts[2])?>)   + "&color=" + encodeURIComponent(selectedColor) + "&size=" + encodeURIComponent(selectedSize);
    xhttp.open("GET", url, true);

    // function for successful request
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          // get specific part of response DOM
          var parser = new DOMParser();
          var doc = parser.parseFromString(this.responseText, "text/html");
          var spezifischerTeil = doc.getElementById('ajaxCart');
          var cartAlert = doc.getElementById('cartSuccess');

          // show response
          document.getElementById("cart").innerHTML = spezifischerTeil.innerHTML;
          document.getElementById("cartSuccess").innerHTML = cartAlert.innerHTML;

        }
    };
   
    // send request
    xhttp.send();
  }


  // live select field values with EventListener
  colorDropdown.addEventListener('change', sendAjaxAvaRequest);
  sizeDropdown.addEventListener('change', sendAjaxAvaRequest);
  // load conten first, then first request
  document.addEventListener('DOMContentLoaded', function() {
    sendAjaxAvaRequest();
  });

  document.getElementById("jsActiveButton").addEventListener("click", function(event) {
        // Verhindert, dass das Formular abgesendet wird
        event.preventDefault();
        //HIER AJAX AUFRUF
        sendAjaxCartRequest();

         // Füge die Feedback-Animation hinzu
    const contentDiv = document.getElementById('cartSuccess');
    contentDiv.classList.add('reload-feedback');
    
    // Entferne die Animation nach einer kurzen Zeit, damit sie wiederholt werden kann
    setTimeout(function() {
      contentDiv.classList.remove('reload-feedback');
    }, 500); // Die Dauer muss zur CSS-Animation passen

    });

  



</script>

