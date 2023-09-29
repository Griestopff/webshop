<!--Frontpage card, where products are shown
build the columns of the row made in "frontpage.php"
php variables come from frontpage.php while loop-->

<div class="col-md-4 mb-4">
        <div class="card">
                <a href=<?php echo($baseurl."index.php/product/".$product['product_id'])?> style="text-decoration: none;">
                        <img src="<?php echo('/img/'.$product['product_id'].'_1.png'); ?>" class="card-img-top" alt=<?php echo($product['product_name']);?>>
                </a>
                <div class="row">
                        <div class="align-items-center col-md-6 mb-6" style="margin:10px">
                                <h5>
                                        <?php echo($product['product_name']);?>
                                </h5>
                                <p>
                                        <?php echo($product['price']."€");?>
                                </p>
                        </div>
                        <div class=" justify-content-center col-md-4 mb-4 right" style=" margin-left:10px">
                        <?php  
                                include("./elements/cartButton.php");  
                                echo("<span style='margin:10px'></span>");
                                include("./elements/wishlistButton.php");
                        ?>
                        
                        </div>
                </div>
        </div>
</div>
