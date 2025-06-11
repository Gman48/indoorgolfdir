<?php 
// This is the Facilities page in ADMIN

// functions to add a new facility
	if($action == 'add')
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
		// -- data validation --
			$errors = [];
			if(empty($_POST['facility_name']))
			{
				$errors['facility_name'] = "Facility name is required";
			} 
			else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\(\)\!\'\']+$/", $_POST['facility_name'])){
				$errors['facility_name'] = "Facility name can only have letters & spaces";
			}
		
			if(empty($_POST['state']))
			{
				$errors['state'] = "Province or State is required";
			}

			if(empty($_POST['country']))
			{
				$errors['country'] = "Country is required";
			}

			if(empty($_POST['region']))
			{
				$errors['region'] = "Region  is required";
			}
		
			// Main image (required)
			if(!empty($_FILES['facility_img']['name'])) //'image' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", ""); // for security purposes puts an empty index file in folder so can't access any other files in the folder.
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img']['error'] == 0 && in_array($_FILES['facility_img']['type'], $allowed))
				{
					$destination_image = $folder. $_FILES['facility_img']['name'];

					move_uploaded_file($_FILES['facility_img']['tmp_name'], $destination_image);

				}else{
					$errors['facility_img'] = "Image not valid. Allowed types are ". implode(",", $allowed);
				}
			}else {
				$errors['facility_img'] = "A main image is required";
			}

			// Image2, just checking valid format
			if(!empty($_FILES['facility_img2']['name'])) //'facility_img2' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", ""); // for security purposes puts an empty index file in folder so can't access any other files in the folder.
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img2']['error'] == 0 && in_array($_FILES['facility_img2']['type'], $allowed))
				{
					$destination_image2 = $folder. $_FILES['facility_img2']['name'];

					move_uploaded_file($_FILES['facility_img2']['tmp_name'], $destination_image2);

				}else {
					$errors['facility_img2'] = "Image not valid. Allowed types are ". implode(",", $allowed);
				}
			}

			// Image3, just checking valid format
			if(!empty($_FILES['facility_img3']['name'])) //'facility_img3' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", ""); // for security purposes puts an empty index file in folder so can't access any other files in the folder.
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img2']['error'] == 0 && in_array($_FILES['facility_img3']['type'], $allowed))
				{
					$destination_image3 = $folder. $_FILES['facility_img3']['name'];

					move_uploaded_file($_FILES['facility_img3']['tmp_name'], $destination_image3);

				}else{
					$errors['facility_img3'] = "Image not valid. Allowed types are ". implode(",", $allowed);
				}
			}

			// Image4, just checking valid format
			if(!empty($_FILES['facility_img4']['name'])) //'facility_img4' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", ""); // for security purposes puts an empty index file in folder so can't access any other files in the folder.
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img2']['error'] == 0 && in_array($_FILES['facility_img4']['type'], $allowed))
				{
					$destination_image4 = $folder. $_FILES['facility_img4']['name'];

					move_uploaded_file($_FILES['facility_img4']['tmp_name'], $destination_image4);

				}else{
					$errors['facility_img4'] = "Image not valid. Allowed types are ". implode(",", $allowed);
				}
			}

	// when no errors, add facility info to database
			if(empty($errors))
			{
				$values = [];
				$values['facility_name'] 	= trim($_POST['facility_name']);
				$values['facility_street'] 	= trim($_POST['facility_street']);
				$values['facility_city'] 	= trim($_POST['facility_city']);
				$values['facility_postal'] 	= trim($_POST['facility_postal']);
				$values['state'] 	= strtolower(trim($_POST['state']));
				$values['country'] 	= strtolower(trim($_POST['country']));
				$values['region'] 	= strtolower(trim($_POST['region']));
				$values['website_link'] 	= trim($_POST['website_link']);
				$values['website_short'] 	= trim($_POST['website_short']);
				$values['contact'] 	= trim($_POST['contact']);
				$values['featured'] 	= trim($_POST['featured']);
				$values['bar'] 	= trim($_POST['bar']);
				$values['food'] 	= trim($_POST['food']);
				$values['lessons'] 	= trim($_POST['lessons']);
				$values['leagues'] 	= trim($_POST['leagues']);
				$values['24hrs'] 	= trim($_POST['24hrs']);
				$values['bays'] 	= trim($_POST['bays']);
				$values['notes'] 	= ($_POST['notes']);
				$values['details_desc'] 	= ($_POST['details_desc']);
				$values['facility_img'] 	= $destination_image;
				$values['facility_img2'] 	= $destination_image2;
				$values['facility_img3'] 	= $destination_image3;
				$values['facility_img4'] 	= $destination_image4;
				$values['map_link'] 	= trim($_POST['map_link']);
				$values['active'] 	= trim($_POST['active']);
				$values['facility_slug'] 	= str_to_url($values['facility_name']);
				$values['rating'] 	= trim($_POST['rating']);
				$values['reviews'] 	= trim($_POST['reviews']);
				$values['keyword'] 	= trim($_POST['keyword']);

				$query = "insert into allfacilities (facility_name, facility_street, facility_city, facility_postal, state, country, region, website_link,website_short, contact, featured, bar, food, lessons, leagues, 24hrs, bays, notes, details_desc, facility_img, facility_img2, facility_img3, facility_img4, map_link, active, facility_slug, rating, reviews, keyword) values (:facility_name, :facility_street, :facility_city, :facility_postal, :state, :country, :region, :website_link,:website_short, :contact, :featured, :bar, :food, :lessons, :leagues, :24hrs, :bays, :notes, :details_desc, :facility_img, :facility_img2, :facility_img3, :facility_img4, :map_link, :active, :facility_slug, :rating, :reviews, :keyword)";
				db_query($query,$values);

				message("Facility successfully added to database");
				redirect('admin/facilities_admin');
			}
		}
	} else

