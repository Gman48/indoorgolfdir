<?php 
// This is the Regions page in ADMIN

// functions to ADD a new Region
	if($action == 'add')
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
		// -- data validation --
			$errors = [];
			if(empty($_POST['region']))
			{
				$errors['region'] = "Region is required";
			} 
			else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\(\)\_\']+$/", $_POST['region'])){
				$errors['region'] = "Region can only have letters & underscore";
			}

            if(empty($_POST['region_name']))
			{
				$errors['region_name'] = "Region full name is required";
			} 
			else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\(\)\']+$/", $_POST['region_name'])){
				$errors['region_name'] = "Region full name can only have letters & certain symbols";
			}
		
			if(empty($_POST['state']))
			{
				$errors['state'] = "Province or State is required";
			}

			if(empty($_POST['country']))
			{
				$errors['country'] = "Country is required";
			}

			// Main image (required)
			if(!empty($_FILES['region_img']['name'])) //'image' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", ""); // for security purposes puts an empty index file in folder so can't access any other files in the folder.
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp'];
				if($_FILES['region_img']['error'] == 0 && in_array($_FILES['region_img']['type'], $allowed))
				{
					$destination_image = $folder. $_FILES['region_img']['name'];

					move_uploaded_file($_FILES['region_img']['tmp_name'], $destination_image);

				}else{
					$errors['region_img'] = "Region image not valid. Allowed types are ". implode(",", $allowed);
				}
			}else {
				$errors['region_img'] = "A region image is required";
			}
		

	// when no errors, ADD Region info to database
			if(empty($errors))
			{
				$values = [];
				$values['region'] 	= trim($_POST['region']);
				$values['region_name'] 	= trim($_POST['region_name']);
				$values['region_desc'] 	= trim($_POST['region_desc']);
				$values['state'] 	= strtolower(trim($_POST['state']));
				$values['country'] 	= strtolower(trim($_POST['country']));
				$values['region_img'] 	= $destination_image;
				$values['active'] 	= trim($_POST['active']);

				$query = "insert into regions (region, region_name, region_desc, state, country, region_img, active) values (:region, :region_name, :region_desc, :state, :country, :region_img, :active)";
				db_query($query,$values);

				message("Region successfully added to database");
				redirect('admin/regions_admin');
			}
        }
	} else

