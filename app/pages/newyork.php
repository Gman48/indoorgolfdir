<?php require page('includes/header');?>

<!-- Hero Section -->
<div id="hero-bg" class="hero-bg-state">
    <h1 class="headline-state">Indoor Golf Directory</h1>
    <h1 class="headline">New York State</h1>
    <h3 class="sub-text">What region of New York State are you looking in?</h3>

    <div class="region-btns">
        <a href="<?=ROOT?>/dynamic_region?region_id=36" class="region-btn">New York City</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=51" class="region-btn">Long Island</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=51" class="region-btn">Hudson Valley</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=37" class="region-btn">Capital District</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=49" class="region-btn">Mohawk Valley</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=47" class="region-btn">Central New York</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=38" class="region-btn">Southern Tier</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=46" class="region-btn">Finger Lakes</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=45" class="region-btn">Western New York</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=48" class="region-btn">North Country</a>
    </div>
</div>

<div class="container">
    <p class="state-summary">With over 100 indoor golf facilities in New York State you are sure to find one that meets your needs.  Search by clicking on a region above or check out our featured New York State facilities below.</p>
</div>

<!-- Listings Section -->
<section class="container">
    <div class="listings-grid">
        <div class="listings-grid-col1">
        
            <?php 
                $query = "select * from allfacilities where state = :state and featured = 1";
                $rows = db_query($query, ['state'=>'ny']);
            ?>

            <?php if(!empty($rows)):?>
            <?php foreach($rows as $row):?>

            <div class="listings-container">
                <img class="listings-img" src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility image">
                <div class="listings-summary">
                    <div class="name-featured">
                        <div><a class="facilitylink facility-name" href="<?=ROOT?>/facility_details?facility_id=<?=$row['facility_id']?>"><?=esc($row['facility_name'])?></a></div>
                    </div>
                    <div class="facility-address">
                        <?=esc($row['facility_street'])?>, <?=esc($row['facility_city'])?>
                    </div>
                    <!-- <a class="weblink" href="<?=$row['website_link']?>"><?=esc($row['website_short'])?></a> -->
                    <div class="facility-amenities"> 
                        <?php if($row['lessons']) {echo('lessons, ');}?>
                        <?php if($row['bar']) {echo('licensed lounge, ');}?>
                        <?php if($row['food']) {echo('snack bar, ');}?>
                        <?php if($row['leagues']) {echo('leagues, ');}?>
                        <?php if($row['24hrs']) {echo('open 24 hours ');}?>
                    </div> 
                </div>
                <div class="featured-label">
                    <?php if($row['featured']) echo 'Featured Listing' ?>
                </div>
            </div>
            <hr class="list-break">
            <?php endforeach;?>
            <?php endif;?>
        </div>

        <div class="listings-grid-col2">
            <div class="right-sidebar">
                <div class="ad-grid-item">Add space</div>
                <div class="ad-grid-item">Second Add space</div>
                <div class="ad-grid-item">Third Add space</div>
            </div>
        </div>
    </div>
</section>

<?php require page('includes/footer');?>