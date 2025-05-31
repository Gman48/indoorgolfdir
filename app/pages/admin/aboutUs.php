<?php 
// This is the About Us page in ADMIN

// functions to add a new person's bio
	if($action == 'add')
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$errors = [];
			//data validation
			if(empty($_POST['person']))
			{
				$errors['person'] = "a person is required";
			} else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/", $_POST['person'])){
				$errors['person'] = "a person can only have letters & spaces";
			}
		
			if(empty($_POST['bio']))
			{
				$errors['bio'] = "a bio is required";
			}
		
			//image
			if(!empty($_FILES['image']['name'])) //'image' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", ""); // for security purposes puts an empty index file in folder so can't access any other files in the folder.
				}

				$allowed = ['image/jpeg','image/png'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					$destination_image = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);

				}else{
					$errors['image'] = "image not valid. allowed types are ". implode(",", $allowed);
				}
			}else {
				$errors['image'] = "an image is required";
			}

			//imageSecond
			if(!empty($_FILES['imageSecond']['name'])) //'imageSecond' is the name tag from form and 'name' is the name of the image file.
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png'];
				if($_FILES['imageSecond']['error'] == 0 && in_array($_FILES['imageSecond']['type'], $allowed))
				{
					$destination_imageSecond = $folder. $_FILES['imageSecond']['name'];

					move_uploaded_file($_FILES['imageSecond']['tmp_name'], $destination_imageSecond);

				}else{
					$errors['imageSecond'] = "Second image not valid. allowed types are ". implode(",", $allowed);
				}
			}else {
				$errors['imageSecond'] = "a second image is required";
			}

	// when no errors, add person to database
			if(empty($errors))
			{
				$values = [];
				$values['person'] 	= trim($_POST['person']);
				$values['image'] 	= $destination_image;
				$values['image2'] 	= $destination_imageSecond;
				$values['bio'] 	= trim($_POST['bio']);
				$values['slug'] 	= str_to_url($values['person']);

				$query = "insert into about (person,image,image2,bio,slug) values (:person,:image,:image2,:bio,:slug)";
				db_query($query,$values);

				message("person and bio created successfully");
				redirect('admin/aboutUs');
			}
		}
	} else

// functions to edit a person's bio
	if($action == 'edit')
	{
		$query = "select * from about where id = :id limit 1";
		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			//data validation
			if(empty($_POST['person']))
			{
				$errors['person'] = "a person's name is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/", $_POST['person'])){
				$errors['person'] = "a person can only have letters & spaces";
			}

			if(empty($_POST['bio']))
			{
				$errors['bio'] = "a bio is required";
			}

 			//image
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
					$destination_image = $folder. $_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);
					
					//delete old file
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}

				}else{
					$errors['image'] = "image not valid. allowed types are ". implode(",", $allowed);
				}
			} 

			//image2
			if(!empty($_FILES['imageSecond']['name']))
			{
				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png'];
				if($_FILES['imageSecond']['error'] == 0 && in_array($_FILES['imageSecond']['type'], $allowed))
				{
					$destination_imageSecond = $folder. $_FILES['imageSecond']['name'];
					move_uploaded_file($_FILES['imageSecond']['tmp_name'], $destination_imageSecond);
					
					//delete old file
					if(file_exists($row['image2']))
					{
						unlink($row['image2']);
					}

				}else{
					$errors['imageSecond'] = "Second image not valid. allowed types are ". implode(",", $allowed);
				}
			} 

			if(empty($errors))
			{
				$values = [];
				$values['person'] 	= trim($_POST['person']);
				$values['bio'] 	= trim($_POST['bio']);
				$values['active'] 	= trim($_POST['active']);
				$values['slug'] 	= str_to_url($values['person']);
				$values['id'] 	= $id;

				$query = "update about set person = :person, bio = :bio, active = :active, slug = :slug";

				if(!empty($destination_image))
				{
					$query .= ", image = :image";
					$values['image'] 	= $destination_image;
				} 

				if(!empty($destination_imageSecond))
				{
					$query .= ", image2 = :image2";
					$values['image2'] 	= $destination_imageSecond;
				}

				$query .= " where id = :id limit 1";
				db_query($query,$values);

				message("Person's bio edited successfully");
				redirect('admin/aboutUs');
			}
		}
	} else

// functions to delete a person's bio
	if($action == 'delete')
	{
		$query = "select * from about where id = :id limit 1";
		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			if(empty($errors))
			{
				$values = [];
				$values['id'] = $id;

				$query = "delete from about where id = :id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}
				//delete image2
				if(file_exists($row['image2']))
				{
					unlink($row['image2']);
				}
				message("person's bio deleted successfully");
				redirect('admin/aboutUs');
			}
		}
	}
?>

<?php require page('includes/admin-header')?>

<!-- PAGE VIEWS -->
<section class="admin-content" style="min-height: 200px;">

