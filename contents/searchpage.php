<?php
checkWishlistCookie();

//Check if there are GET values
if(isset( $_GET["category"] ) && isset($_GET["maxPrice"])){
  $category = $_GET["category"];
  $maxprice = $_GET["maxPrice"];

  $products = getProductsBySelection($maxprice, $category);
} else {
  $products = getAllProducts();
}

?>
<div class="container mt-5">
    <div class="row">
      <div class="col-md-3">
      <form action="search" method="get">
        <h3>Filter</h3>

        <div class="mb-3">
          <label id="categoryValue" for="categoryFilter" class="form-label">Kategorie:</label>
          <select name="category" id="categoryFilter" class="form-select">
            <!--#TODO maybe auto fill of categories-->
            <option value="all">Alle</option>
            <option value="t">T-Shirt</option>
            <option value="h">Hoodie</option>
            <option value="p">Poster</option>
          </select>
        </div>
        <script>
          //JavaScript-Code, for live display of category
          const selectFeld = document.getElementById('categoryFilter');
          //write the selected category from get value
          const urlParams = new URLSearchParams(window.location.search);
          const getValueCategory = urlParams.get('category');
          //default value, if get isnt set
          if (getValueCategory !== null) {
              selectFeld.value = getValueCategory;
          }
          selectFeld.addEventListener('change', function() {
              console.log('Auswahl geändert: ' + this.value);
          });
        </script>

        <div class="mb-3">
          <div class="form-group">
          <label for="maxPrice" class="form-label">Preisspanne:</label>
              <input type="range" class="form-range" id="maxPrice" name="maxPrice" min="0" max="100" step="5" value="100">
          </div>
          <div class="form-group">
              <label for="priceDisplay">Max. Preis: <span id="priceValue"></span> €</label>
          </div>
        </div>
        <script>
            //JavaScript-Code, for live display of price
            const maxPrice = document.getElementById('maxPrice');
            const priceDisplay = document.getElementById('priceValue');
            //write the selected price from get value
            const urlParamsPrice = new URLSearchParams(window.location.search);
            const getValue = urlParamsPrice.get('maxPrice');
            //default value, if get isnt set
            maxPrice.value = getValue || 100;
            //update display 
            priceDisplay.textContent = maxPrice.value;
            maxPrice.addEventListener('input', function() {
              priceDisplay.textContent = this.value;
            });
        </script>
         
        <input type="submit" class="btn btn-primary" value="Filter anwenden">
      
      </div>
      </form>
      <div class="col-md-9">
        <h3>Produkte</h3>
        <div class="row">

          <?php 
          // Loop through each product and include the card template
          foreach ($products as $product) {
            include('./templates/card_search.php');
          }
          ?>
        
        </div>
      </div>
    </div>
  </div>


