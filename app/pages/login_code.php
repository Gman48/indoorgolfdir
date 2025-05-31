<?php 
session_start();
require_once "init.php";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $errors = [];
    $values = [];
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
    message("email not valid");//no matching data 
    redirect('login'); 

}

?>

<?php require page('includes/header')?>