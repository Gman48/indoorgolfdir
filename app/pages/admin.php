<?php
// check if person trying to access the page is an admin

/*if(!is_admin())
{
    message("only admins can access the admin area");
    redirect('login');
}*/
// if person is admin then carry on

//store details of page user wanted from url entered or page they are on
$section = $URL[1] ?? "dashboard";
$action = $URL[2] ?? null;
$id = $URL[3] ?? null;

switch ($section)
{
    case 'dashboard':
        require page('admin/dashboard');
        break;

    case 'facilities_admin':
        require page('admin/facilities_admin');
        break;

    case 'regions_admin':
        require page('admin/regions_admin');
        break;

    case 'states_admin':
        require page('admin/states_admin');
        break;

    case 'users':
        require page('admin/users');
        break;

    case 'aboutUs':
        require page('admin/aboutUs');
        break;
    
    default:
        require page('admin/404');
        break;
}


