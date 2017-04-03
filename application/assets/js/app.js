(function () {
    $(document).foundation();

    MinuteWin = {
        baseURL: 'http://1minutewin.com/',
        conn: null,
        orderID: 0,
        currentOrder: null,
        updateInterval: null,
        orderPrice: 0,
        durationUpdate: 0,
        totalDuration: 0,
        initialize: function (selector) {
            var self = this;
            this.conn = io('http://54.89.141.77:8080/');
            this.conn.on('connect', function(){
                //console.log(self.conn.id); // 'G5p5...'
            });
            this.conn.on('order', function (object) {
                self.handleOrder(object);
            });
        },
        handleOrder: function (object) {
            if (object.order) {
                if (object.order.order === 'clear') {
                    this.clearOrder();
                } else {
                    this.currentOrder = object.order;
                    $('.product_title').html(object.order.product.product_title);
                    $('#order_id').val(object.order.id);
                    $('.bid_count').html(object.order.bids);
                    var images = JSON.parse(object.order.product.pictures);
                    var self = this;
                    if (object.order.bids > 0) {
                        $('.buy_button').addClass('animate');
                        setTimeout(function () {
                            $('.buy_button').removeClass('animate');
                        }, 500);
                    }
                    $('.thumbs').html('');
                    images.forEach(function (item) {
                        $('.thumbs').append('<div class="thumb-wrapper"><img class="thumb" data-full="' + self.baseURL + item + '" src="' + self.baseURL + '_thumb/' + item + '"/></div>');
                    });
                    //$('.old_price').html(window.minuteSettings.currency_symbol + '' + object.order.product.regular_price);
                    $('.bid_for').html(window.minuteSettings.currency_symbol + '' + Math.ceil(parseInt(object.order.winning_price) + parseInt(object.order.winning_price) / 10));
                    this.orderPrice = Math.ceil(parseInt(object.order.winning_price) + parseInt(object.order.winning_price) / 10);
                    this.orderID = object.order.id;
                    $('#order_amount').val(Math.ceil(parseInt(object.order.winning_price) + parseInt(object.order.winning_price) / 10));
                    $('.image-outer img').attr('src', this.baseURL + JSON.parse(object.order.product.pictures)[0]);
                    $('#activeImage').attr('src', this.baseURL + JSON.parse(object.order.product.pictures)[0]);
                    $('.loader-icon').hide();
                    $('.shipping').html(object.order.product.shipping + " " + window.minuteSettings.currency_symbol + '' +  object.order.product.shipping_price);
                    $('.product_description').html(object.order.product.product_description);
                    /*$('.discount').html(
                        (Math.ceil(100 - object.order.winning_price / object.order.product.regular_price * 100) > 0 ?
                            Math.ceil(100 - object.order.winning_price / object.order.product.regular_price * 100)  + "% OFF": ''));*/
                    if (parseInt(object.order.user_id) === -1) {
                        var bidders = window.minuteSettings.bid_names.split(",");
                        var number = Math.floor(Math.random() * bidders.length - 1) + 1;
                        $('.user_winning').html(bidders[number - 1]);
                        $('.winning_append').html(' is winning');
                    } else {
                        if (object.order.user && object.order.user.first_name) {
                            $('.user_winning').html(object.order.user.first_name);
                            $('.winning_append').html(' is winning');
                        } else {
                            $('.winning_append').html('Start bidding');
                            $('.user_winning').html('');
                        }
                    }
                    this.updateScene(object.order.duration, object.order.durationLeft);
                }
            }
        },
        clearOrder: function () {
            $('.product_title').html('');
            $('#order_id').val('');
            $('#order_amount').val('');
            $('.bid_count').html('');
            $('.loader-icon').show();
            $('.thumbs').html('');
            $('.old_price').html('');
            $('.bid_for').html('');
            $('.image-outer img').attr('src', '');
            $('#activeImage').attr('src', '');
            $('.shipping').html('');
            $('.winning_append').html('Start bidding');
            $('.user_winning').html('');
            $('.discount').html('');
            $('.auction_phase').html('');
            $('.product_description').html('');
            this.orderPrice = 0;
            this.orderID = 0;
        },
        sendBid: function () {
            if (parseInt(window.user_id) > 0) {
                if (parseInt(this.orderID) > 0) {
                    this.conn.emit('newbid', {
                        'user_id': window.user_id,
                        'order_id': this.orderID,
                        'amount': this.orderPrice
                    });
                }
            } else {
                $('#animatedModal11').foundation('open');
            }
        },
        updateScene: function (duration, durationLeft, fps) {
            if (this.updateInterval) {
                clearInterval(this.updateInterval);
            }
            fps = fps || 60;
            this.durationUpdate = durationLeft || duration;
            this.totalDuration = duration;
            var elem = jQuery('.progress-inner');
            this.updateInterval = setInterval(frame, Math.ceil(1000/fps));
            var self = this;
            function frame() {
                if (self.durationUpdate <= 0) {
                    clearInterval(self.updateInterval);
                    if (parseInt(self.currentOrder.user_id) === parseInt(window.user_id) && parseInt(window.user_id) > 0){
                        $('.auction_phase').html('You won... <a href="/home/cart">Pay with PayPal</a>');
                        $('#animatedModal12').foundation('open');
                    }
                } else {
                    self.durationUpdate = self.durationUpdate - Math.ceil(1000/fps);
                    elem.height((self.durationUpdate / self.totalDuration * 100).toFixed(4) + '%');
                    if (self.totalDuration - self.durationUpdate > (parseInt(window.minuteSettings.initial_duration) + parseInt(window.minuteSettings.going_once)) * 1000) {
                        elem.css('background-color', '#f00');
                        jQuery('.auction_phase').html('Going twice');
                        jQuery('.auction_phase').css('color', '#f00');
                    } else if (self.totalDuration - self.durationUpdate > parseInt(window.minuteSettings.initial_duration) * 1000) {
                        elem.css('background-color', '#f90');
                        jQuery('.auction_phase').html('Going once');
                        jQuery('.auction_phase').css('color', '#f90');
                    } else {
                        elem.css('background-color', '#00f');
                        jQuery('.auction_phase').html('Accepting offers');
                        jQuery('.auction_phase').css('color', '#00f');
                    }
                }
            }
        },
        selectImage: function () {
            if (jQuery('.thumbs').length > 0) {
                jQuery('.thumbs').on('click', '.thumb', function () {
                    jQuery('#activeImage').attr('src', jQuery(this).attr('data-full'));
                    jQuery('.thumb-wrapper').removeClass('active');
                    jQuery(this).parent().addClass('active');
                });
            }
        },
        heartBeat: function () {
            var self = this;
            $(window).on('focus', function() {
                self.conn.emit('heartbeat', { 'ping': 1 });
            });
        }
    };

    $(document).ready(function () {
        if ($('.product-wrapper').length) {
            MinuteWin.initialize('.product-wrapper');
            //MinuteWin.updateScene(60000);
            MinuteWin.selectImage();
            MinuteWin.heartBeat();
        }
    });

    $('.buy_button').click(function (e) {
        e.preventDefault();
        MinuteWin.sendBid();
    });
})();
