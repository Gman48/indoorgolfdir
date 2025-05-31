<?php require page('includes/header')?>

	<?php
		if (isset($_POST['submit-search'])) 
		{
			$search = clean_search($_POST['search']); // to ensure data typed in is safe
			$limit = 1000;
			$offset = ($page - 1) * $limit;

			$query = "SELECT * from allfacilities WHERE facility_name LIKE '%$search%' OR facility_city LIKE '%$search%' OR state LIKE '%$search%' OR region LIKE '%$search%' limit $limit offset $offset";
			$rows = db_query($query); ?>


	<div class="table-container">
		<h3 class="admin-table-head">Facilities Search Results</h3>

			<table class="table">
				<tr>
					<th>Name</th>
					<th>City</th>
					<th>State</th>
					<th>Region</th>
					<th>Website Link</th>
				</tr>

				<?php if(!empty($rows)):?>
					<?php foreach($rows as $row):?>
						<tr>
							<td>
								<a href="<?=ROOT?>/facility_details?facility_id=<?=$row['facility_id']?>"><?=esc($row['facility_name'])?></a>
							</td>
							<td><?=$row['facility_city']?></td>
							<td><?=$row['state']?></td>
							<td><?=$row['region']?></td>
							<td>
								<a target="_blank" href="<?=$row['website_link']?>"><?=esc($row['website_link'])?></a>
							</td>
						</tr>
					<?php endforeach;?>
				
				<?php else: ?>
					<div class="search-alert">There are no results matching your search for: <?=$search?></div>
				
				<?php endif;?>
				<?php } ?>
			</table>

		<div class="mx-2">
			<a href="<?=ROOT?>/search?page=<?=$prev_page?>">
				<button class="btn btn-prev">Prev</button>
			</a>
			<a href="<?=ROOT?>/search?page=<?=$next_page?>">
				<button class="float-end btn btn-next">Next</button>
			</a>
		</div>
	</div>

<?php require page('includes/footer-small')?>