<!-- page view for adding a new person's bio -->
<?php if($action == 'add'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post" enctype="multipart/form-data">

			<h3>Add New Person Bio</h3>

			<input name="person" class="form-control my-1" value="<?=set_value('person')?>" type="text" title="person" placeholder="Person's Name">
			<?php if(!empty($errors['person'])):?>
				<small class="error"><?=$errors['person']?></small>
			<?php endif;?>

			<div class="form-control my-1">
				<div>Image:</div>
				<input class="form-control my-1 bg-white" type="file" name="image">
				
				<?php if(!empty($errors['image'])):?>
					<small class="error"><?=$errors['image']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div>Image 2:</div>
				<input class="form-control my-1 bg-white" type="file" name="imageSecond">
				
				<?php if(!empty($errors['imageSecond'])):?>
					<small class="error"><?=$errors['imageSecond']?></small>
				<?php endif;?>
			</div>

			<label>Bio:</label>
			<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio')?></textarea>
			<?php if(!empty($errors['bio'])):?>
				<small class="error"><?=$errors['bio']?></small>
			<?php endif;?>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/aboutUs">
				<button type="button" class="float-end btn">Back</button>
			</a>
		</form>
	</div>

<!-- page view for editing a person's bio -->
<?php elseif($action == 'edit'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post" enctype="multipart/form-data">
		<h3>Edit Person's Bio</h3>

		<?php if(!empty($row)):?>
		
			<label for="person" class="my-1">Person:</label>
			<input name="person" class="form-control my-1" value="<?=set_value('person',$row['person'])?>" type="text" title="person" placeholder="Person name">
				<?php if(!empty($errors['person'])):?>
					<small class="error"><?=$errors['person']?></small>
				<?php endif;?>
			
			<div class="form-control my-1">
				<div>Image:</div>
				<img src="<?=ROOT?>/<?=$row['image']?>" style="width:200px;height: 200px;object-fit: cover;">
				<input class="form-control my-1" type="file" name="image">
				
				<?php if(!empty($errors['image'])):?>
					<small class="error"><?=$errors['image']?></small>
				<?php endif;?>
			</div>

			<div class="form-control my-1">
				<div>Image 2:</div>
				<img src="<?=ROOT?>/<?=$row['image2']?>" style="width:200px;height: 200px;object-fit: cover;">
				<input class="form-control my-1" type="file" name="imageSecond">
				
				<?php if(!empty($errors['imageSecond'])):?>
					<small class="error"><?=$errors['imageSecond']?></small>
				<?php endif;?>
			</div>

			<label>Bio:</label>
			<textarea rows="10" class="form-control my-1" name="bio"><?=set_value('bio',$row['bio'])?></textarea>
				<?php if(!empty($errors['bio'])):?>
					<small class="error"><?=$errors['bio']?></small>
				<?php endif;?>

			<label for="active" class="my-1">Active person:</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select active--</option>
				<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
			</select>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/aboutUs">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/aboutUs">
					<button type="button" class="float-end btn">Back</button>
				</a>
		<?php endif;?>

		</form>
	</div>

<!-- page view for deleting a person's bio -->
<?php elseif($action == 'delete'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post">
			<h3>Delete Person' Bio</h3>

			<?php if(!empty($row)):?>

			<div class="form-control my-1" ><?=set_value('person',$row['person'])?></div>
			<?php if(!empty($errors['person'])):?>
				<small class="error"><?=$errors['person']?></small>
			<?php endif;?>

			<button class="btn bg-red">Delete</button>
			<a href="<?=ROOT?>/admin/aboutUs">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/aboutUs">
					<button type="button" class="float-end btn">Back</button>
				</a>
			<?php endif;?>

		</form>
	</div>

<!-- page view for About Us page with table of bios -->
	<?php else:?>

		<?php
			$limit = 20;
			$offset = ($page - 1) * $limit;

			$query = "select * from about order by id asc limit $limit offset $offset";
			$rows = db_query($query);
		?>
		<h3>About Us
			<a href="<?=ROOT?>/admin/aboutUs/add">
				<button class="float-end btn bg-purple">Add New</button>
			</a>
		</h3>

		<table class="table">
			
			<tr>
				<th>ID</th>
				<th>Person</th>
				<th>Image</th>
				<th>Second Image</th>
				<th>Bio</th>
				<th>Active</th>
				<th>Action</th>
			</tr>

			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<tr>
						<td><?=$row['id']?></td>
						<td><?=$row['person']?></td>
						<td><img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;"></td>
						<td><img src="<?=ROOT?>/<?=$row['image2']?>" style="width:100px;height: 100px;object-fit: cover;"></td>
						<td><?=$row['bio']?></td>
						<td><?=$row['active'] ? 'Yes':'No'?></td>
						<td>
							<a href="<?=ROOT?>/admin/aboutUs/edit/<?=$row['id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
							</a>
							<a href="<?=ROOT?>/admin/aboutUs/delete/<?=$row['id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
							</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>

		</table>
	<?php endif;?>

<div class="mx-2">
	<a href="<?=ROOT?>/admin/products?page=<?=$prev_page?>">
		<button class="btn bg-orange">Prev</button>
	</a>
	<a href="<?=ROOT?>/admin/products?page=<?=$next_page?>">
		<button class="float-end btn bg-orange">Next</button>
	</a>
</div>


</section>

<?php require page('includes/admin-footer')?>