// functions to edit a facility
	if($action == 'edit')
	{
		$query = "select * from allfacilities where facility_id = :facility_id limit 1";
		$row = db_query_one($query,['facility_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			//data validation
			if(empty($_POST['facility_name']))
			{
				$errors['facility_name'] = "Facility name is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\+\']+$/", $_POST['facility_name'])){
				$errors['facility_name'] = "Facility name can only have letters & spaces";
			}

			if(empty($_POST['state']))
			{
				$errors['state'] = "Province or State is required";
			}

			if(empty($_POST['country']))
			{
				$errors['country'] = "Country is required";
			}

			if(empty($_POST['region']))
			{
				$errors['region'] = "Region  is required";
			}
		
			if(empty($errors))
			{
				$values = [];
				$values['facility_name'] 	= trim($_POST['facility_name']);
				$values['facility_street'] 	= trim($_POST['facility_street']);
				$values['facility_city'] 	= trim($_POST['facility_city']);
				$values['facility_postal'] 	= trim($_POST['facility_postal']);
				$values['state'] 	= strtolower(trim($_POST['state']));
				$values['country'] 	= strtolower(trim($_POST['country']));
				$values['region'] 	= strtolower(trim($_POST['region']));
				$values['website_link'] 	= trim($_POST['website_link']);
				$values['website_short'] 	= trim($_POST['website_short']);
				$values['contact'] 	= trim($_POST['contact']);
				$values['featured'] 	= trim($_POST['featured']);
				$values['bar'] 	= trim($_POST['bar']);
				$values['food'] 	= trim($_POST['food']);
				$values['lessons'] 	= trim($_POST['lessons']);
				$values['leagues'] 	= trim($_POST['leagues']);
				$values['24hrs'] 	= trim($_POST['24hrs']);
				$values['bays'] 	= trim($_POST['bays']);
				$values['notes'] 	= ($_POST['notes']);
				$values['details_desc'] 	= ($_POST['details_desc']);
				$values['map_link'] 	= trim($_POST['map_link']);
				$values['active'] 	= trim($_POST['active']);
				$values['facility_slug'] 	= str_to_url($values['facility_name']);
				$values['rating'] 	= trim($_POST['rating']);
				$values['reviews'] 	= trim($_POST['reviews']);
				$values['keyword'] 	= trim($_POST['keyword']);
				$values['facility_id'] 	= $id;

				$query = "update allfacilities set facility_name = :facility_name, facility_street = :facility_street, facility_city = :facility_city, facility_postal = :facility_postal, state = :state, country = :country, region = :region, website_link = :website_link, website_short = :website_short, contact = :contact, featured = :featured, bar = :bar,  food = :food, lessons = :lessons, leagues = :leagues, 24hrs = :24hrs, bays = :bays, notes = :notes, details_desc = :details_desc, map_link = :map_link, active = :active, facility_slug = :facility_slug, rating = :rating, reviews = :reviews, keyword = :keyword where facility_id = :facility_id limit 1";

				db_query($query,$values);

				message("Facility information edited successfully");
				redirect('admin/facilities_admin');
			}
		}
	} else

