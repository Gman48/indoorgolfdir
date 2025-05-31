<?php 
// This is the Products (Songs) page in ADMIN

// functions to add a new product (song)
	if($action == 'add')
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$errors = [];
			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			} else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters & spaces";
			}
		
			if(empty($_POST['description']))
			{
				$errors['description'] = "a description is required";
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

	// when no errors, add product (song) info to database
			if(empty($errors))
			{
				$values = [];
				$values['name'] 	= trim($_POST['name']);
				$values['description'] 	= trim($_POST['description']);
				$values['short_desc'] 	= trim($_POST['short_desc']);
				$values['image'] 	= $destination_image;
				$values['image_2'] 	= $destination_imageSecond;
				$values['price'] 	= trim($_POST['price']);
				$values['size'] 	= trim($_POST['size']);
				$values['slug'] 	= str_to_url($values['name']);

				$query = "insert into products (name,description,short_desc,image,image_2,price,size,slug) values (:name,:description,:short_desc,:image,:image_2,:price,:size,:slug)";
				db_query($query,$values);

				message("product created successfully");
				redirect('admin/products');
			}
		}
	} else

// functions to edit a product (song)
	if($action == 'edit')
	{
		$query = "select * from products where id = :id limit 1";
		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters & spaces";
			}

			if(empty($_POST['description']))
			{
				$errors['description'] = "a description is required";
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
					if(file_exists($row['image_2']))
					{
						unlink($row['image_2']);
					}

				}else{
					$errors['imageSecond'] = "Second image not valid. allowed types are ". implode(",", $allowed);
				}
			} 

			if(empty($errors))
			{
				$values = [];
				$values['name'] 	= trim($_POST['name']);
				$values['view_order'] 	= trim($_POST['view_order']);
				$values['description'] 	= trim($_POST['description']);
				$values['short_desc'] 	= trim($_POST['short_desc']);
				$values['price'] 	= trim($_POST['price']);
				$values['size'] 	= trim($_POST['size']);
				$values['featured'] 	= trim($_POST['featured']);
				$values['active'] 	= trim($_POST['active']);
				$values['slug'] 	= str_to_url($values['name']);
				$values['id'] 	= $id;

				$query = "update products set name = :name, view_order = :view_order, description = :description, short_desc = :short_desc, price = :price, size = :size, featured = :featured, active = :active, slug = :slug";

				if(!empty($destination_image))
				{
					$query .= ", image = :image";
					$values['image'] 	= $destination_image;
				} 

				if(!empty($destination_imageSecond))
				{
					$query .= ", image_2 = :image_2";
					$values['image_2'] 	= $destination_imageSecond;
				}

				$query .= " where id = :id limit 1";
				db_query($query,$values);

				message("product edited successfully");
				redirect('admin/products');
			}
		}
	} else

// functions to edit a product (song)
	if($action == 'delete')
	{
		$query = "select * from products where id = :id limit 1";
		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			if(empty($errors))
			{
				$values = [];
				$values['id'] = $id;

				$query = "delete from products where id = :id limit 1";
				db_query($query,$values);

				//delete image
				if(file_exists($row['image']))
				{
					unlink($row['image']);
				}
				//delete image2
				if(file_exists($row['image_2']))
				{
					unlink($row['image_2']);
				}
				message("product deleted successfully");
				redirect('admin/products');
			}
		}
	}
?>

<?php require page('includes/admin-header')?>

<!-- PAGE VIEWS -->
<section class="admin-content" style="min-height: 200px;">

