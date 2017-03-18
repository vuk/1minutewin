'use strict';
(function () {
    var runnerModule = require('./lib/runner');
    var bidderModule = require('./lib/bidder');
    var socketModule = require('./lib/socket');

    var runner = runnerModule.start();
    var bidder = bidderModule.start();
    var socket = socketModule.start();

    var currentOrder = null;

    runner.stdout.on('data', function (data) {
        console.info('[INFO] New order: ' + data);
        currentOrder = JSON.parse(data);
        socket.emit('order', currentOrder);
    });

    runner.stderr.on('data', function (data) {
        console.error('[ERROR] Runner failed: ' + data);
    });

    runner.on('close', function (code) {
        console.info('[INFO] Runner process stopped with code: ' + code);
    });

    bidder.stdout.on('data', function (data) {
        console.info('[INFO] New automatic bid ' + data);
    });

    bidder.stderr.on('data', function (data) {
        console.error('[ERROR] Bidder process failed: ' + data);
    });

    bidder.on('close', function (code) {
        console.log('[INFO] ' + code);
    });

    socket.on('connection', function(socketIn) {
        socketIn.emit('order', currentOrder);
    });

    socket.on('bid', function (event, data) {

    });

})();