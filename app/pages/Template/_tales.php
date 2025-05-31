
<!-- owl carousel -->
        <div class="owl-carousel owl-theme">
        <?php 
			$query ="select * from tales where active = 1 order by id";
			$tales = db_query($query,['id'=>$row['id']]);
		?>
        <?php if(!empty($tales)):?>
            <?php foreach ($tales as $row) { ?>
            <div class="item py-2">
                <div class="product font-rale">
                    <img src="<?php echo $row['image'] ?? "No image"; ?>" alt="product1" class="img-fluid">
                    <div class="text-center">
                        <h6><?php echo  $row['tale'] ?? "No comment";  ?></h6>
                        <h2><?php echo  $row['name'] ?? "Unknown";  ?></h2>
                    </div>
                </div>
            </div>
            <?php } // closing foreach function ?>
            <?php endif;?>
        </div>
        <!-- !owl carousel -->