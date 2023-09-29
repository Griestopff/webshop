<!--Frontpage card, where products are shown
build the columns of the row made in "frontpage.php"
php variables come from frontpage.php while loop-->

<div class="col-md-4 mb-4">
                <div class="card">
                        <a href=<?php echo($baseurl."index.php/product/".$product['product_id'])?> style="text-decoration: none;">
                                <img src="<?php echo('/img/'.$product['product_id'].'_1.png'); ?>" class="card-img-top" alt=<?php echo($product['product_name']);?>>
                        </a>
                        <div class="row">
                                <div class="align-items-center col" style="margin:10px">
                                        <h5>
                                                <?php   
                                                echo($product['product_name']);
                                                ?>
                                        </h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                                <?php  
                                                        echo($product['price']."€");   
                                                        include("./elements/cartButton.php");
                                                        include("./elements/wishlistButton.php");
                                                ?>
                                        </div>
                                </div>
                        </div>
                        
                        
                </div>


</div>
