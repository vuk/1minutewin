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
                                <i class="fa fa-refresh fa-spin fa-3x fa-fw loader-icon"></i>
                                <img src="<? //= //base_url(json_decode($product->pictures)[0]) ?>" alt="">
                            </div>
                            <div class="content-outer">
                                <div class="content-inner">
                                    <h1 class="product_title">Loading...</h1>
                                    <div class="live-data">
                                        <div id="phase"><span class="auction_phase"></span></div>
                                        <div id="leader"><span><span class="user_winning"></span> <span
                                                        class="winning_append"></span></span></div>
                                        <div class="row keep-in">
                                            <div class="columns large-6 small-6">
                                                <span><span class="bid_count"></span> Bids</span>
                                            </div>
                                            <div class="columns large-6 small-6 text-right">
                                                <span id="old-price" class="old_price"></span>
                                                <span id="discount" class="discount"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buy-button">
                                        <a href="#buy" class="success button expanded buy_button">
                                            <span class="btn-price">Bid for <span id="amount"
                                                                                  class="bid_for"></span></span>
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
                        &nbsp;
                        <div class="progress-inner"></div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>
<div class="reveal large" id="animatedModal10" data-reveal data-close-on-click="true"
     data-animation-in="hinge-in-from-top" data-animation-out="hinge-out-from-top">
    <div class="row">
        <div class="columns large-12">
            <h1 class="product_title">Loading...</h1>
            <div class="row">
                <div class="columns large-8">
                    <div class="gallery-wrapper row">
                        <div class="active-image-wrapper columns large-8 small-12">
                            <i class="fa fa-refresh fa-spin fa-3x fa-fw loader-icon"></i>
                            <img id="activeImage" src="<? //= //base_url(json_decode($product->pictures)[0]) ?>"/>
                        </div>
                        <div class="thumbs columns large-4 small-6 medium-6">

                        </div>
                    </div>
                </div>
                <div class="columns large-4">
                    <div class="content-inner modal-content-inner">
                        <div class="live-data">
                            <div id="phase"><span class="auction_phase"></span></div>
                            <div id="leader"><span><span class="user_winning"></span> <span
                                            class="winning_append"></span></span></div>
                            <div class="row keep-in">
                                <div class="columns large-6 small-6">
                                    <span><span id="bids" class="bid_count"></span> Bids</span>
                                </div>
                                <div class="columns large-6 small-6 text-right">
                                    <span class="old_price"></span>
                                    <span class="discount"></span>
                                </div>
                            </div>
                        </div>
                        <div class="buy-button">
                            <a href="#buy" class="success button expanded buy_button">
                                <span class="btn-price">Bid for <span id="amount" class="bid_for"></span></span>
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
                    <div class="paypal-notif">
                        <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/rs/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/rs/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/bdg_now_accepting_pp_2line_w.png" border="0" alt="Now accepting PayPal"></a><div style="text-align:center"><a href="https://www.paypal.com/rs/webapps/mpp/pay-online" target="_blank" ><font size="2" face="Arial" color="#0079CD"><b>How PayPal Works</b></font></a></div></td></tr></table><!-- PayPal Logo -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="reveal" id="animatedModal12" data-reveal data-close-on-click="true" data-animation-in="hinge-in-from-top"
     data-animation-out="hinge-out-from-top">
    <div class="row">
        <div class="columns large-12">
            <h1 style="text-align: center;">You won!</h1>
            <div class="row">
                <div class="columns large-12">
                    <h3 style="text-align: center;"><a class="button extended large" href="/home/cart">Pay with PayPal!</a></h3>
                </div>
                <!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/rs/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/rs/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo/bdg_now_accepting_pp_2line_w.png" border="0" alt="Now accepting PayPal"></a><div style="text-align:center"><a href="https://www.paypal.com/rs/webapps/mpp/pay-online" target="_blank" ><font size="2" face="Arial" color="#0079CD"><b>How PayPal Works</b></font></a></div></td></tr></table><!-- PayPal Logo -->
            </div>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close reveal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<script>
    window.minuteSettings = <?= json_encode($settings); ?>;
    window.user_id = <?= intval($this->session->id) > 0 ? $this->session->id : 0 ?>;
</script>