<?php require page('includes/header');?>

<!-- Hero Section -->
<div id="hero-bg" class="hero-bg-state">
    <h1 class="headline-state">Indoor Golf Directory</h1>
    <h1 class="headline">Connecticut</h1>
    <h3 class="sub-text">What region of Connecticut are you looking in?</h3>
    
    <div class="region-btns">
        <a href="<?=ROOT?>/dynamic_region?region_id=58" class="region-btn">Hartford</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=56" class="region-btn">New Haven</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=59" class="region-btn">Rural Connecticut</a>
    </div>
</div>

<div class="container">
    <p class="state-summary">With over 70 indoor golf facilities in Connecticut you are sure to find one that meets your needs.  Search by clicking on a region above or check out our featured Connecticut facilities below.</p>
</div>

<!-- Listings Section -->
<section class="container">
    <div class="listings-grid">
        <div class="listings-grid-col1">
        
            <?php 
                $query = "select * from allfacilities where state = :state and featured = 1";
                $rows = db_query($query, ['state'=>'ct']);
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