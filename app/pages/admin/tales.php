<?php 
//functions to add a tale (artist)
if($action == 'add')
{
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$errors = [];
		//data validation
		if(empty($_POST['name']))
		{
			$errors['name'] = "a customer's name is required";
		}

		if(empty($_POST['tale']))
		{
			$errors['tale'] = "a tasty tale is required";
		}

		// validate image
		if(!empty($_FILES['image']['name']))
		{
			$folder = "uploads/";
			if(!file_exists($folder))
			{
				mkdir($folder,0777,true);
				file_put_contents($folder."index.php", ""); // makes empty index folder for security purposes so hackers can't access files
			}

			$allowed = ['image/jpeg','image/png'];

			if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
	// when image entered and is allowed format, then can upload into uploads file
			{
				$destination = $folder. $_FILES['image']['name'];

				move_uploaded_file($_FILES['image']['tmp_name'], $destination);

			} else {
				$errors['name'] = "image not valid. allowed types are ". implode(",", $allowed);
			}

		}else {
			$errors['name'] = "an image is required";
		}

//add tale (artist) to database when there are no errors
		if(empty($errors))
		{
			$values = [];
			$values['name'] = trim($_POST['name']);
			$values['tale'] = trim($_POST['tale']);
			$values['image'] = $destination;
			$values['date'] = date("Y-m-d H:i:s");

			$query = "insert into tales (name, tale, image,date) values (:name,:tale, :image,:date)";
			db_query($query,$values);

			message("Tasty tale created successfully");
			redirect('admin/tales');
		}
	}
} else

//functions to edit a tale (artist)
	if($action == 'edit')
	{
		$query = "select * from tales where id = :id limit 1";
		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];
			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			} 

			if(empty($_POST['tale']))
			{
			$errors['tale'] = "a tasty tale is required";
			}

 			// validate image
			if(!empty($_FILES['image']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					$destination = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination);
					
					//delete old file
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}

				} else {
					$errors['name'] = "image not valid. allowed types are ". implode(",", $allowed);
				}
			}

	// edit database when no errors found
			if(empty($errors))
			{
				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['tale'] = trim($_POST['tale']);
				$values['active'] = trim($_POST['active']);
				$values['id'] = $id;

				$query = "update tales set name = :name, tale = :tale, active = :active where id = :id limit 1";
				
				if(!empty($destination)){
					$query = "update tales set name = :name,tale = :tale, active = :active, image = :image where id = :id limit 1";
					$values['image'] = $destination;
				}

				db_query($query,$values);

				message("Tasty tale edited successfully");
				redirect('admin/tales');
			}
		}
	}else

//functions to delete an artist
	if($action == 'delete')
	{
		$query = "select * from tales where id = :id limit 1";
		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];
			if(empty($errors))
			{
				$values = [];
				$values['id'] = $id;

				$query = "delete from tales where id = :id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}
				message("Tasty tale was deleted successfully");
				redirect('admin/tales');
			}
		}
	}
?>

<?php require page('includes/admin-header')?>

<!-- PAGE VIEWS -->
<section class="admin-content" style="min-height: 200px;">

<!-- view for adding tales (artist) -->
<?php if($action == 'add'):?>
	
	<div style="max-width: 500px;margin: auto;">
		<form method="post" enctype="multipart/form-data">

			<h3>Add New Tasty Tale</h3>

			<label>Customer name</label>
			<input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Customer name">
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

			<label>Customer Image:</label>
			<input class="form-control my-1" type="file" name="image">
			<?php if(!empty($errors['image'])):?>
				<small class="error"><?=$errors['image']?></small>
			<?php endif;?>

			<label>Tasty Tale:</label>
			<textarea rows="10" class="form-control my-1" name="tale"><?=set_value('tale')?></textarea>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/tales">
				<button type="button" class="float-end btn">Back</button>
			</a>
		</form>
	</div>

<!-- view for editing tales (artist) -->
<?php elseif($action == 'edit'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post" enctype="multipart/form-data">
			<h3>Edit Tasty Tale</h3>

			<?php if(!empty($row)):?>

			<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="Customer name">
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

			<img src="<?=ROOT?>/<?=$row['image']?>" style="width:200px;height: 200px;object-fit: cover;">

			<div>Artist Image:</div>
			<input class="form-control my-1" type="file" name="image">

			<label>Tasty Tale:</label>
			<textarea rows="10" class="form-control my-1" name="tale"><?=set_value('tale',$row['tale'])?></textarea>

			<label for="active" class="my-1">Active:</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select active--</option>
				<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
			</select>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/tales">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/tales">
					<button type="button" class="float-end btn">Back</button>
				</a>
			<?php endif;?>
		</form>
	</div>

<!-- view for deleting a tasty tale (artist) -->
<?php elseif($action == 'delete'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post">
			<h3>Delete Tasty Tale</h3>

			<?php if(!empty($row)):?>

			<div class="form-control my-1" ><?=set_value('name',$row['name'])?></div>
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

			<label>Tasty Tale:</label>
			<textarea rows="10" class="form-control my-1" name="tale"><?=set_value('tale',$row['tale'])?></textarea>

			<button class="btn bg-red">Delete</button>
			<a href="<?=ROOT?>/admin/tales">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/tales">
					<button type="button" class="float-end btn">Back</button>
				</a>
			<?php endif;?>

		</form>
	</div>

<?php else:?>

<!-- view of all tasty tales (artists) in main artist page -->
<?php 
	$query = "select * from tales order by id asc limit 20";
	$rows = db_query($query);
?>
	<h3>Tasty Tales
		<a href="<?=ROOT?>/admin/tales/add">
			<button class="float-end btn bg-purple">Add New</button>
		</a>
	</h3>

	<table class="table">
		<tr>
			<th>ID</th>
			<th>Customer</th>
			<th>Image</th>
			<th>Tasty Tale</th>
			<th>Active</th>
			<th>Action</th>
		</tr>
<!-- populate table with tasty tales (artists) in database -->
	<?php if(!empty($rows)):?>
		<?php foreach($rows as $row):?>
			<tr>
				<td><?=$row['id']?></td>
				<td><?=$row['name']?></td>
				<td>
					<a href="<?=ROOT?>/artist/<?=$row['id']?>">
					<img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;">
					</a>
				</td>
				<td><?=$row['tale']?></td>
				<td><?=$row['active'] ? 'Yes':'No'?></td>
				<td>
					<a href="<?=ROOT?>/admin/tales/edit/<?=$row['id']?>">
						<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
					</a>
					<a href="<?=ROOT?>/admin/tales/delete/<?=$row['id']?>">
						<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
					</a>
				</td>
			</tr>
		<?php endforeach;?>
	<?php endif;?>

	</table>
<?php endif;?>

</section>

<?php require page('includes/admin-footer')?>