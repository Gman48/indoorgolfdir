<!-- This file is for including the tasty tales card on a page -->
<!--start tasty tales card-->
<div class="col">
    <div class="card card-test h-100">
        <img src="<?=ROOT?>/<?=$row['image']?>" class="card-img-top test-img" alt="">

        <div class="card-body">
            <p class="card-text test-card-text"><?=esc($row['tale'])?></p>
        </div>
        
        <div class="card-footer test-card-footer">
            <h3><?=esc($row['name'])?></h3>
        </div>
    </div>
</div>
<!--end product card-->

