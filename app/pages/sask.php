<?php require page('includes/header');?>

<!-- Hero Section -->
<div id="hero-bg" class="hero-bg-state">
    <h1 class="headline-state">Indoor Golf Directory</h1>
    <h1 class="headline">Saskatchewan</h1>

<!-- Temporary text while state directory is being compiled -->
<h3 class="sub-text">We are currently compiling the directory for Saskatchewan. </h3>
<h3 class="sub-text">Please check back soon as the listing of indoor golf facilities and simulators in Saskatchewan is nearly complete.</h3>

<div class="region-btns">
        <a href="<?=ROOT?>/" class="region-btn">Back to Home Page</a>
        <a href="<?=ROOT?>/canada" class="prov-btn">Back to Canada Page</a>
</div>

    <!-- <h3 class="sub-text">What region of Saskatchewan are you looking in?</h3>

    <div class="region-btns">
        <a href="<?=ROOT?>/dynamic_region?region_id=27" class="region-btn">Greater Montreal</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=28" class="region-btn">Quebec City Region</a>
        <a href="<?=ROOT?>/dynamic_region?region_id=29" class="region-btn">Northern Quebec</a>
    </div> -->
</div>

<!-- <div class="container">
    <p class="state-summary">With over 75 indoor golf facilities in Saskatchewan you are sure to find one that meets your needs.  Search by clicking on a region above or check out our featured facilities below.</p>
</div> -->

<!-- Listings Section -->
<!-- <section class="container">
    <div class="listings-grid">
        <div class="listings-grid-col1">
        
            <?php 
                $query = "select * from allfacilities where state = :state and featured = 1";
                $rows = db_query($query, ['state'=>'qc']);
            ?>

            <?php if(!empty($rows)):?>
            <?php foreach($rows as $row):?>

            <div class="listings-container">
                <img class="listings-img" src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility image">
                <div class="listings-summary">
                    <div class="name-featured">
                        <a class="facilitylink facility-name" href="<?=ROOT?>/facility_details?facility_id=<?=$row['facility_id']?>"><?=esc($row['facility_name'])?></a>
                    </div>
                    <div class="facility-address">
                        <?=esc($row['facility_street'])?>, <?=esc($row['facility_city'])?>
                    </div>
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
</section> -->

<!-- <?php require page('includes/update');?> -->
<?php require page('includes/footer');?>