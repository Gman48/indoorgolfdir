<?php require page('includes/header');?>

<?php
if(isset($_GET['facility_id'])) {
    $facility_id=$_GET['facility_id'];
    $query = "select * from allfacilities where facility_id = $facility_id";
    $row = db_query_one($query);
}
?>

<!-- Page layout for Facilities Details -->
<section class="facility-details-container container">
    <div class="gallery">
        <div class="main-img">
            <img class="active" src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility-image">
            <img src="<?=ROOT?>/<?=$row['facility_img2']?>" alt="facility-image">
            <img src="<?=ROOT?>/<?=$row['facility_img3']?>" alt="facility-image">
            <img src="<?=ROOT?>/<?=$row['facility_img4']?>" alt="facility-image">
        </div>
        <div class="thumb-list">
            <div class="active">
                <img src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility-thumbnail-image">
            </div>
            <div>
                <img src="<?=ROOT?>/<?=$row['facility_img2']?>" alt="facility-thumbnail-image">
            </div>
            <div>
                <img src="<?=ROOT?>/<?=$row['facility_img3']?>" alt="facility-thumbnail-image">
            </div>
            <div>
                <img src="<?=ROOT?>/<?=$row['facility_img4']?>" alt="facility-thumbnail-image">
            </div>
        </div>
    </div>

    <div class="lightbox">
        <div class="gallery">
            <div class="main-img">
                <span class="icon-close">
                    <svg height="30" viewBox="0 0 48 48" width="30" xmlns="http://www.w3.org/2000/svg"><path d="M38 12.83l-2.83-2.83-11.17 11.17-11.17-11.17-2.83 2.83 11.17 11.17-11.17 11.17 2.83 2.83 11.17-11.17 11.17 11.17 2.83-2.83-11.17-11.17z"/></svg>
                </span>
                <span class="icon-prev">
                    <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><title/><path d="M39.3756,48.0022l30.47-25.39a6.0035,6.0035,0,0,0-7.6878-9.223L26.1563,43.3906a6.0092,6.0092,0,0,0,0,9.2231L62.1578,82.615a6.0035,6.0035,0,0,0,7.6878-9.2231Z"/></svg>
                </span>
                <span class="icon-next">
                    <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><title/><path d="M69.8437,43.3876,33.8422,13.3863a6.0035,6.0035,0,0,0-7.6878,9.223l30.47,25.39-30.47,25.39a6.0035,6.0035,0,0,0,7.6878,9.2231L69.8437,52.6106a6.0091,6.0091,0,0,0,0-9.223Z"/></svg>
                </span>

                <img class="active" src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility-image">
                <img src="<?=ROOT?>/<?=$row['facility_img2']?>" alt="facility-image">
                <img src="<?=ROOT?>/<?=$row['facility_img3']?>" alt="facility-image">
                <img src="<?=ROOT?>/<?=$row['facility_img4']?>" alt="facility-image">
            </div>
            
            <div class="thumb-list">
                <div>
                    <img class="active" src="<?=ROOT?>/<?=$row['facility_img']?>" alt="facility-thumbnail-image">
                </div>
                <div>
                    <img src="<?=ROOT?>/<?=$row['facility_img2']?>" alt="facility-thumbnail-image">
                </div>
                <div>
                    <img src="<?=ROOT?>/<?=$row['facility_img3']?>" alt="facility-thumbnail-image">
                </div>
                <div>
                    <img src="<?=ROOT?>/<?=$row['facility_img4']?>" alt="facility-thumbnail-image">
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="location">
            <div class="fac-details-name-address">
                <h2 class="fac-details-name"><?=$row['facility_name']?></h2>
                <span class="fac-details-address"><?=$row['facility_street']?>, <?=$row['facility_city']?>, <?=$row['facility_postal']?></span>
            </div>
            <div class="google-map">
                <iframe src="<?=$row['map_link']?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="facility-desc">
            <p><?=$row['details_desc']?></p>
        </div>

        <div>
        <?php $filePath = 'http://www.indoorgolfdir.com';?>
            <h3 class="mid-title">Amenities</h3>
            <div class="amenities-box">
                <div class="amenities">
                    <?php if($row['bar']) echo "<img class='sm-icon' src='$filePath/assets/icons/green_check.png' alt='facility image'> Licensed bar"?>
                    <?php if(!$row['bar']) echo "<img class='sm-icon' src='$filePath/assets/icons/red_x.png' alt='facility red image'> Licensed bar"?>
                </div>
                <div class="amenities">
                    <?php if($row['food']) echo "<img class='sm-icon' src='$filePath/assets/icons/green_check.png' alt='facility image'> Food available"?>
                    <?php if(!$row['food']) echo "<img class='sm-icon' src='$filePath/assets/icons/red_x.png' alt='facility red image'> Food available"?>
                </div>
                <div class="amenities">
                    <?php if($row['lessons']) echo "<img class='sm-icon' src='$filePath/assets/icons/green_check.png' alt='facility image'> Lessons available"?>
                    <?php if(!$row['lessons']) echo "<img class='sm-icon' src='$filePath/assets/icons/red_x.png' alt='facility red image'> Lessons available"?>
                </div>
                <div class="amenities">
                    <?php if($row['leagues']) echo "<img class='sm-icon' src='$filePath/assets/icons/green_check.png' alt='facility image'> Organized leagues"?>
                    <?php if(!$row['leagues']) echo "<img class='sm-icon' src='$filePath/assets/icons/red_x.png' alt='facility red image'> Organized leagues"?>
                </div>
                <div class="amenities">
                    <?php if($row['24hrs']) echo "<img class='sm-icon' src='$filePath/assets/icons/green_check.png' alt='facility image'> 24hr automated access"?>
                    <?php if(!$row['24hrs']) echo "<img class='sm-icon' src='$filePath/assets/icons/red_x.png' alt='facility red image'> 24hr automated access"?>
                </div>
                <div class="amenities">
                    <?php echo "<img class='sm-icon' src='$filePath/assets/icons/green_check.png' alt='checkmark'>"?> Facility has <?=$row['bays']?> bays
                </div>
            </div>
        </div>
        <div>
            <div class="sm-title">Visit <?=$row['facility_name']?> website</div>
            <span class="website-link">
                <a target="_blank" href="<?=$row['website_link']?>"><?=$row['website_short']?></a>
            </span>
        </div>
    </div>
</section>


<?php require page('includes/footer');?>