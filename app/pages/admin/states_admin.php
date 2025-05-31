<?php 
// This is the States page in ADMIN

// functions to ADD a new State
	if($action == 'add')
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
		// -- data validation --
			$errors = [];
			if(empty($_POST['state']))
			{
				$errors['state'] = "State abbreviation is required";
			} 
			else
			if(!preg_match("/^[a-zA-Z0-9 \']+$/", $_POST['state'])){
				$errors['state'] = "State abbreviation can only have letters";
			}

            if(empty($_POST['state_name']))
			{
				$errors['state_name'] = "State full name is required";
			} 
			else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\']+$/", $_POST['state_name'])){
				$errors['state_name'] = "State full name can only have letters & spaces";
			}
		
			if(empty($_POST['country']))
			{
				$errors['country'] = "Country is required";
			}

	// when no errors, ADD State info to database
			if(empty($errors))
			{
				$values = [];
				$values['state'] 	= strtolower(trim($_POST['state']));
				$values['state_name'] 	= ucwords(trim($_POST['state_name']));
				$values['country'] 	= strtolower(trim($_POST['country']));
				$values['active'] 	= trim($_POST['active']);
				$values['page_name'] 	= strtolower(trim($_POST['page_name']));

				$query = "insert into states (state, state_name, country, active, page_name) values (:state, :state_name, :country, :active, :page_name)";
				db_query($query,$values);

				message("State successfully added to database");
				redirect('admin/states_admin');
			}
        }
	} else

// functions to EDIT a State
	if($action == 'edit')
	{
		$query = "select * from states where state_id = :state_id limit 1";
		$row = db_query_one($query,['state_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			//data validation
            if(empty($_POST['state']))
			{
				$errors['state'] = "State is required";
			}

			if(empty($_POST['state_name']))
			{
				$errors['state_name'] = "State full name is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-\']+$/", $_POST['state_name'])){
				$errors['state_name'] = "State full name can only have letters & spaces";
			}

			if(empty($_POST['country']))
			{
				$errors['country'] = "Country is required";
			}
		
			if(empty($errors))
			{
				$values = [];
				$values['state'] 	= strtolower(trim($_POST['state']));
				$values['state_name'] 	= ucwords(trim($_POST['state_name']));
				$values['country'] 	= strtolower(trim($_POST['country']));
				$values['active'] 	= trim($_POST['active']);
				$values['page_name'] 	= strtolower(trim($_POST['page_name']));
				$values['state_id'] = $id;

				$query = "update states set state = :state, state_name = :state_name, country = :country, active = :active, page_name = :page_name where state_id = :state_id limit 1";

				db_query($query,$values);

				message("State information edited successfully");
				redirect('admin/states_admin');
			}
		}
	} else

