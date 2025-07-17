<?php require page('includes/header');?>

<!-- Hero Section -->
<div id="country-hero">
    <img src="<?=ROOT?>/assets/images/canadaFlag.jpg" alt="Canada Flag">
</div>

<div class="page-container">
    <div class="container region-container">
        <h1 class="headline-region">Find Indoor Golf Facilities by Province</h1>
    </div>
    <div class="prov-btns">
        <a href="<?=ROOT?>/ontario" class="prov-btn">Ontario</a>
        <a href="<?=ROOT?>/britishcolumbia" class="prov-btn">British Columbia</a>
        <a href="<?=ROOT?>/alberta" class="prov-btn">Alberta</a>
        <a href="<?=ROOT?>/quebec" class="prov-coming-btn">Quebec</a>
        <a href="<?=ROOT?>/maritimes" class="prov-btn">Maritimes</a>
        <a href="<?=ROOT?>/manitoba" class="prov-coming-btn">Manitoba</a>
        <a href="<?=ROOT?>/sask" class="prov-coming-btn">Saskatchewan</a>
        <!-- <a href="<?=ROOT?>/territories" class="prov-coming-btn">The Territories</a> -->
    </div>

<!-- ad space -->
    <div class="wide-ad-item">
        <span>Sponsored Ad</span>
        <a rel="sponsored" href="https://globalgolf.sjv.io/c/6375208/2017685/15292" target="_blank" id="2017685">
            <img src="//a.impactradius-go.com/display-ad/15292-2017685" alt="global golf ad"/>
        </a>
        <img src="https://imp.pxf.io/i/6375208/2017685/15292" style="position:absolute;visibility:hidden;"/>
        
    </div>
</div>


<?php require page('includes/footer');?>