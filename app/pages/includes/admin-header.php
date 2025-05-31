<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=APP_NAME?> - Admin</title>
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/styles.css?<?= time();?>">
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/igstyles.css?<?= time();?>">

    <script src="<?=ROOT?>/assets/js/index.js?<?= time();?>"></script>
    <script type="text/javascript" src="<?=ROOT?>/assets/js/script.js?<?= time();?>"></script>
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <a href="<?=ROOT?>" class="nav-branding">IG.dir</a>
            <img src="<?=ROOT?>/assets/images/golfer_white.png" alt="golfer logo">
        </div>
        <div class="main-title">ADMIN AREA</div>
        <div class="nav-menu menu">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/admin">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/admin/facilities_admin">Facilities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/admin/states_admin">States</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/admin/regions_admin">Regions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=ROOT?>/admin/users">Users</a>
                </li>
                <div class="nav-item dropdown-wrap"> <!-- this is drop down menu -->
                    <a class="nav-link" href="#">Hi, <?=user('username')?></a> 
                    <div class="admin-dropdown">
                        <!-- <div class="nav-item"><a href="<?=ROOT?>/profile" class="nav-link">Profile</a></div> -->
                        <div class="nav-item"><a href="<?=ROOT?>" class="nav-link">Website</a></div>
                        <div class="nav-item"><a href="<?=ROOT?>/logout" class="nav-link">Logout</a></div>
                    </div>
                </div>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </header>

<!-- print any messages if they exist -->
<?php if(message()):?>

<div class="alert"><?=message('', true)?></div>

<?php endif;?>