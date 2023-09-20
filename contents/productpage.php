<!--#TODO auslagern in styles.css war nicht möglich--> 
<style>
  /*Slideshow for productsimages */
.slideshow-container{
  position: relative;
  max-width: 500px;
  margin: auto;
}

.slideshow-img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto; /* Zentriert das Bild horizontal */
}

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
    
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}

.prev:hover, .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

</style>

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

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="slideshow-container">
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <?php
        foreach($matchingFiles as $file){
          echo('<img src="'.$file.'" alt="Product Image" class="img-fluid slideshow-img">');
        }
        ?>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>
    </div>
    <div class="col-md-6">
      <h2><?php  echo($product['product_name']);?></h2>
      <p class="lead">Price: <?php  echo($product['price']);?>€</p>
      <form action=<?php echo($baseurl."index.php/cart/add/".$product['product_id']."/")?>>
      
        <div class="form-group">

          <label for="sizeSelect">Size:</label>
          <?php echo(fillFormWithJsonOptions("size", $product['sizes']));?>

        </div>
        <div class="form-group">

          <label for="colorSelect">Color:</label>
          <?php echo(fillFormWithJsonOptions("color", $product['colors']));?>
          
        </div>
        <button type="submit" class="btn btn-primary">Add to Cart</button>
      </form>
      <?php 
        include("./elements/wishlistButton.php");
      ?>      
    </div>
    <p><?php echo($product['description']);?></p>
  </div>
</div>

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
    </script>

