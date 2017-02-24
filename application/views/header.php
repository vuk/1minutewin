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
    <title>Document</title>
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
                            <li class="menu-text" id="logo"><img src="<?= base_url() ?>application/assets/img/logo.png"/></li>
                        </ul>
                    </div>
                    <div class="top-bar-right">
                        <ul class="vertical medium-horizontal dropdown menu" data-dropdown-menu>
                            <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                            <li><a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i> About</a></li>
                            <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <section class="center">
        <div class="row">
            <div class="columns large-12 small-12">
                <article class="product-wrapper small-12 large-4 medium-10">
                    <div class="product-inner">
                        <div class="product-content">
                            <a href="#" data-toggle="animatedModal10">
                                <div class="image-outer">
                                    <img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=Placeholder&w=400&h=400" alt="">
                                </div>
                                <div class="content-outer">
                                    <div class="content-inner">
                                        <h1>Some title</h1>
                                        <div class="live-data">
                                            <div id="phase"><span>Accepting bids</span></div>
                                            <div id="leader"><span>John is winning</span></div>
                                            <div class="row keep-in">
                                                <div class="columns large-6 small-6">
                                                    <span id="bids">0 Bids</span>
                                                </div>
                                                <div class="columns large-6 small-6 text-right">
                                                    <span id="old-price">$40</span>
                                                    <span id="discount">60% OFF</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buy-button">
                                            <a href="#buy" class="success button expanded">
                                                <span class="btn-price">Bid for $<span id="amount">5</span></span>
                                                <span><small class="shipping">Shipping $3</small></span>
                                                <span class="clearfix">
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="vertical-progress">
                            &nbsp;
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <div class="reveal" id="animatedModal10" data-reveal data-close-on-click="true" data-animation-in="hinge-in-from-top" data-animation-out="hinge-out-from-top">
        <h1>Product description</h1>
        <p class='lead'>Product description will be here</p>
        <button class="close-button" data-close aria-label="Close reveal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <script src="<?= base_url(); ?>application/assets/js/vendor/jquery.js"></script>
    <script src="<?= base_url(); ?>application/assets/js/vendor/foundation.min.js"></script>
    <script src="<?= base_url(); ?>application/assets/js/app.js"></script>
</body>
</html>