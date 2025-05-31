<?php 
//functions for adding event (category)
if($action == 'add')
{
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$errors = [];
		//data validation
		if(empty($_POST['name']))
		{
			$errors['name'] = "a name is required";
		} /*else
		if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name']))
		{
			$errors['name'] = "a name can only have letters & spaces";
		}*/

	//add event if no errors
		if(empty($errors))
		{
			$values = [];
			$values['name'] = trim($_POST['name']);
			$values['date'] = trim($_POST['date']);
			$values['time'] = trim($_POST['time']);
			$values['location'] = trim($_POST['location']);
			$values['address'] = trim($_POST['address']);
			$values['details'] = trim($_POST['details']);

			$query = "insert into events (name, date, time, location, address, details) values (:name, :date, :time, :location, :address, :details)";
			db_query($query,$values);

			message("Event created successfully");
			redirect('admin/events');
		}
	}
} else

//functions to edit an event (category)
if($action == 'edit')
{
	$query = "select * from events where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
	{
		$errors = [];
		//data validation
		if(empty($_POST['name']))
		{
			$errors['name'] = "a name is required";
		} /*else
		if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name']))
		{
			$errors['name'] = "a name can only have letters with no spaces";
		}*/
	//edit event (category) if no errors
		if(empty($errors))
		{
			$values = [];
			$values['name'] = trim($_POST['name']);
			$values['date'] = trim($_POST['date']);
			$values['time'] = trim($_POST['time']);
			$values['location'] = trim($_POST['location']);
			$values['address'] = trim($_POST['address']);
			$values['details'] = trim($_POST['details']);
			$values['active'] = trim($_POST['active']);
			$values['id'] 		= $id;

			$query = "update events set name = :name, date = :date, time = :time, location = :location, address = :address, details = :details, active = :active where id = :id limit 1";
			db_query($query,$values);

			message("Event edited successfully");
			redirect('admin/events');
		}
	}
} else

//functions to delete an event (category)
if($action == 'delete')
{
	$query = "select * from events where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
	{
		$errors = [];
	//delete event (category) if no errors
		if(empty($errors))
		{
			$values = [];
			$values['id'] = $id;

			$query = "delete from events where id = :id limit 1";
			db_query($query,$values);

			message("Event deleted successfully");
			redirect('admin/events');
		}
	}
}

?>

<!-- PAGE VIEWS -->
<?php require page('includes/admin-header')?>

<section class="admin-content" style="min-height: 200px;">

<!-- view for adding new Event (category) -->
<?php if($action == 'add'):?>
	
	<div style="max-width: 500px;margin: auto;">
		<form method="post">
			<h3>Add New Event</h3>

			<label>Event Name:</label>
			<input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Event name">
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

			<label>Event Date:</label>
			<input class="form-control my-1" value="<?=set_value('date')?>" type="text" name="date" placeholder="Event date">
			<?php if(!empty($errors['date'])):?>
				<small class="error"><?=$errors['date']?></small>
			<?php endif;?>

			<label>Event Time:</label>
			<input class="form-control my-1" value="<?=set_value('time')?>" type="text" name="time" placeholder="Time of the event">
			<?php if(!empty($errors['time'])):?>
				<small class="error"><?=$errors['time']?></small>
			<?php endif;?>

			<label>Event location:</label>
			<input class="form-control my-1" value="<?=set_value('location')?>" type="text" name="location" placeholder="Name of event location">
			<?php if(!empty($errors['location'])):?>
				<small class="error"><?=$errors['location']?></small>
			<?php endif;?>

			<label>Address of location:</label>
			<input class="form-control my-1" value="<?=set_value('address')?>" type="text" name="address" placeholder="Event location address">
			<?php if(!empty($errors['address'])):?>
				<small class="error"><?=$errors['address']?></small>
			<?php endif;?>

			<label>Event details:</label>
			<textarea rows="10" class="form-control my-1" name="details"><?=set_value('details')?></textarea>
			<?php if(!empty($errors['details'])):?>
				<small class="error"><?=$errors['details']?></small>
			<?php endif;?>

			

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/events">
				<button type="button" class="float-end btn">Back</button>
			</a>
		</form>
	</div>