<!-- page view for adding a product (song) -->
<?php if($action == 'add'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post" enctype="multipart/form-data">

			<h3>Add New Product</h3>

			<input name="name" class="form-control my-1" value="<?=set_value('name')?>" type="text" title="name" placeholder="Product name">
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>
			
			<label>Description:</label>
			<textarea rows="10" class="form-control my-1" name="description"><?=set_value('description')?></textarea>
			<?php if(!empty($errors['description'])):?>
				<small class="error"><?=$errors['description']?></small>
			<?php endif;?>

			<label>Short description:</label>
			<textarea rows="5" class="form-control my-1" name="short_desc"><?=set_value('short_desc')?></textarea>

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

			<input name="price" class="form-control my-1" value="<?=set_value('price')?>" type="text" title="price" placeholder="Product price">
			<?php if(!empty($errors['price'])):?>
				<small class="error"><?=$errors['price']?></small>
			<?php endif;?>

			<input name="size" class="form-control my-1" value="<?=set_value('size')?>" type="text" title="size" placeholder="Product standard size">
			<?php if(!empty($errors['size'])):?>
				<small class="error"><?=$errors['size']?></small>
			<?php endif;?>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/products">
				<button type="button" class="float-end btn">Back</button>
			</a>
		</form>
	</div>

<!-- page view for editing a product (song) -->
<?php elseif($action == 'edit'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post" enctype="multipart/form-data">
		<h3>Edit Product</h3>

		<?php if(!empty($row)):?>
		
			<label for="name" class="my-1">Product name:</label>
			<input name="name" class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" title="name" placeholder="Product name">
				<?php if(!empty($errors['name'])):?>
					<small class="error"><?=$errors['name']?></small>
				<?php endif;?>

			<label for="view_order" class="my-1">Product view order in gallery:</label>
			<input name="view_order" class="form-control my-1" value="<?=set_value('view_order',$row['view_order'])?>" type="text" title="view_order" placeholder="Product view order in gallery">
				<?php if(!empty($errors['view_order'])):?>
					<small class="error"><?=$errors['view_order']?></small>
				<?php endif;?>
	
			<label>Description:</label>
			<textarea rows="10" class="form-control my-1" name="description"><?=set_value('description',$row['description'])?></textarea>
				<?php if(!empty($errors['description'])):?>
					<small class="error"><?=$errors['description']?></small>
				<?php endif;?>

			<label>Short description:</label>
			<textarea rows="5" class="form-control my-1" name="short_desc"><?=set_value('short_desc',$row['short_desc'])?></textarea>
			
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
				<img src="<?=ROOT?>/<?=$row['image_2']?>" style="width:200px;height: 200px;object-fit: cover;">
				<input class="form-control my-1" type="file" name="imageSecond">
				
				<?php if(!empty($errors['imageSecond'])):?>
					<small class="error"><?=$errors['imageSecond']?></small>
				<?php endif;?>
			</div>

			<label for="price" class="my-1">Product price:</label>
			<input name="price" class="form-control my-1" value="<?=set_value('price',$row['price'])?>" type="text" title="price" placeholder="Product price">
				<?php if(!empty($errors['price'])):?>
					<small class="error"><?=$errors['price']?></small>
				<?php endif;?>

			<label for="size" class="my-1">Product size:</label>
			<input name="size" class="form-control my-1" value="<?=set_value('size',$row['size'])?>" type="text" title="size" placeholder="Product size">
			<?php if(!empty($errors['size'])):?>
				<small class="error"><?=$errors['size']?></small>
			<?php endif;?>

			<label for="featured" class="my-1">Featured product:</label>
			<select name="featured" class="form-control my-1">
				<option value="">--Select featured--</option>
				<option <?=set_select('featured','1',$row['featured'])?> value="1">Yes</option>
				<option <?=set_select('featured','0',$row['featured'])?> value="0">No</option>
			</select>

			<label for="active" class="my-1">Active product:</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select active--</option>
				<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
			</select>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/products">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/products">
					<button type="button" class="float-end btn">Back</button>
				</a>
		<?php endif;?>

		</form>
	</div>

<!-- page view for deleting a product (song) -->
<?php elseif($action == 'delete'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post">
			<h3>Delete Product</h3>

			<?php if(!empty($row)):?>

			<div class="form-control my-1" ><?=set_value('name',$row['name'])?></div>
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

			<button class="btn bg-red">Delete</button>
			<a href="<?=ROOT?>/admin/products">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/products">
					<button type="button" class="float-end btn">Back</button>
				</a>
			<?php endif;?>

		</form>
	</div>

<!-- page view for main table of Products -->
	<?php else:?>

		<?php
			$limit = 20;
			$offset = ($page - 1) * $limit;

			$query = "select * from products order by id asc limit $limit offset $offset";
			$rows = db_query($query);
		?>
		<h3>Products
			<a href="<?=ROOT?>/admin/products/add">
				<button class="float-end btn bg-purple">Add New</button>
			</a>
		</h3>

		<table class="table">
			
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>View order</th>
				<th>Description</th>
				<th>Short Description</th>
				<th>Image</th>
				<th> Second Image</th>
				<th>Price</th>
				<th>Size</th>
				<th>Featured</th>
				<th>Active</th>
				<th>Action</th>
			</tr>

			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<tr>
						<td><?=$row['id']?></td>
						<td><?=$row['name']?></td>
						<td><?=$row['view_order']?></td>
						<td><?=$row['description']?></td>
						<td><?=$row['short_desc']?></td>
						<td><img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;"></td>
						<td><img src="<?=ROOT?>/<?=$row['image_2']?>" style="width:100px;height: 100px;object-fit: cover;"></td>
						<td><?=$row['price']?></td>
						<td><?=$row['size']?></td>
						<td><?=$row['featured'] ? 'Yes':'No'?></td>
						<td><?=$row['active'] ? 'Yes':'No'?></td>
						<td>
							<a href="<?=ROOT?>/admin/products/edit/<?=$row['id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
							</a>
							<a href="<?=ROOT?>/admin/products/delete/<?=$row['id']?>">
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