'use strict';
(function () {
    var http = require('http');

    module.exports = {
        start: function () {
            // Socket.io server listens to our app
            var io = require('socket.io').listen(8080);
            return io;
        }
    };
})();