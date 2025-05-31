<!-- Testimonials in carousel using Swiper-->
<section id="tales_carousel" class="carousel_container">
  <div class="card__container swiper">
    <div class="card__content">
      <div class="swiper-wrapper">

<?php 
	$query = "select * from tales";
	$rows = db_query($query);
?>

<?php if(!empty($rows)):?>
	<?php foreach($rows as $row):?>

        <article class="card__article swiper-slide">
          <div class="card__image">
            <img src="<?=ROOT?>/<?=$row['image']?>" alt="image" class="card__img">
            <div class="card__shadow"></div>
          </div>

          <div class="card__data">
            <h3 class="card__name"><?=$row['name']?></h3>
            <p class="card__description">
              <?=$row['tale']?> 
            </p>
          </div>
        </article>
    <?php endforeach;?>
<?php endif;?>

      </div>
    </div>

    <!-- Navigation buttons -->
    <div class="swiper-button-prev">
      <i class="ri-arrow-left-s-line"></i>
    </div>

    <div class="swiper-button-next">
      <i class="ri-arrow-right-s-line"></i>
    </div> 

    <!-- Pagination -->
    <div class="swiper-pagination"></div> 

  </div>
</section>

