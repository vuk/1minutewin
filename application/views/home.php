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
                                    <h1><?= $product->product_title ?></h1>
                                    <div class="live-data">
                                        <div id="phase"><span>Accepting bids</span></div>
                                        <div id="leader"><span><span id="winning">John</span> is winning</span></div>
                                        <div class="row keep-in">
                                            <div class="columns large-6 small-6">
                                                <span><span id="bids">0</span> Bids</span>
                                            </div>
                                            <div class="columns large-6 small-6 text-right">
                                                <span id="old-price">$40</span>
                                                <span id="discount">60% OFF</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buy-button">
                                        <a href="#buy" class="success button expanded">
                                            <span class="btn-price">Bid for $<span id="amount"><?= $product->initial_price ?></span></span>
                                            <span><small class="shipping">Shipping $<?= $product->shipping_price ?></small></span>
                                            <span class="clearfix">
                                                </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="vertical-progress">
                        &nbsp;<div class="progress-inner" style="background: blue"></div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
<div class="reveal" id="animatedModal10" data-reveal data-close-on-click="true" data-animation-in="hinge-in-from-top" data-animation-out="hinge-out-from-top">
    <h1><?= $product->product_title ?></h1>
    <p class='lead'><?= $product->product_description ?></p>
    <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>