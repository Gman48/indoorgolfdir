<!-- This file is for including the product card on a page -->

<!--start product card-->
<div class="product-card">
	<div style="overflow: hidden;">
		<a href="<?=ROOT?>/product/<?=$row['slug']?>"><img src="<?=ROOT?>/<?=$row['image']?>"></a>
	</div>
	<div class="card-content">
		<div class="product-card-title"><?=esc($row['name'])?></div>
		<div class="product-card-subtitle"><?=esc($row['description'])?></div>
	</div>
	<div class="price-quantity">
		<a href="#cta" class="order-btn fav-btn">order yours today</a>
	</div> 
</div>
<!--end product card-->