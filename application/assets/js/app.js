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
            if (object.order.order === 'clear') {
                this.clearOrder();
            } else {
                $('.product_title').html(object.order.product.product_title);
                $('.bid_count').html(object.order.bids);
                $('.bid_for').html(object.order.winning_price);
                $('.image-outer img').attr('src', JSON.parse(object.order.product.pictures)[0]);
                $('.shipping').html(object.order.product.shipping + " " + object.order.product.shipping_price);
                $('.discount').html((100 - object.order.winning_price / object.order.product.regular_price * 100) + "% OFF");
                this.updateScene(object.order.duration, object.order.durationLeft);
            }
        },
        clearOrder: function () {
            $('.product_title').html('');
            $('.bid_count').html('');
            $('.bid_for').html('');
            $('.image-outer img').attr('src', '');
            $('.shipping').html('');
            $('.discount').html('');
        },
        newBid: function (message) {
            this.durationUpdate = this.totalDuration;
            jQuery('#winning').html(message.payload.winning);
            jQuery('#amount').html(message.payload.currentAmount);
        },
        sendBid: function () {
            this.conn.emit('newbid', {
                'user_id': '2',
                'order_id': '187',
                'amount': '12'
            })
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
})();
