(function () {
    $(document).foundation();

    MinuteWin = {
        conn: new WebSocket('ws://54.89.141.77:8080/socket/srvr'),
        durationUpdate: 0,
        totalDuration: 0,
        initialize: function (selector) {
            this.conn.onopen = function(e) {
                console.log("Connection established!");
            };

            this.conn.onmessage = function(e) {
                console.log(e.data);
            };
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
        updateScene: function (duration) {
            this.durationUpdate = duration;
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
        }
    };

    $(document).ready(function () {
        MinuteWin.initialize('.product-wrapper');
        MinuteWin.updateScene(60000);
    });
})();