<!-- view for editing category -->
<?php elseif($action == 'edit'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post">
			<h3>Edit Event</h3>

			<?php if(!empty($row)):?>

				<label>Event Name:</label>
				<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="Event name">
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

				<label>Event Date:</label>
				<input class="form-control my-1" value="<?=set_value('date',$row['date'])?>" type="text" name="date" placeholder="Event date">
			<?php if(!empty($errors['date'])):?>
				<small class="error"><?=$errors['date']?></small>
			<?php endif;?>

				<label>Event Time:</label>
					<input class="form-control my-1" value="<?=set_value('time',$row['time'])?>" type="text" name="time" placeholder="Event time">
			<?php if(!empty($errors['time'])):?>
				<small class="error"><?=$errors['time']?></small>
			<?php endif;?>

				<label>Event location:</label>
				<input class="form-control my-1" value="<?=set_value('location',$row['location'])?>" type="text" name="location" placeholder="Event location">
			<?php if(!empty($errors['location'])):?>
				<small class="error"><?=$errors['location']?></small>
			<?php endif;?>

				<label>Event location address:</label>
				<input class="form-control my-1" value="<?=set_value('location',$row['address'])?>" type="text" name="address" placeholder="Event location address">
			<?php if(!empty($errors['address'])):?>
				<small class="error"><?=$errors['address']?></small>
			<?php endif;?>

			<label>Event details:</label>
			<textarea rows="10" class="form-control my-1" name="details"> <?=esc($row['details'])?></textarea>
			<?php if(!empty($errors['details'])):?>
				<small class="error"><?=$errors['details']?></small>
			<?php endif;?>

			<select name="active" class="form-control my-1">
				<option value="">--Select if Active--</option>
				<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
				<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
			</select>

			<button class="btn bg-orange">Save</button>
			<a href="<?=ROOT?>/admin/events">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/events">
					<button type="button" class="float-end btn">Back</button>
				</a>
			<?php endif;?>
		</form>
	</div>

<!-- view for deleting event (category) -->
<?php elseif($action == 'delete'):?>

	<div style="max-width: 500px;margin: auto;">
		<form method="post">
			<h3>Delete Event</h3>

			<?php if(!empty($row)):?>

			<div class="form-control my-1 bg-white"><?=set_value('name',$row['name'])?></div>
			<?php if(!empty($errors['name'])):?>
				<small class="error"><?=$errors['name']?></small>
			<?php endif;?>

			<button class="btn bg-red">Delete</button>
			<a href="<?=ROOT?>/admin/events">
				<button type="button" class="float-end btn">Back</button>
			</a>

			<?php else:?>
				<div class="alert">That record was not found</div>
				<a href="<?=ROOT?>/admin/events">
					<button type="button" class="float-end btn">Back</button>
				</a>
			<?php endif;?>
		</form>
	</div>

<?php else:?>

<!-- view for Events (category) home page -->
<!-- populate the table with max 20 events (categories) -->
<?php 
	$query = "select * from events order by id asc limit 20";
	$rows = db_query($query);
?>
<h3>Events
	<a href="<?=ROOT?>/admin/events/add">
		<button class="float-end btn bg-purple">Add New</button>
	</a>
</h3>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Event Name</th>
		<th>Event Date</th>
		<th>Event Time</th>
		<th>Event Location</th>
		<th>Event Address</th>
		<th>Event Details</th>
		<th>Active</th>
		<th>Action</th>
	</tr>

<!-- populate table if items exist -->
	<?php if(!empty($rows)):?>
		<?php foreach($rows as $row):?>
			<tr>
				<td><?=$row['id']?></td>
				<td><?=$row['name']?></td>
				<td><?=$row['date']?></td>
				<td><?=$row['time']?></td>
				<td><?=$row['location']?></td>
				<td><?=$row['address']?></td>
				<td><?=$row['details']?></td>
				<td><?=$row['active'] ? 'Yes':'No'?></td>
				<td>
					<a href="<?=ROOT?>/admin/events/edit/<?=$row['id']?>">
						<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
					</a>
					<a href="<?=ROOT?>/admin/events/delete/<?=$row['id']?>">
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