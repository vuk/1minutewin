'use strict';
(function () {
    var server = require('http').createServer();

    module.exports = {
        start: function () {
            // Socket.io server listens to our app
            var io = require('socket.io')(server);
            server.listen(8080);
            return io;
        }
    };
})();