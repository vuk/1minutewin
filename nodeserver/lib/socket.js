'use strict';
(function () {
    var http = require('http');

    module.exports = {
        start: function () {
            var app = http.createServer(function(req, res) {
                res.writeHead(200, {'Content-Type': 'text/html'});
                res.end('socket server');
            });

            // Socket.io server listens to our app
            var io = require('socket.io').listen(app);
            app.listen(8080);
            return io;
        }
    };
})();