// functions to DELETE a State
	if($action == 'delete')
	{
		$query = "select * from states where state_id = :state_id limit 1";
		$row = db_query_one($query,['state_id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{
			$errors = [];

			if(empty($errors))
			{
				$values = [];
				$values['state_id'] = $id;

				$query = "delete from states where state_id = :state_id limit 1";
				db_query($query,$values);

				message("State was deleted successfully");
				redirect('admin/states_admin');
			}
		}
	}
?>

<!---------- PAGE VIEWS ---------->
<?php require page('includes/admin-header')?>

<section class="admin-content">

<!-- page view for ADDING a State -->
<?php if($action == 'add'):?>

	<div class="form-container">
		<form method="post" enctype="multipart/form-data" class="form-lg">

			<h3 class="form-heading">Add New State</h3>

			<input name="state" class="form-control my-1" value="<?=set_value('state')?>" type="text" title="state" placeholder="State (abbreviation)">
			<?php if(!empty($errors['state'])):?>
				<small class="error"><?=$errors['state']?></small>
			<?php endif;?>

            <input name="state_name" class="form-control my-1" value="<?=set_value('state_name')?>" type="text" title="state_name" placeholder="State full name">
			<?php if(!empty($errors['state_name'])):?>
				<small class="error"><?=$errors['state_name']?></small>
			<?php endif;?>

            <select name="country" class="form-control my-1">
				<option value="">--Select Country--</option>
				<option <?=set_select('country','can')?> value="can">Canada</option>
				<option <?=set_select('country','usa')?> value="usa">United States</option>
			</select>
			<?php if(!empty($errors['country'])):?>
			<small class="error"><?=$errors['country'];?></small>
			<?php endif;?>

			<label for="active" class="label-name">State is active</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('active','1')?> value="1">Yes</option>
				<option <?=set_select('active','0')?> value="0">No</option>
			</select>

			<input name="page_name" class="form-control my-1" value="<?=set_value('page_name')?>" type="text" title="page_name" placeholder="Name of state landing page">
			<?php if(!empty($errors['page_name'])):?>
				<small class="error"><?=$errors['page_name']?></small>
			<?php endif;?>

			<button class="btn btn-save">Add new State</button>
			<a href="<?=ROOT?>/admin/states_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>
		</form>
	</div>

<!-- page view for EDITING a State -->
<?php elseif($action == 'edit'):?>

	<div class="form-container">
		<form method="post" enctype="multipart/form-data">
		<h3 class="form-heading">Edit State</h3>

		<?php if(!empty($row)):?>
		
			<label for="state" class="my-1 label-name">State (abbreviation)</label>
			<input name="state" class="form-control my-1" value="<?=set_value('state', $row['state'])?>" type="text" title="state" placeholder="State (abbreviation) ">
				<?php if(!empty($errors['state'])):?>
					<small class="error"><?=$errors['state']?></small>
				<?php endif;?>

            <label for="state_name" class="my-1 label-name">State full name</label>
			<input name="state_name" class="form-control my-1" value="<?=set_value('state_name', $row['state_name'])?>" type="text" title="state_name" placeholder="State full name">
				<?php if(!empty($errors['state_name'])):?>
					<small class="error"><?=$errors['state_name']?></small>
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

			<label for="active" class="label-name">Region is active</label>
			<select name="active" class="form-control my-1">
				<option value="">--Select Yes or No--</option>
				<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
			</select>

			<label for="page_name" class="my-1 label-name">Name of state landing page</label>
			<input name="page_name" class="form-control my-1" value="<?=set_value('page_name', $row['page_name'])?>" type="text" title="page_name" placeholder="Name of state landing page">
				<?php if(!empty($errors['page_name'])):?>
					<small class="error"><?=$errors['page_name']?></small>
				<?php endif;?>

			<button class="btn btn-save">Save Changes</button>
			<a href="<?=ROOT?>/admin/states_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/states_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>
		<?php endif;?>

		</form>
	</div>

<!-- page view for DELETING a State -->
<?php elseif($action == 'delete'):?>

	<div class="form-container">
		<form method="post">
			<h3 class="form-heading">Delete State</h3>
			<?php if(!empty($row)):?>

			<label class="label-name-big">State to be deleted - </label>
			<div class="form-control my-1 name-delete" ><?=set_value('state_name',$row['state_name'])?></div>
			<?php if(!empty($errors['state_name'])):?>
				<small class="error"><?=$errors['state_name']?></small>
			<?php endif;?>

			<button class="btn btn-delete">Delete this State</button>
			<a href="<?=ROOT?>/admin/states_admin">
				<button type="button" class="float-end btn btn-back">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/states_admin">
					<button type="button" class="float-end btn btn-back">Back</button>
				</a>
			<?php endif;?>
		</form>
	</div>

<!-- page view for main table of States -->
	<?php else:?>

		<?php
			$limit = 25;
			$offset = ($page - 1) * $limit;

			$query = "select * from states order by country asc, state_name limit $limit offset $offset";
			$rows = db_query($query);
		?>
	<div class="table-container">
		<h3 class="admin-table-head">States
			<a href="<?=ROOT?>/admin/states_admin/add">
				<button class="float-end btn admin-btn-add">Add New</button>
			</a>
		</h3>

		<table class="table">
			<tr>
				<th>ID</th>
				<th>State (abrv.)</th>
				<th>State full name</th>
				<th>Country</th>
				<th>Active</th>
				<th>Landing page</th>
				<th>Action</th>
			</tr>

			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<tr>
						<td><?=$row['state_id']?></td>
						<td><?=$row['state']?></td>
						<td><?=$row['state_name']?></td>
						<td><?=$row['country']?></td>
						<td><?=$row['active'] ? 'Yes':'No'?></td>
						<td><?=$row['page_name']?></td>
						<td>
							<a href="<?=ROOT?>/admin/states_admin/edit/<?=$row['state_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
							</a>
							<a href="<?=ROOT?>/admin/states_admin/delete/<?=$row['state_id']?>">
								<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
							</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>

		</table>

		<div class="mx-2">
			<a href="<?=ROOT?>/admin/states_admin?page=<?=$prev_page?>">
				<button class="btn btn-prev">Prev</button>
			</a>
			<a href="<?=ROOT?>/admin/states_admin?page=<?=$next_page?>">
				<button class="float-end btn btn-next">Next</button>
			</a>
		</div>
	<?php endif;?>
	</div>
</section>

<?php require page('includes/admin-footer')?>