// functions to EDIT a Region
	if($action == 'edit')
	{
		$query = "select * from regions where region_id = :region_id limit 1";
		$row = db_query_one($query,['region_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			//data validation
            if(empty($_POST['region']))
			{
				$errors['region'] = "Region is required";
			}

			if(empty($_POST['region_name']))
			{
				$errors['region_name'] = "Region full name is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\']+$/", $_POST['region_name'])){
				$errors['region_name'] = "Region full name can only have letters & spaces";
			}

			if(empty($_POST['state']))
			{
				$errors['state'] = "Province or State is required";
			}

			if(empty($_POST['country']))
			{
				$errors['country'] = "Country is required";
			}
		
			// Region image
			if(!empty($_FILES['region_img']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png', 'image/jpg', 'image/webp'];
				if($_FILES['region_img']['error'] == 0 && in_array($_FILES['region_img']['type'], $allowed))
				{
					$destination_image = $folder. $_FILES['region_img']['name'];
					move_uploaded_file($_FILES['region_img']['tmp_name'], $destination_image);
					
					//delete old file
					if(file_exists($row['region_img']))
					{
						unlink($row['region_img']);
					}

				}else{
					$errors['region_img'] = "Region image not valid. allowed types are ". implode(",", $allowed);
				}
			}

			if(empty($errors))
			{
				$values = [];
				$values['region'] 	= strtolower(trim($_POST['region']));
				$values['region_name'] 	= trim($_POST['region_name']);
				$values['region_desc'] 	= trim($_POST['region_desc']);
				$values['state'] 	= strtolower(trim($_POST['state']));
				$values['country'] 	= strtolower(trim($_POST['country']));
				$values['region_img'] = $destination_image;
				$values['active'] 	= trim($_POST['active']);
				$values['region_id'] = $id;

				$query = "update regions set region = :region, region_name = :region_name, region_desc = :region_desc, state = :state, country = :country, region_img = :region_img, active = :active where region_id = :region_id limit 1";

				db_query($query,$values);

				message("Region information edited successfully");
				redirect('admin/regions_admin');
			}
		}
	} else

// functions to DELETE a Region
	if($action == 'delete')
	{
		$query = "select * from regions where region_id = :region_id limit 1";
		$row = db_query_one($query,['region_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			if(empty($errors))
			{
				$values = [];
				$values['region_id'] = $id;

				$query = "delete from regions where region_id = :region_id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['region_img']))
				{
					unlink($row['region_img']);
				}
				
				message("Region deleted successfully");
				redirect('admin/regions_admin');
			}
		}
	}
?>

<!---------- PAGE VIEWS ---------->
<?php require page('includes/admin-header')?>

<section class="admin-content">

<!-- page view for ADDING a Region -->
<?php if($action == 'add'):?>

	<div class="form-container">
		<form method="post" enctype="multipart/form-data" class="form-lg">

			<h3 class="form-heading">Add New Region</h3>

			<input name="region" class="form-control my-1" value="<?=set_value('region')?>" type="text" title="region" placeholder="Region (abbreviation)">
			<?php if(!empty($errors['region'])):?>
				<small class="error"><?=$errors['region']?></small>
			<?php endif;?>

            <input name="region_name" class="form-control my-1" value="<?=set_value('region_name')?>" type="text" title="region_name" placeholder="Region full name">
			<?php if(!empty($errors['region_name'])):?>
				<small class="error"><?=$errors['region_name']?></small>
			<?php endif;?>

			<input name="region_desc" class="form-control my-1" value="<?=set_value('region_desc')?>" type="text" title="region_desc" placeholder="Region wording to describe area on region page">
			<?php if(!empty($errors['region_desc'])):?>
				<small class="error"><?=$errors['region_desc']?></small>
			<?php endif;?>

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
				<!-- <option <?=set_select('state','ont')?> value="ont">Ontario</option>
				<option <?=set_select('state','que')?> value="que">Quebec</option>
				<option <?=set_select('state','bc')?> value="bc">British Columbia</option>
				<option <?=set_select('state','alb')?> value="alb">Alberta</option>
				<option <?=set_select('state','sk')?> value="sk">Saskatchewan</option>
				<option <?=set_select('state','mtb')?> value="mtb">Manitoba</option>
				<option <?=set_select('state','mtm')?> value="mtm">Maritimes</option> -->
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

				<!-- <option <?=set_select('state','al')?> value="al">Alabama</option>
				<option <?=set_select('state','ak')?> value="ak">Alaska</option>
				<option <?=set_select('state','az')?> value="az">Arizona </option>
				<option <?=set_select('state','ar')?> value="ar">Arkansas</option>
				<option <?=set_select('state','ca')?> value="ca">California</option>
				<option <?=set_select('state','co')?> value="co">Colorado</option>
				<option <?=set_select('state','ct')?> value="ct">Connecticut</option>
				<option <?=set_select('state','de')?> value="de">Delaware</option>
				<option <?=set_select('state','fl')?> value="fl">Florida</option>
				<option <?=set_select('state','ga')?> value="ga">Georgia</option>
				<option <?=set_select('state','id')?> value="id">Idaho</option>
				<option <?=set_select('state','hi')?> value="hi">Hawaii</option>
				<option <?=set_select('state','il')?> value="il">Illinois</option>
				<option <?=set_select('state','in')?> value="in">Indiana</option>
				<option <?=set_select('state','ia')?> value="ia">Iowa</option>
				<option <?=set_select('state','ks')?> value="ks">Kansas</option>
				<option <?=set_select('state','ky')?> value="ky">Kentucky</option>
				<option <?=set_select('state','la')?> value="la">Louisiana</option>
				<option <?=set_select('state','me')?> value="me">Maine</option>
				<option <?=set_select('state','md')?> value="md">Maryland</option>
				<option <?=set_select('state','ma')?> value="ma">Massachusetts</option>
				<option <?=set_select('state','mi')?> value="mi">Michigan</option>
				<option <?=set_select('state','mn')?> value="mn">Minnesota</option>
				<option <?=set_select('state','ms')?> value="ms">Mississippi</option>
				<option <?=set_select('state','mo')?> value="mo">Missouri</option>
				<option <?=set_select('state','mt')?> value="mt">Montana</option>
				<option <?=set_select('state','ne')?> value="ne">Nebraska</option>
				<option <?=set_select('state','nv')?> value="nv">Nevada</option>
				<option <?=set_select('state','nh')?> value="nh">New Hampshire</option>
				<option <?=set_select('state','nj')?> value="nj">New Jersey</option>
				<option <?=set_select('state','nm')?> value="nm">New Mexico</option>
				<option <?=set_select('state','ny')?> value="ny">New York</option>
				<option <?=set_select('state','nc')?> value="nc">North Carolina</option>
				<option <?=set_select('state','nd')?> value="nd">North Dakota</option>
				<option <?=set_select('state','oh')?> value="oh">Ohio</option>
				<option <?=set_select('state','ok')?> value="ok">Oklahoma</option>
				<option <?=set_select('state','or')?> value="or">Oregon</option>
				<option <?=set_select('state','pa')?> value="pa">Pennsylvania</option>
				<option <?=set_select('state','ri')?> value="ri">Rhode Island</option>
				<option <?=set_select('state','sc')?> value="sc">South Carolina</option>
				<option <?=set_select('state','sd')?> value="sd">South Dakota</option>
				<option <?=set_select('state','tn')?> value="tn">Tennessee</option>
				<option <?=set_select('state','tx')?> value="tx">Texas</option>
				<option <?=set_select('state','ut')?> value="ut">Utah</option>
				<option <?=set_select('state','vt')?> value="vt">Vermont</option>
				<option <?=set_select('state','va')?> value="va">Virginia</option>
				<option <?=set_select('state','wa')?> value="wa">Washington</option>
				<option <?=set_select('state','wv')?> value="wv">West Virginia</option>
				<option <?=set_select('state','wi')?> value="wi">Wisconsin</option>
				<option <?=set_select('state','wy')?> value="wy">Wyoming</option> -->
        	</select>
			<?php if(!empty($errors['state'])):?>
			<small class="error"><?=$errors['state'];?></small>
			<?php endif;?>

            <select name="country" class="form-control my-1">
				<option value="">--Select Country--</option>
				<option <?=set_select('country','can')?> value="can">Canada</option>
				<option <?=set_select('country','usa')?> value="usa">United States</option>
			</select>
			<?php if(!empty($errors['country'])):?>
			<small class="error"><?=$errors['country'];?></small>
			<?php endif;?>

			<div class="form-control my-1">
				<div class="label-name">Region Image</div>
				<input class="form-control my-1 bg-white" type="file" name="region_img">
				
				<?php if(!empty($errors['region_img'])):?>
					<small class="error"><?=$errors['region_img']?></small>
				<?php endif;?>
			</div>

			<label for="active" class="label-name">Region is active</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('active','1')?> value="1">Yes</option>
				<option <?=set_select('active','0')?> value="0">No</option>
			</select>

			<button class="btn btn-save">Add new Region</button>
			<a href="<?=ROOT?>/admin/regions_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>
		</form>
	</div>

<!-- page view for EDITING a Region -->
<?php elseif($action == 'edit'):?>

	<div class="form-container">
		<form method="post" enctype="multipart/form-data">
		<h3 class="form-heading">Edit Region</h3>

		<?php if(!empty($row)):?>
		
			<label for="region" class="my-1 label-name">Region (abbreviation)</label>
			<input name="region" class="form-control my-1" value="<?=set_value('region', $row['region'])?>" type="text" title="region" placeholder="Region (abbreviation) ">
				<?php if(!empty($errors['region'])):?>
					<small class="error"><?=$errors['region']?></small>
				<?php endif;?>

            <label for="region_name" class="my-1 label-name">Region full name</label>
			<input name="region_name" class="form-control my-1" value="<?=set_value('region_name', $row['region_name'])?>" type="text" title="region_name" placeholder="Region full name">
				<?php if(!empty($errors['region_name'])):?>
					<small class="error"><?=$errors['region_name']?></small>
				<?php endif;?>

			<label for="region_desc" class="my-1 label-name">Region location description</label>
			<input name="region_desc" class="form-control my-1" value="<?=set_value('region_desc', $row['region_desc'])?>" type="text" title="region_desc" placeholder="Region wording to describe area on region page">
				<?php if(!empty($errors['region_desc'])):?>
					<small class="error"><?=$errors['region_desc']?></small>
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

            <label for="country" class="my-1 label-name">Country</label>
			<select name="country" class="form-control my-1">
				<option value="">--Select Country--</option>
				<option <?=set_select('country','can',$row['country'])?> value="CAN">Canada</option>
				<option <?=set_select('country','usa',$row['country'])?> value="USA">United States</option>
			</select>
			<?php if(!empty($errors['country'])):?>
			<small class="error"><?=$errors['country'];?></small>
			<?php endif;?>

			<div class="form-control my-1">
				<div>Region image:</div>
				<img class="edit-img" src="<?=ROOT?>/<?=$row['region_img']?>" >
				<input class="form-control my-1" type="file" name="region_img">
				
				<?php if(!empty($errors['region_img'])):?>
					<small class="error"><?=$errors['region_img']?></small>
				<?php endif;?>
			</div>

			<label for="active" class="label-name">Region is active</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
			</select>

			<button class="btn btn-save">Save Changes</button>
			<a href="<?=ROOT?>/admin/regions_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/regions_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>
		<?php endif;?>

		</form>
	</div>

<!-- page view for DELETING a Region -->
<?php elseif($action == 'delete'):?>

	<div class="form-container">
		<form method="post">
			<h3 class="form-heading">Delete Region</h3>
			<?php if(!empty($row)):?>

			<label class="label-name-big">Region to be deleted - </label>
			<div class="form-control my-1 name-delete" ><?=set_value('region_name',$row['region_name'])?></div>
			<?php if(!empty($errors['region_name'])):?>
				<small class="error"><?=$errors['region_name']?></small>
			<?php endif;?>

			<button class="btn btn-delete">Delete this Region</button>
			<a href="<?=ROOT?>/admin/regions_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/regions_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>
			<?php endif;?>
		</form>
	</div>

<!-- page view for main table of Regions -->
	<?php else:?>

		<?php
			$limit = 20;
			$offset = ($page - 1) * $limit;

			$query = "select * from regions order by state asc limit $limit offset $offset";
			$rows = db_query($query);
		?>
	<div class="table-container">
		<h3 class="admin-table-head">Regions
			<a href="<?=ROOT?>/admin/regions_admin/add">
				<button class="float-end btn admin-btn-add">Add New</button>
			</a>
		</h3>

		<table class="table">
			<tr>
				<th>ID</th>
				<th>Region(abrv.)</th>
				<th>Region full name</th>
				<th>Region Desc</th>
				<th>State</th>
				<th>Country</th>
				<th>Region Image</th>
				<th>Active</th>
				<th>Action</th>
			</tr>

			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<tr>
						<td><?=$row['region_id']?></td>
						<td><?=$row['region']?></td>
						<td><?=$row['region_name']?></td>
						<td><?=$row['region_desc']?></td>
						<td><?=$row['state']?></td>
						<td><?=$row['country']?></td>
						<td><img src="<?=ROOT?>/<?=$row['region_img']?>" class="table-image"></td>
						<td><?=$row['active'] ? 'Yes':'No'?></td>
						<td>
							<a href="<?=ROOT?>/admin/regions_admin/edit/<?=$row['region_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
							</a>
							<a href="<?=ROOT?>/admin/regions_admin/delete/<?=$row['region_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
							</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>

		</table>

		<div class="mx-2">
			<a href="<?=ROOT?>/admin/regions_admin?page=<?=$prev_page?>">
				<button class="btn btn-prev">Prev</button>
			</a>
			<a href="<?=ROOT?>/admin/regions_admin?page=<?=$next_page?>">
				<button class="float-end btn btn-next">Next</button>
			</a>
		</div>
	<?php endif;?>
	</div>
</section>

<?php require page('includes/admin-footer')?>