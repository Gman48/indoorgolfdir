<?php require page('includes/header');?>

<?php
if(isset($_GET['region_id'])) {
    $id = $_GET['region_id'];
    $query = "select * from regions where region_id = :region_id limit 1";
    $row = db_query_one($query,['region_id'=>$id]);
    $region = $row['region'];
}
?>

<!-- Hero Section -->
<div id="region-hero">
    <img src="<?=ROOT?>/<?=$row['region_img']?>" alt="Region Image">
</div>

<div class="page-container">
    <div class="container region-container">
        <h1 class="headline-region">Indoor Golf Facilities</h1>
        <h1 class="headline-region region-name"><?=esc($row['region_name'])?></h1>
    </div>
    <div class="container region-container-description">
        <p class="listings-title">The following is a listing of indoor golf facilities that can be found <?=esc($row['region_desc'])?>.  Click on the facility name for more detailed information about the facility, including a map and a link to the facilitie's website.</p>
    </div>

<!-- Listings Section -->
<section class="container">
    <div class="listings-grid">
        <div > <!-- first column -->
        
            <?php 
                $query = "select * from allfacilities where region = :region, active = 1 order by featured desc, rand()";
                $rows = db_query($query, ['region'=>$region]);
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
            <!-- <div class="right-sidebar">
                <div class="ad-grid-item">
                    <img class="listings-img" src="/assets/images/Albatross2.jpg" alt="add space">
                </div>
                <div class="ad-grid-item">Second Add space</div>
                <div class="ad-grid-item">Third Add space</div>
            </div> -->
        </div>
    </div>
</section>
</div>

<?php require page('includes/update');?>

<?php require page('includes/footer');?>