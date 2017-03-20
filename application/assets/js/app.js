(function () {
    $(document).foundation();

    MinuteWin = {
        conn: io('http://54.89.141.77:8080/'),
        durationUpdate: 0,
        totalDuration: 0,
        initialize: function (selector) {
            var self = this;
            this.conn.on('connect', function(){
                console.log(self.conn.id); // 'G5p5...'
            });
            this.conn.on('order', function (object) {
                console.log('event: ', object);
                self.handleOrder(object);
            });
        },
        handleOrder: function (object) {
            if (object.order) {
                if (object.order.order === 'clear') {
                    this.clearOrder();
                } else {
                    $('.product_title').html(object.order.product.product_title);
                    $('#order_id').val(object.order.id);
                    $('.bid_count').html(object.order.bids);
                    $('.bid_for').html(Math.ceil(parseInt(object.order.winning_price) + parseInt(object.order.winning_price) / 10));
                    $('#order_amount').val(Math.ceil(parseInt(object.order.winning_price) + parseInt(object.order.winning_price) / 10));
                    $('.image-outer img').attr('src', JSON.parse(object.order.product.pictures)[0]);
                    $('.shipping').html(object.order.product.shipping + " " + object.order.product.shipping_price);
                    $('.discount').html(
                        (Math.ceil(100 - object.order.winning_price / object.order.product.regular_price * 100) > 0 ?
                            Math.ceil(100 - object.order.winning_price / object.order.product.regular_price * 100)  + "% OFF": ''));
                    this.updateScene(object.order.duration, object.order.durationLeft);
                }
            }
        },
        clearOrder: function () {
            $('.product_title').html('');
            $('#order_id').val('');
            $('#order_amount').val('');
            $('.bid_count').html('');
            $('.bid_for').html('');
            $('.image-outer img').attr('src', '');
            $('.shipping').html('');
            $('.discount').html('');
        },
        sendBid: function () {
            if (parseInt($('#user_id').val()) > 0) {
                this.conn.emit('newbid', {
                    'user_id': $('#user_id').val(),
                    'order_id': $('#order_id').val(),
                    'amount': $('#order_amount').val()
                });
            }
        },
        updateScene: function (duration, durationLeft) {
            this.durationUpdate = durationLeft || duration;
            this.totalDuration = duration;
            var elem = jQuery('.progress-inner');
            var id = setInterval(frame, 17);
            var self = this;
            function frame() {
                if (self.durationUpdate <= 0) {
                    clearInterval(id);
                } else {
                    self.durationUpdate = self.durationUpdate - 17;
                    elem.height((self.durationUpdate / self.totalDuration * 100).toFixed(4) + '%');
                }
            }
        },
        selectImage: function () {
            if (jQuery('.thumb-wrapper').length > 0) {
                jQuery('.thumb-wrapper img').click( function () {
                    jQuery('#activeImage').attr('src', jQuery(this).attr('data-full'));
                    jQuery('.thumb-wrapper').removeClass('active');
                    jQuery(this).parent().addClass('active');
                });
            }
        }
    };

    $(document).ready(function () {
        MinuteWin.initialize('.product-wrapper');
        //MinuteWin.updateScene(60000);
        MinuteWin.selectImage();
    });

    $('.buy_button').click(function (e) {
        e.preventDefault();
        MinuteWin.sendBid();
    });
})();
