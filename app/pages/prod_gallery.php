<?php require page('includes/header');?>

<div class="gallery-heading">
    <h1>Our Delicious Product Offerings</h1>
</div>

<!-- gallery cards -->
<section id="gallery">

<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">

<?php 
	$query = "select * from products order by view_order asc";
	$rows = db_query($query);
?>

<?php if(!empty($rows)):?>
	<?php foreach($rows as $row):?>

  <div class="col">
    <div class="card h-100">
      <img src="<?=ROOT?>/<?=$row['image']?>" class="card-img-top" alt="image">
      <div class="card-body">
        <h5 class="card-title"><?=$row['name']?></h5>
        <p class="card-text"><?=$row['description']?></p>
      </div>
      <div class="card-footer d-flex">
        <!-- <small class="text-body-secondary">$18/dzn</small> -->
        <a href="<?=ROOT?>#cta" class="text-body-secondary btn order-btn">order today</a>
      </div>
    </div>
  </div>

    <?php endforeach;?>
<?php endif;?>
</div>
</section>


<?php require page('includes/footer');?>