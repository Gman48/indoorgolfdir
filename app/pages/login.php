<?php 

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $errors = [];
    $values = [];
    $values['email'] = trim($_POST['email']);
    $query = "select * from users where email = :email limit 1";
    $row = db_query_one($query,$values);
    
    if(!empty($row)) //means there is a matching record
    {
        if($row['role'] == 'admin')
        {
            if(password_verify($_POST['password'], $row['password']))
            {
                authenticate($row);
                message("login successful");
                redirect('admin/dashboard');  				
            } else {
                message("password does not match");//password not correct
                redirect('login');  
            }
        } else {
            message("user is not an admin, access denied");//email not an admin
            redirect('login');  
        }
    }
    message("email not found in database");//no matching data 
    redirect('login'); 

}

?>

<?php require page('includes/header')?>

<section class="container">
	<div class="form-container">
		<?php if(message()):?>
			<div class="alert"><?=message('',true)?></div>
		<?php endif;?>
			<form action="login" method="POST">
				<center><img class="logo-sm" src="<?=ROOT?>/assets/images/IGdirLogo.png"></center>
				<h2 class="form-heading">Admin Login</h2>
				<input value="<?=set_value('email')?>" class="my-1 form-control" type="email" name="email" placeholder="Email">
				<input value="<?=set_value('password')?>" class="my-1 form-control" type="password" name="password" placeholder="Password">
				<button type="submit" name="loginBtn" class="btn btn-save">Login</button>
			</form>
	</div>
</section>

<?php require page('includes/footer')?>