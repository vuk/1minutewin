(function () {
    $(document).foundation();

    MinuteWin = {
        conn: io('http://54.89.141.77:8080/'),
        durationUpdate: 0,
        totalDuration: 0,
        initialize: function (selector) {
            this.conn.on('connect', function(){
                console.log(this.conn.id); // 'G5p5...'
            });
        },
        newBid: function (message) {
            this.durationUpdate = this.totalDuration;
            jQuery('#winning').html(message.payload.winning);
            jQuery('#amount').html(message.payload.currentAmount);
            jQuery('#')
        },
        sendBid: function () {
            this.conn.send({
                'type': 'bid',
                'payload': {
                    'user_id': '1',
                    'value': '1'
                }
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
        MinuteWin.updateScene(60000);
        MinuteWin.selectImage();
    });
})();
