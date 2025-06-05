<?php require page('includes/header');?>
<?php require page('includes/hero');?>

<section class="container">
<div>
	<p class="intro">The popularity of indoor golf has exploded in recent years.  Indoor golf facilities provide a fun, convenient place for golfers to practice and play the game of golf regardless of weather conditions. These facilities vary in size and features, catering to both casual and professional players. At The Indoor Golf Directory, we aim to make it easy for you to find a facility in your area or where you may be traveling to.  We highlight the facilities amenities and provide links to all active facility websites.</p>
</div>

<h3 id="country" class="headline-text">What Country are you looking in?</h3>
	<div class="country-grid" data-aos="zoom-out" aos-duration="2500">
		<div class="canada">
			<h2 class="can">Canada</h2>
			<div class="dropdown">
				<select name="provinces" id="provinces" onchange="window.location.href=this.value;">
					<option value="nothing">-- Select a Province --</option>

				<?php
					$query = "select * from states where country = 'can' and active = 1";
					$rows = db_query($query);
				?>
				<?php if(!empty($rows)):?>
					<?php foreach($rows as $row):?>
						<?php $state = $row['state']?>
						<option <?=set_select('state',$state)?> value="<?=ROOT?>/<?=$row['page_name']?>"><?=$row['state_name']?></option>;
				<?php endforeach;?>
				<?php endif;?>
				</select>
			</div>
		</div>

		<div class="unitedstates">
			<h2 class="usa">United States</h2>
			<div class="dropdown">
				<select name="usStates" id="usStates" onchange="window.location.href=this.value;">
					<option value="">-- Select a State --</option>

				<?php
					$query = "select * from states where country = 'usa' and active = 1";
					$rows = db_query($query);
				?>
				<?php if(!empty($rows)):?>
					<?php foreach($rows as $row):?>
						<?php $state = $row['state']?>
						<option <?=set_select('state',$state)?> value="<?=ROOT?>/<?=$row['page_name']?>"><?=$row['state_name']?></option>;
				<?php endforeach;?>
				<?php endif;?>
				</select>
			</div>
		</div>
	</div>


<div class="search-main">
	<!-- <span>Quick search</span> -->
	<form action="search" method="POST">
		<label for="search">Quick search</label>
		<input type="text" name="search" placeholder="facility name or city">
		<button class="btn btn-dark" type="submit" name="submit-search">Search</button>
	</form>
</div>
</section>





<?php require page('includes/footer');?>
