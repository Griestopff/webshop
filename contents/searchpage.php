<!--#TODO auslagern in style.css-->
<style>

</style>

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



         


<div class="container">
    <div class="row">
      <div class="col-md-3" style="margin-top:20px">
      <form action="search" method="get">
        <div class="row">
          <button type="button" class="btn btn-warning" data-bs-toggle="collapse" data-bs-target="#collapseDivFilter">
            Filter 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6z"/>
            </svg>
          </button>
        </div>
        <div class="collapse" id="collapseDivFilter">
          <div class="mb-3" style="margin-top:20px">
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
          <div class="row" style="margin:0px">
          <button type="submit" class="btn btn-warning" value="Filter anwenden">Filter anwenden</button>
            </div>
        </div>
        </form>
      </div>
      <div class="col-md-9" style="margin-top:20px">
        <!--<h3>Produkte</h3>-->
        <div class="row">

          <?php 
          // Loop through each product and include the card template
          foreach ($products as $product) {
            include('./templates/card_search.php');
          }
          if(count($products) < 1){
            echo("<div class='alert alert-warning text-center' role='alert'>
            Leider ergab dein Filter keine Ergebnisse.
                              </div>");
          }
          ?>
        
        </div>
      </div>
    </div>
  </div>
  

