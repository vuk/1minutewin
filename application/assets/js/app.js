(function () {
    $(document).foundation();

    MinuteWin = {
        initialize: function (selector) {
            var conn = new WebSocket('ws://54.89.141.77:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
                console.log(e.data);
            };
        }
    }

    $(document).ready(function () {
        MinuteWin.initialize('.product-wrapper');
    });
})();
