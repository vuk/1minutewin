<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= base_url(); ?>application/assets/css/foundation.css">
    <link rel="stylesheet" href="<?= base_url(); ?>application/bower_components/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?= base_url(); ?>application/assets/css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,400,600,700" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body>
<nav class="main">
    <div class="row collapse">
        <div class="columns large-12 small-12">
            <div class="title-bar" data-responsive-toggle="example-animated-menu" data-hide-for="medium">
                <button class="menu-icon" type="button" data-toggle></button>
                <div class="title-bar-title">Menu</div>
            </div>

            <div class="top-bar" id="example-animated-menu" data-animate="fade-in fade-out">
                <div class="top-bar-left">
                    <ul class="vertical medium-horizontal dropdown menu" data-dropdown-menu>
                        <a href="<?= base_url(); ?>">
                            <li class="menu-text" id="logo"><img src="<?= base_url() ?>application/assets/img/logo.png"/></li>
                        </a>
                    </ul>
                </div>
                <div class="top-bar-right">
                    <ul class="vertical medium-horizontal dropdown menu" data-dropdown-menu>
                        <li><a href="<?= base_url('backoffice/admin'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                        <li><a href="<?= base_url('backoffice/user-management'); ?>"><i class="fa fa-users" aria-hidden="true"></i> Users</a></li>
                        <li><a href="<?= base_url('backoffice/orders'); ?>"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Orders</a></li>
                        <li><a href="<?= base_url('backoffice/products'); ?>"><i class="fa fa-cubes" aria-hidden="true"></i> Products</a></li>
                        <li><a href="<?= base_url('backoffice/settings'); ?>"><i class="fa fa-cogs" aria-hidden="true"></i> Settings</a></li>
                        <li><a href="#"><?= $this->session->first_name . ' ' . $this->session->last_name ?></a></li>
                        <li><a href="<?= base_url('backoffice/login/logout'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>