// functions to edit a facility image
	if($action == 'edit_image')
	{
		$query = "select * from allfacilities where facility_id = :facility_id limit 1";
		$row = db_query_one($query,['facility_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			// Main image
			// if no file in form, set a default file name
			if(empty($_FILES['facility_img']['name'])) {
				$img = "no_image.jpg";
				$_FILES['facility_img']['name'] = $img;
			}

			if(!empty($_FILES['facility_img']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img']['error'] == 0 && in_array($_FILES['facility_img']['type'], $allowed))
				{
					$destination_image = $folder. $_FILES['facility_img']['name'];
					move_uploaded_file($_FILES['facility_img']['tmp_name'], $destination_image);
					
					//delete old file
					if(file_exists($row['facility_img']))
					{
						unlink($row['facility_img']);
					}

				}else{
					$errors['facility_img'] = "Image not valid. allowed types are ". implode(",", $allowed);
				}
			}

			// Image2
			if(!empty($_FILES['facility_img2']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img2']['error'] == 0 && in_array($_FILES['facility_img2']['type'], $allowed))
				{
					$destination_image2 = $folder. $_FILES['facility_img2']['name'];
					move_uploaded_file($_FILES['facility_img2']['tmp_name'], $destination_image2);
					
					//delete old file
					if(file_exists($row['facility_img2']))
					{
						unlink($row['facility_img2']);
					}

				}else{
					$errors['facility_img2'] = "Image not valid. allowed types are ". implode(",", $allowed);
				}
			}

			// Image3, just checking valid format
			if(!empty($_FILES['facility_img3']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img3']['error'] == 0 && in_array($_FILES['facility_img3']['type'], $allowed))
				{
					$destination_image3 = $folder. $_FILES['facility_img3']['name'];
					move_uploaded_file($_FILES['facility_img3']['tmp_name'], $destination_image3);
					
					//delete old file
					if(file_exists($row['facility_img3']))
					{
						unlink($row['facility_img3']);
					}

				}else{
					$errors['facility_img2'] = "Image not valid. allowed types are ". implode(",", $allowed);
				}
			}

			// Image4
			if(!empty($_FILES['facility_img4']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp', 'image/avif'];
				if($_FILES['facility_img4']['error'] == 0 && in_array($_FILES['facility_img4']['type'], $allowed))
				{
					$destination_image4 = $folder. $_FILES['facility_img4']['name'];
					move_uploaded_file($_FILES['facility_img4']['tmp_name'], $destination_image4);
					
					//delete old file
					if(file_exists($row['facility_img4']))
					{
						unlink($row['facility_img4']);
					}

				}else{
					$errors['facility_img4'] = "Image not valid. allowed types are ". implode(",", $allowed);
				}
			}

			if(empty($errors))
			{
				$values = [];
				$values['facility_img'] 	= $destination_image;
				$values['facility_img2'] 	= $destination_image2;
				$values['facility_img3'] 	= $destination_image3;
				$values['facility_img4'] 	= $destination_image4;
				$values['facility_id'] 		= $id;

				$query = "update allfacilities set facility_img = :facility_img, facility_img2 = :facility_img2, facility_img3 = :facility_img3, facility_img4 = :facility_img4 where facility_id = :facility_id limit 1";

				db_query($query,$values);

				message("Facility images were edited successfully");
				redirect('admin/facilities_admin');
			}
		}
	} else


// functions to delete a facility
	if($action == 'delete')
	{
		$query = "select * from allfacilities where facility_id = :facility_id limit 1";
		$row = db_query_one($query,['facility_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			if(empty($errors))
			{
				$values = [];
				$values['facility_id'] = $id;

				$query = "delete from allfacilities where facility_id = :facility_id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['facility_img']))
				{
					unlink($row['facility_img']);
				}
				//delete image2
				if(file_exists($row['facility_img2']))
				{
					unlink($row['facility_img2']);
				}
				//delete image3
				if(file_exists($row['facility_img3']))
				{
					unlink($row['facility_img3']);
				}
				//delete image4
				if(file_exists($row['facility_img4']))
				{
					unlink($row['facility_img4']);
				}
				message("Facility deleted successfully");
				redirect('admin/facilities_admin');
			}
		}
	}
?>

<!---------- PAGE VIEWS ---------->
<?php require page('includes/admin-header')?>

<section class="admin-content">

<!-- page view for ADDING a facility -->
<?php if($action == 'add'):?>

	<div class="form-container">
		<form name="my-form" method="post" enctype="multipart/form-data" class="form-lg">

			<h3 class="form-heading">Add New Facility</h3>

			<input name="facility_name" class="form-control my-1" value="<?=set_value('facility_name')?>" type="text" title="facility_name" placeholder="Facility name">
			<?php if(!empty($errors['facility_name'])):?>
				<small class="error"><?=$errors['facility_name']?></small>
			<?php endif;?>

			<input name="facility_street" class="form-control my-1" value="<?=set_value('facility_street')?>" type="text" title="facility_street" placeholder="Street address">
			<?php if(!empty($errors['facility_street'])):?>
				<small class="error"><?=$errors['facility_street']?></small>
			<?php endif;?>

			<input name="facility_city" class="form-control my-1" value="<?=set_value('facility_city')?>" type="text" title="facility_city" placeholder="City">
			<?php if(!empty($errors['facility_city'])):?>
				<small class="error"><?=$errors['facility_city']?></small>
			<?php endif;?>

			<input name="facility_postal" class="form-control my-1" value="<?=set_value('facility_postal')?>" type="text" title="facility_postal" placeholder="Postal Code">
			<?php if(!empty($errors['facility_postal'])):?>
				<small class="error"><?=$errors['facility_postal']?></small>
			<?php endif;?>

<!-- Existing Code for Country -->
			<select name="country" class="form-control my-1" onclick="getStates(this.value)">
				<option value="">--Select Country--</option>
				<option <?=set_select('country','can')?> value="can">Canada</option>
				<option <?=set_select('country','usa')?> value="usa">United States</option>
			</select>
			<?php if(!empty($errors['country'])):?>
			<small class="error"><?=$errors['country'];?></small>
			<?php endif;?>
<!-- END existing code for Country -->



<!-- Existing Code for State  -->
			<select name="state" class="form-control my-1">
				<option value="">Select a Province or State</option>
				<option value="">--- CANADA ---</option>
			<?php
			$query = "select * from states where country = 'can'";
			$rows = db_query($query);
			?>
			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<?php $state = $row['state']?>
					<option <?=set_select('state',$state)?> value=<?=$row['state']?>><?=$row['state_name']?></option>;
			<?php endforeach;?>
			<?php endif;?>
				
				<option value="">--- UNITED STATES ---</option>
			<?php
			$query = "select * from states where country = 'usa'";
			$rows = db_query($query);
			?>
			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<?php $state = $row['state']?>
					<option <?=set_select('state',$state)?> value=<?=$row['state']?>><?=$row['state_name']?></option>;
			<?php endforeach;?>
			<?php endif;?>

        	</select>
			<?php if(!empty($errors['state'])):?>
			<small class="error"><?=$errors['state'];?></small>
			<?php endif;?>
<!-- END existing code for State -->

<!-- Existing Code for Region  -->
			<select name="region" class="form-control my-1">
				<option value="">--Select Region--</option>
			<?php
			$query = "select * from regions order by region_name asc";
			$rows = db_query($query);
			?>
			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<?php $region = $row['region']?>
					<option <?=set_select('region',$region)?> value=<?=$row['region']?>><?=$row['region_name']?></option>;
			<?php endforeach;?>
			<?php endif;?>

			</select>
			<?php if(!empty($errors['region'])):?>
			<small class="error"><?=$errors['region'];?></small>
			<?php endif;?>
<!-- END existing code for State -->


<!-- Dynamically populate Country, State and Region -->
<!-- Dynamic Country Selection -->
<!-- <select name="countries" onclick="getProvState(this.value)">
	<option value="">Choose a Country</option>
	<?php
		$countries = getCountries();
		foreach($countries as $country) {
			?>
				<option value="<?php echo $country['country'] ?>"><?php echo $country['country_name'] ?></option>
		<?php
		}
		?>
</select> -->

<!-- Dynamic ProvState Selection -->
<!-- <select name="provstate" disabled onclick="getRegions(this.value)">
    <option value="">Choose a Province/State</option>
</select> -->

<!-- Dynamic Region Selection -->
<!-- <select name="regions" disabled>
    <option value="">Choose a Region</option>
</select> -->

<!-- ==== END Dynamic code for Country, State and Region ==== -->

			<input name="website_link" class="form-control my-1" value="<?=set_value('website_link')?>" type="text" title="website_link" placeholder="Website Link">
			<?php if(!empty($errors['website_link'])):?>
				<small class="error"><?=$errors['website_link']?></small>
			<?php endif;?>

			<input name="website_short" class="form-control my-1" value="<?=set_value('website_short')?>" type="text" title="website_short" placeholder="Website short name">
			<?php if(!empty($errors['website_short'])):?>
				<small class="error"><?=$errors['website_short']?></small>
			<?php endif;?>

			<input name="contact" class="form-control my-1" value="<?=set_value('contact')?>" type="text" title="contact" placeholder="Contact person">
			<?php if(!empty($errors['contact'])):?>
				<small class="error"><?=$errors['contact']?></small>
			<?php endif;?>

			<label for="featured" class="label-name">Featured Facility</label>
			<select name="featured" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('featured','1')?> value="1">Yes</option>
				<option <?=set_select('featured','0')?> value="0">No</option>
			</select>

			<label for="bar" class="label-name">Licensed bar available</label>
			<select name="bar" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('bar','1')?> value="1">Yes</option>
				<option <?=set_select('bar','0')?> value="0">No</option>
			</select>

			<label for="food" class="label-name">Facility has food available</label>
			<select name="food" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('food','1')?> value="1">Yes</option>
				<option <?=set_select('food','0')?> value="0">No</option>
			</select>

			<label for="lessons" class="label-name">Facility offers lessons</label>
			<select name="lessons" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('lessons','1')?> value="1">Yes</option>
				<option <?=set_select('lessons','0')?> value="0">No</option>
			</select>

			<label for="leagues" class="label-name">Facility has leagues</label>
			<select name="leagues" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('leagues','1')?> value="1">Yes</option>
				<option <?=set_select('leagues','0')?> value="0">No</option>
			</select>

			<label for="24hrs" class="label-name">Facility is fully automated, open 24hrs</label>
			<select name="24hrs" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('24hrs','1')?> value="1">Yes</option>
				<option <?=set_select('24hrs','0')?> value="0">No</option>
			</select>

			<label for="bays" class="label-name">Number of simulator bays</label>
			<input name="bays" class="form-control my-1" value="<?=set_value('bays')?>" type="text" title="bays" placeholder="Number of simulators the facility has">
			<?php if(!empty($errors['bays'])):?>
				<small class="error"><?=$errors['bays']?></small>
			<?php endif;?>
			
			<label for="notes" class="label-name">Notes</label>
			<textarea rows="10" class="form-control my-1" name="notes"><?=set_value('notes')?></textarea>
			<?php if(!empty($errors['notes'])):?>
				<small class="error"><?=$errors['notes']?></small>
			<?php endif;?>

			<label class="label-name">Description for details page</label>
			<textarea rows="10" class="form-control my-1" name="details_desc"><?=set_value('details_desc')?></textarea>
			<?php if(!empty($errors['details_desc'])):?>
				<small class="error"><?=$errors['details_desc']?></small>
			<?php endif;?>

			<div class="form-control my-1">
				<div class="label-name">Main Image</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img">
				
				<?php if(!empty($errors['facility_img'])):?>
					<small class="error"><?=$errors['facility_img']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div class="label-name">Image 2</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img2">
				
				<?php if(!empty($errors['facility_img2'])):?>
					<small class="error"><?=$errors['facility_img2']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div class="label-name">Image 3</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img3">
				
				<?php if(!empty($errors['facility_img3'])):?>
					<small class="error"><?=$errors['facility_img3']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div class="label-name">Image 4</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img4">
				
				<?php if(!empty($errors['facility_img4'])):?>
					<small class="error"><?=$errors['facility_img4']?></small>
				<?php endif;?>
			</div>

			<label for="map_link" class="label-name">Google maps link</label>
			<textarea rows="8" class="form-control my-1" name="map_link"><?=set_value('map_link')?></textarea>
			<!-- <input name="map_link" class="form-control my-1" value="<?=set_value('map_link')?>" type="text" title="map_link" placeholder="Map Link"> -->
			<?php if(!empty($errors['map_link'])):?>
				<small class="error"><?=$errors['map_link']?></small>
			<?php endif;?>

			<label for="active" class="label-name">Facility is active</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('active','1')?> value="1">Yes</option>
				<option <?=set_select('active','0')?> value="0">No</option>
			</select>

			<label for="rating" class="label-name">Google rating</label>
			<input name="rating" class="form-control my-1" value="<?=set_value('rating')?>" type="text" title="rating" placeholder="Google rating">
			<?php if(!empty($errors['rating'])):?>
				<small class="error"><?=$errors['rating']?></small>
			<?php endif;?>

			<label for="reviews" class="label-name">Number of Google reviews</label>
			<input name="reviews" class="form-control my-1" value="<?=set_value('reviews')?>" type="text" title="reviews" placeholder="Number of Google reviews">
			<?php if(!empty($errors['reviews'])):?>
				<small class="error"><?=$errors['reviews']?></small>
			<?php endif;?>

			<label for="keyword" class="label-name">Google keyword listing</label>
			<input name="keyword" class="form-control my-1" value="<?=set_value('keyword')?>" type="text" title="keyword" placeholder="Google keyword">
			<?php if(!empty($errors['keyword'])):?>
				<small class="error"><?=$errors['keyword']?></small>
			<?php endif;?>

			<button class="btn btn-save">Add new facility</button>
			<a href="<?=ROOT?>/admin/facilities_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>
		</form>
	</div>

<!-- page view for EDITING a facility -->
<?php elseif($action == 'edit'):?>

	<div class="form-container">
		<form method="post" enctype="multipart/form-data">
		<h3 class="form-heading">Edit Facility</h3>

		<?php if(!empty($row)):?>
		
			<label for="facility_name" class="my-1 label-name">Facility name</label>
			<input name="facility_name" class="form-control my-1" value="<?=set_value('facility_name', $row['facility_name'])?>" type="text" title="facility_name" placeholder="Facility name">
				<?php if(!empty($errors['facility_name'])):?>
					<small class="error"><?=$errors['facility_name']?></small>
				<?php endif;?>

			<label for="facility_street" class="my-1 label-name">Facility address</label>
			<input name="facility_street" class="form-control my-1" value="<?=set_value('facility_street', $row['facility_street'])?>" type="text" title="facility_street" placeholder="Street address">
			<?php if(!empty($errors['facility_street'])):?>
				<small class="error"><?=$errors['facility_street']?></small>
			<?php endif;?>

			<label for="facility_city" class="my-1 label-name">City</label>
			<input name="facility_city" class="form-control my-1" value="<?=set_value('facility_city', $row['facility_city'])?>" type="text" title="facility_city" placeholder="City">
			<?php if(!empty($errors['facility_city'])):?>
				<small class="error"><?=$errors['facility_city']?></small>
			<?php endif;?>

			<label for="facility_postal" class="my-1 label-name">Postal code</label>
			<input name="facility_postal" class="form-control my-1" value="<?=set_value('facility_postal', $row['facility_postal'])?>" type="text" title="facility_postal" placeholder="Postal Code">
			<?php if(!empty($errors['facility_postal'])):?>
				<small class="error"><?=$errors['facility_postal']?></small>
			<?php endif;?>

			<label for="country" class="my-1 label-name">Country</label>
			<select name="country" class="form-control my-1">
				<option value="">--Select Country--</option>
				<option <?=set_select('country','can',$row['country'])?> value="can">Canada</option>
				<option <?=set_select('country','usa',$row['country'])?> value="usa">United States</option>
			</select>
			<?php if(!empty($errors['country'])):?>
			<small class="error"><?=$errors['country'];?></small>
			<?php endif;?>

			<label for="state" class="my-1 label-name">Province/State</label>
			<select name="state" class="form-control my-1">
				<option value="">Select a Province or State</option>
				<option value="">-- Canada --</option>
				<option <?=set_select('state','ont',$row['state'])?> value="ont">Ontario</option>
				<option <?=set_select('state','que',$row['state'])?> value="que">Quebec</option>
				<option <?=set_select('state','bc',$row['state'])?> value="bc">British Columbia</option>
				<option <?=set_select('state','alb',$row['state'])?> value="alb">Alberta</option>
				<option <?=set_select('state','sk',$row['state'])?> value="sk">Saskatchewan</option>
				<option <?=set_select('state','mtb',$row['state'])?> value="mtb">Manitoba</option>
				<option <?=set_select('state','mtm',$row['state'])?> value="mtm">Maritimes</option>
				<option value="">-- United States --</option>
				<option <?=set_select('state','al',$row['state'])?> value="al">Alabama</option>
				<option <?=set_select('state','ak',$row['state'])?> value="ak">Alaska</option>
				<option <?=set_select('state','az',$row['state'])?> value="az">Arizona </option>
				<option <?=set_select('state','ar',$row['state'])?> value="ar">Arkansas</option>
				<option <?=set_select('state','ca',$row['state'])?> value="ca">California</option>
				<option <?=set_select('state','co',$row['state'])?> value="co">Colorado</option>
				<option <?=set_select('state','ct',$row['state'])?> value="ct">Connecticut</option>
				<option <?=set_select('state','de',$row['state'])?> value="de">Delaware</option>
				<option <?=set_select('state','fl',$row['state'])?> value="fl">Florida</option>
				<option <?=set_select('state','ga',$row['state'])?> value="ga">Georgia</option>
				<option <?=set_select('state','id',$row['state'])?> value="id">Idaho</option>
				<option <?=set_select('state','hi',$row['state'])?> value="hi">Hawaii</option>
				<option <?=set_select('state','il',$row['state'])?> value="il">Illinois</option>
				<option <?=set_select('state','in',$row['state'])?> value="in">Indiana</option>
				<option <?=set_select('state','ia',$row['state'])?> value="ia">Iowa</option>
				<option <?=set_select('state','ks',$row['state'])?> value="ks">Kansas</option>
				<option <?=set_select('state','ky',$row['state'])?> value="ky">Kentucky</option>
				<option <?=set_select('state','la',$row['state'])?> value="la">Louisiana</option>
				<option <?=set_select('state','me',$row['state'])?> value="me">Maine</option>
				<option <?=set_select('state','md',$row['state'])?> value="md">Maryland</option>
				<option <?=set_select('state','ma',$row['state'])?> value="ma">Massachusetts</option>
				<option <?=set_select('state','mi',$row['state'])?> value="mi">Michigan</option>
				<option <?=set_select('state','mn',$row['state'])?> value="mn">Minnesota</option>
				<option <?=set_select('state','ms',$row['state'])?> value="ms">Mississippi</option>
				<option <?=set_select('state','mo',$row['state'])?> value="mo">Missouri</option>
				<option <?=set_select('state','mt',$row['state'])?> value="mt">Montana</option>
				<option <?=set_select('state','ne',$row['state'])?> value="ne">Nebraska</option>
				<option <?=set_select('state','nv',$row['state'])?> value="nv">Nevada</option>
				<option <?=set_select('state','nh',$row['state'])?> value="nh">New Hampshire</option>
				<option <?=set_select('state','nj',$row['state'])?> value="nj">New Jersey</option>
				<option <?=set_select('state','nm',$row['state'])?> value="nm">New Mexico</option>
				<option <?=set_select('state','ny',$row['state'])?> value="ny">New York</option>
				<option <?=set_select('state','nc',$row['state'])?> value="nc">North Carolina</option>
				<option <?=set_select('state','nd',$row['state'])?> value="nd">North Dakota</option>
				<option <?=set_select('state','oh',$row['state'])?> value="oh">Ohio</option>
				<option <?=set_select('state','ok',$row['state'])?> value="ok">Oklahoma</option>
				<option <?=set_select('state','or',$row['state'])?> value="or">Oregon</option>
				<option <?=set_select('state','pa',$row['state'])?> value="pa">Pennsylvania</option>
				<option <?=set_select('state','ri',$row['state'])?> value="ri">Rhode Island</option>
				<option <?=set_select('state','sc',$row['state'])?> value="sc">South Carolina</option>
				<option <?=set_select('state','sd',$row['state'])?> value="sd">South Dakota</option>
				<option <?=set_select('state','tn',$row['state'])?> value="tn">Tennessee</option>
				<option <?=set_select('state','tx',$row['state'])?> value="tx">Texas</option>
				<option <?=set_select('state','ut',$row['state'])?> value="ut">Utah</option>
				<option <?=set_select('state','vt',$row['state'])?> value="vt">Vermont</option>
				<option <?=set_select('state','va',$row['state'])?> value="va">Virginia</option>
				<option <?=set_select('state','wa',$row['state'])?> value="wa">Washington</option>
				<option <?=set_select('state','wv',$row['state'])?> value="wv">West Virginia</option>
				<option <?=set_select('state','wi',$row['state'])?> value="wi">Wisconsin</option>
				<option <?=set_select('state','wy',$row['state'])?> value="wy">Wyoming</option>
        	</select>
			<?php if(!empty($errors['state'])):?>
			<small class="error"><?=$errors['state'];?></small>
			<?php endif;?>

			<label for="region" class="my-1 label-name">Region</label>
			<select name="region" class="form-control my-1">
				<option value="">--Select Region--</option>
				<option <?=set_select('region',$row['region'], $row['region'])?> value="<?=$row['region']?>"><?=$row['region']?></option>

			<?php
			$query_reg = "select * from regions order by region_name asc";
			$rows_reg = db_query($query_reg);
			?>
			<?php if(!empty($rows_reg)):?>
				<?php foreach($rows_reg as $row_reg):?>
					<?php $region = $row_reg['region']?>
					<option <?=set_select('region',$region)?> value=<?=$row_reg['region']?>><?=$row_reg['region_name']?></option>;
			<?php endforeach;?>
			<?php endif;?>

				<!-- <option <?=set_select('region','toronto')?> value="toronto">Toronto-GTA</option>
				<option <?=set_select('region','gta_west')?> value="gta_west">GTA-West</option>
				<option <?=set_select('region','gta_east')?> value="gta_east">GTA-East</option>
				<option <?=set_select('region','gta_north')?> value="gta_north">GTA-North</option>
				<option <?=set_select('region','niagara')?> value="niagara">Niagara</option> -->
			</select>
			<?php if(!empty($errors['region'])):?>
			<small class="error"><?=$errors['region'];?></small>
			<?php endif;?>

			<label for="website_link" class="my-1 label-name">Website Link</label>
			<input name="website_link" class="form-control my-1" value="<?=set_value('website_link', $row['website_link'])?>" type="text" title="website_link" placeholder="Website Link">
			<?php if(!empty($errors['website_link'])):?>
				<small class="error"><?=$errors['website_link']?></small>
			<?php endif;?>

			<label for="website_short" class="my-1 label-name">Website short name</label>
			<input name="website_short" class="form-control my-1" value="<?=set_value('website_short', $row['website_short'])?>" type="text" title="website_short" placeholder="Website short name">
			<?php if(!empty($errors['website_short'])):?>
				<small class="error"><?=$errors['website_short']?></small>
			<?php endif;?>

			<label for="contact" class="my-1 label-name">Business contact email/phone</label>
			<input name="contact" class="form-control my-1" value="<?=set_value('contact', $row['contact'])?>" type="text" title="contact" placeholder="Contact email/phone">
			<?php if(!empty($errors['contact'])):?>
				<small class="error"><?=$errors['contact']?></small>
			<?php endif;?>

			<label for="featured" class="label-name">Featured Facility</label>
			<select name="featured" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('featured','1', $row['featured'])?> value="1">Yes</option>
				<option <?=set_select('featured','0', $row['featured'])?> value="0">No</option>
			</select>

			<label for="bar" class="label-name">Licensed bar available</label>
			<select name="bar" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('bar','1', $row['bar'])?> value="1">Yes</option>
				<option <?=set_select('bar','0', $row['bar'])?> value="0">No</option>
			</select>

			<label for="food" class="label-name">Facility has food available</label>
			<select name="food" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('food','1', $row['food'])?> value="1">Yes</option>
				<option <?=set_select('food','0', $row['food'])?> value="0">No</option>
			</select>

			<label for="lessons" class="label-name">Facility offers lessons</label>
			<select name="lessons" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('lessons','1', $row['lessons'])?> value="1">Yes</option>
				<option <?=set_select('lessons','0', $row['lessons'])?> value="0">No</option>
			</select>

			<label for="leagues" class="label-name">Facility has leagues</label>
			<select name="leagues" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('leagues','1', $row['leagues'])?> value="1">Yes</option>
				<option <?=set_select('leagues','0', $row['leagues'])?> value="0">No</option>
			</select>

			<label for="24hrs" class="label-name">Facility is fully automated, open 24hrs</label>
			<select name="24hrs" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('24hrs','1', $row['24hrs'])?> value="1">Yes</option>
				<option <?=set_select('24hrs','0', $row['24hrs'])?> value="0">No</option>
			</select>

			<label for="bays" class="label-name">Number of simulator bays</label>
			<input name="bays" class="form-control my-1" value="<?=set_value('bays', $row['bays'])?>" type="text" title="bays" placeholder="Number of simulators the facility has">
			<?php if(!empty($errors['bays'])):?>
				<small class="error"><?=$errors['bays']?></small>
			<?php endif;?>
			
			<label for="notes" class="label-name">Notes</label>
			<textarea rows="5" class="form-control my-1" name="notes"><?=set_value('notes', $row['notes'])?></textarea>
			<?php if(!empty($errors['notes'])):?>
				<small class="error"><?=$errors['notes']?></small>
			<?php endif;?>

			<label class="label-name">Description for details page</label>
			<textarea rows="8" class="form-control my-1" name="details_desc"><?=set_value('details_desc', $row['details_desc'])?></textarea>
			<?php if(!empty($errors['details_desc'])):?>
				<small class="error"><?=$errors['details_desc']?></small>
			<?php endif;?>
			
			<label for="map_link" class="label-name">Google maps link</label>
			<textarea rows="8" class="form-control my-1" name="map_link"><?=set_value('map_link', $row['map_link'])?></textarea>
			<?php if(!empty($errors['map_link'])):?>
				<small class="error"><?=$errors['map_link']?></small>
			<?php endif;?>

			<label for="active" class="label-name">Facility is active</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('active','1', $row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0', $row['active'])?> value="0">No</option>
			</select>

			<label for="rating" class="label-name">Google rating</label>
			<input name="rating" class="form-control my-1" value="<?=set_value('rating', $row['rating'])?>" type="text" title="rating" placeholder="Google rating">
			<?php if(!empty($errors['rating'])):?>
				<small class="error"><?=$errors['rating']?></small>
			<?php endif;?>

			<label for="reviews" class="label-name">Number of Google reviews</label>
			<input name="reviews" class="form-control my-1" value="<?=set_value('reviews', $row['reviews'])?>" type="text" title="reviews" placeholder="Number of Google reviews">
			<?php if(!empty($errors['reviews'])):?>
				<small class="error"><?=$errors['reviews']?></small>
			<?php endif;?>

			<label for="keyword" class="label-name">Google keyword listing</label>
			<input name="keyword" class="form-control my-1" value="<?=set_value('keyword', $row['keyword'])?>" type="text" title="keyword" placeholder="Google keyword">
			<?php if(!empty($errors['keyword'])):?>
				<small class="error"><?=$errors['keyword']?></small>
			<?php endif;?>

			<button class="btn btn-save">Save Changes</button>
			<a href="<?=ROOT?>/admin/facilities_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/facilities_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>
		<?php endif;?>
		</form>
	</div>


<!-- page view for EDITING facility images-->
<?php elseif($action == 'edit_image'):?>

	<div class="form-container">
		<form method="post" enctype="multipart/form-data">
		<h3 class="form-heading">Edit Facility Images</h3>
		<h5 class="form-sub-heading"><?=$row['facility_name']?></h5>

		<?php if(!empty($row)):?>

			<div class="form-control my-1">
				<div class="label-name">Main Image</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img" value="<?=set_value('facility_img', $row['facility_img'])?>">
				
				<?php if(!empty($errors['facility_img'])):?>
					<small class="error"><?=$errors['facility_img']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div class="label-name">Image 2</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img2">
				
				<?php if(!empty($errors['facility_img2'])):?>
					<small class="error"><?=$errors['facility_img2']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div class="label-name">Image 3</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img3">
				
				<?php if(!empty($errors['facility_img3'])):?>
					<small class="error"><?=$errors['facility_img3']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div class="label-name">Image 4</div>
				<input class="form-control my-1 bg-white" type="file" name="facility_img4">
				
				<?php if(!empty($errors['facility_img4'])):?>
					<small class="error"><?=$errors['facility_img4']?></small>
				<?php endif;?>
			</div>

			<button class="btn btn-save">Save Changes</button>
				<a href="<?=ROOT?>/admin/facilities_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>

				<?php else:?>
					<div class="alert">That record was not found</div>
					<a href="<?=ROOT?>/admin/facilities_admin">
						<button type="button" class="float-end btn btn-back">Back</button>
					</a>
		<?php endif;?>
		</form>
	</div>

<!-- page view for DELETING a facility -->
<?php elseif($action == 'delete'):?>

	<div class="form-container">
		<form method="post">
			<h3 class="form-heading">Delete Facility</h3>
			<?php if(!empty($row)):?>

			<label class="label-name-big">Facility to be deleted - </label>
			<div class="form-control my-1 name-delete" ><?=set_value('facility_name',$row['facility_name'])?></div>
			<?php if(!empty($errors['facility_name'])):?>
				<small class="error"><?=$errors['facility_name']?></small>
			<?php endif;?>

			<button class="btn btn-delete">Delete this facility</button>
			<a href="<?=ROOT?>/admin/facilities_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/facilities_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>
			<?php endif;?>
		</form>
	</div>

<!-- page VIEW FOR MAIN PAGE OF FACILITIES -->
	<?php else:?>

		<?php
			$limit = 25;
			$offset = ($page - 1) * $limit;
			
			$query = "select * from allfacilities order by country, state, facility_name, region limit $limit offset $offset";
			$rows = db_query($query);
		?>

	<div class="table-container">
		<h3 class="admin-table-head">Facilities
			<!-- <div>Search Bar</div> -->
			<a href="<?=ROOT?>/admin/facilities_admin/add">
				<button class="float-end btn admin-btn-add">Add New</button>
			</a>
		</h3>
		<div class="mx-2">
			<a href="<?=ROOT?>/admin/facilities_admin?page=<?=$prev_page?>">
				<button class="btn btn-prev">Prev</button>
			</a>
			<a href="<?=ROOT?>/admin/facilities_admin?page=<?=$next_page?>">
				<button class="float-end btn btn-next">Next</button>
			</a>
		</div>

<!-- Display pagination buttons -->
<?php
$start = 0;
// get total number of rows
$rows_per_page = 25;

// get the total nr of rows
$mysqli = databaseConnection();
$records = $mysqli->query("select * from allfacilities");
$nr_of_rows = $records->num_rows;

// calculating the nr of pages
$pages = ceil($nr_of_rows / $rows_per_page);


//if the user clicks on pagination buttons we set starting point
if(isset($_GET['page'])) {
	$current_page = $_GET['page'] -1;
	$start = $current_page * $rows_per_page;
}

?>

<!-- Displaying the page info text -->
<div class="page-info">
<?php
	if(!isset($_GET['page'])) {
		$current_page = 1;
	} else {
		$current_page = $_GET['page'];
	}
?>
Showing <?php echo $current_page ?> of <?php echo $pages ?> pages
</div>
		<div class="pagination">
			<!-- Go to the first page -->
			
			<a href="?page=1">First</a>

			<!-- Go to previous page -->
			<?php 
				if(isset($_GET['page']) && $_GET['page'] > 1) { ?>
				<a href="?page=<?php echo $_GET['page'] -1 ?>">Previous</a>
			<?php
			} else { ?>
				<a href="">Previous</a>
			<?php } ?>

			<!-- Output the page numbers -->
			<div class="page-numbers">
			<?php
				for($counter = 1; $counter <= $pages; $counter ++) {
			?>
				<a href="?page=<?php echo $counter ?>"><?php echo $counter ?></a>
			<?php	
				}
			?>
			</div>

			<!-- Go to the next page -->
			<?php
				if(!isset($_GET['page'])) { ?>
					<a href="?page=2">Next</a>
			<?php
				} else {
					if($_GET['page'] >= $pages) { ?>
						<a href="">Next</a>
			<?php	} else {  ?>
					<a href="?page=<?php echo $_GET['page'] +1 ?>">Next</a>
			<?php
				}
			}
			?>

			<!-- Go to the last page -->
			<a href="?page=<?php echo $pages ?>">Last</a>

		</div>

		<table class="table">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>City</th>
				<th>State</th>
				<th>Region</th>
				<th>Image</th>
				<th>Website Link</th>
				<th>Description for details</th>
				<th>Featured</th>
				<th>Active</th>
				<th>Action</th>
			</tr>

			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<tr>
						<td><?=$row['facility_id']?></td>
						<td><?=$row['facility_name']?></td>
						<td><?=$row['facility_city']?></td>
						<td><?=$row['state']?></td>
						<td><?=$row['region']?></td>
						<td><img src="<?=ROOT?>/<?=$row['facility_img']?>" class="table-image"></td>
						<td><?=$row['website_link']?></td>
						<td><?=$row['details_desc']?></td>
						<td><?=$row['featured'] ? 'Yes':'No'?></td>
						<td><?=$row['active'] ? 'Yes':'No'?></td>
						<td>
							<a href="<?=ROOT?>/admin/facilities_admin/edit/<?=$row['facility_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
							</a>
							<a href="<?=ROOT?>/admin/facilities_admin/edit_image/<?=$row['facility_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/artIcon.png">
							</a>
							<a href="<?=ROOT?>/admin/facilities_admin/delete/<?=$row['facility_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
							</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>

		</table>

		<div class="mx-2">
			<a href="<?=ROOT?>/admin/facilities_admin?page=<?=$prev_page?>">
				<button class="btn btn-prev">Prev</button>
			</a>
			<a href="<?=ROOT?>/admin/facilities_admin?page=<?=$next_page?>">
				<button class="float-end btn btn-next">Next</button>
			</a>
		</div>
	<?php endif;?>
	</div>
</section>

<?php require page('includes/admin-footer')?>