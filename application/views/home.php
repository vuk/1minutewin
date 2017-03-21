<section class="center">
    <div class="row">
        <div class="columns large-12 small-12">
            <article class="product-wrapper small-12 large-4 medium-10">
                <div class="product-inner">
                    <div class="product-content">
                        <a href="#" data-toggle="animatedModal10">
                            <div class="image-outer">
                                <input type="hidden" name="user_id" value="<?= $this->session->id ?>" id="user_id"/>
                                <input type="hidden" name="order_id" value="" id="order_id"/>
                                <input type="hidden" name="order_amount" value="" id="order_amount"/>
                                <img src="<?= base_url(json_decode($product->pictures)[0]) ?>" alt="">
                            </div>
                            <div class="content-outer">
                                <div class="content-inner">
                                    <h1 class="product_title">Loading...</h1>
                                    <div class="live-data">
                                        <div id="phase"><span>Accepting bids</span></div>
                                        <?php if($order->bids > 0): ?>
                                            <div id="leader"><span><span class="user_winning">John</span> <span class="winning_append">is winning</span></span></div>
                                        <?php else: ?>
                                            <div id="leader"><span><span class="user_winning"></span> <span class="winning_append">Start bidding</span></span></div>
                                        <?php endif; ?>
                                        <div class="row keep-in">
                                            <div class="columns large-6 small-6">
                                                <span><span class="bid_count"><?= $order->bids ?></span> Bids</span>
                                            </div>
                                            <div class="columns large-6 small-6 text-right">
                                                <span id="old-price" class="old_price"><?= $settings->currency_symbol ?></span>
                                                <span id="discount" class="discount"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buy-button">
                                        <a href="#buy" class="success button expanded buy_button">
                                            <span class="btn-price">Bid for <?= $settings->currency_symbol ?><span id="amount" class="bid_for"></span></span>
                                            <span><small class="shipping"></small></span>
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
<div class="reveal large" id="animatedModal10" data-reveal data-close-on-click="true" data-animation-in="hinge-in-from-top" data-animation-out="hinge-out-from-top">
    <div class="row">
        <div class="columns large-12">
            <h1 class="product_title">Loading...</h1>
            <div class="row">
                <div class="columns large-8">
                    <div class="gallery-wrapper row">
                        <div class="active-image-wrapper columns large-8 small-12">
                            <img id="activeImage" src="<?= base_url(json_decode($product->pictures)[0]) ?>"/>
                        </div>
                        <div class="thumbs columns large-4 small-12">
                            <?php foreach(json_decode($product->pictures) as $picture): ?>
                                <div class="thumb-wrapper">
                                    <img class="thumb" data-full="<?= base_url($picture) ?>" src="<?= base_url('_thumb/'.$picture) ?>"/>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="columns large-4">
                    <div class="content-inner modal-content-inner">
                        <div class="live-data">
                            <div id="phase"><span>Accepting bids</span></div>
                            <?php if($order->bids > 0): ?>
                                <div id="leader"><span><span class="user_winning" >John</span> <span class="winning_append">is winning</span></span></div>
                            <?php else: ?>
                                <div id="leader"><span><span class="user_winning"></span> <span class="winning_append">Start bidding</span></span></div>
                            <?php endif; ?>
                            <div class="row keep-in">
                                <div class="columns large-6 small-6">
                                    <span><span id="bids" class="bid_count"></span> Bids</span>
                                </div>
                                <div class="columns large-6 small-6 text-right">
                                    <span class="old_price"><?= $settings->currency_symbol ?></span>
                                    <span class="discount"></span>
                                </div>
                            </div>
                        </div>
                        <div class="buy-button">
                            <a href="#buy" class="success button expanded buy_button">
                                <span class="btn-price">Bid for <?= $settings->currency_symbol ?><span id="amount" class="bid_for"></span></span>
                                <span><small class="shipping"></small></span>
                                <span class="clearfix">
                                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="description modal-content-inner">
                        <h4>Description:</h4>
                        <span class="product_description"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>