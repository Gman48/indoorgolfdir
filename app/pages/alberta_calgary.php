<?php require page('includes/header');?>

<!-- Hero Section -->
<div id="toronto-bg">
    <div class="container">
        <div class="hero">
            <h1 class="headline-region">Indoor Golf Facilities</h1>
            <h1 class="headline-region region-name">Calgary and Vicinity</h1>
            <p class="listings-title">The following is a listing of indoor golf facilities that can be found in and around Calgary.  Each listing has a brief description of the facility, it's amenities and a link to the facilities website. Click on the facility name for more detailed information about the facility, including reviews.</p>
        </div>
    </div>
</div>

<!-- Listings Section -->
<section class="container">
    <div class="listings-grid">
        <div class="listings-grid-col1">
        
            <?php 
                $query = "select * from allfacilities where region = 'calgary' order by featured desc, rand()";
                $rows = db_query($query);
            ?>

            <?php if(!empty($rows)):?>
            <?php foreach($rows as $row):?>

            <div class="listings-container">
                <img class="listings-img" src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility image">
                <div class="listings-summary">
                    <div class="name-featured">
                        <a class="facilitylink facility-name" href="<?=ROOT?>/facility_details?facility_id=<?=$row['facility_id']?>"><?=esc($row['facility_name'])?></a>
                        <div class="featured-label"><?php if($row['featured']) echo 'Featured Listing' ?></div>
                    </div>
                    <div class="facility-address"><?=esc($row['facility_street'])?>, <?=esc($row['facility_city'])?></div>
                    <a class="weblink" href="<?=$row['website_link']?>"><?=esc($row['website_short'])?></a>
                    <div class="facility-amenities"> 
                        <?php if($row['lessons']) {echo('lessons, ');}?>
                        <?php if($row['bar']) {echo('licensed lounge, ');}?>
                        <?php if($row['food']) {echo('snack bar, ');}?>
                        <?php if($row['leagues']) {echo('leagues, ');}?>
                        <?php if($row['24hrs']) {echo('open 24 hours ');}?>
                        <!-- Lessons, snack bar, 3 simulators--></div> 
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