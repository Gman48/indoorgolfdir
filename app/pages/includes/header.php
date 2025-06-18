<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="<?=ROOT?>/assets/images/IGDlogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=APP_NAME?> - <?=ucfirst($URL[0])?></title>
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/styles.css?<?= time();?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Owl-carousel CDN -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha256-kksNxjDRxd/5+jGurZUJd1sdR2v+ClrCl3svESBaJqw=" crossorigin="anonymous" /> -->

    <!-- REMIXICONS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css"> -->

    <!-- Swiper cdn -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"> -->

    <!-- ========= AOS CSS ========= -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/igstyles.css?<?= time();?>">
    
</head>

<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <a href="<?=ROOT?>/home" class="nav-branding"><img src="<?=ROOT?>/assets/images/IGDlogo.png" alt="golfer logo"></a>
            
        </div>

        <div class="menu">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?=ROOT?>/home" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?=ROOT?>/#country" class="nav-link">Canada</a>
                </li>
                <li class="nav-item">
                    <a href="<?=ROOT?>/#country" class="nav-link">USA</a>
                </li>
                <!-- <li class="nav-item">
                    <a href="<?=ROOT?>/blog" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="<?=ROOT?>/about" class="nav-link">About Us</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="<?=ROOT?>/admin" class="nav-link">Admin</a>
                </li> -->
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
</header>