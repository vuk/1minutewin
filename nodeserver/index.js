'use strict';
(function () {
    var runnerModule = require('./lib/runner');
    var bidderModule = require('./lib/bidder');
    var socketModule = require('./lib/socket');
    var http = require('http');

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

    socket.on('connection', function (socketIn) {
        socketIn.emit('order', currentOrder);
    });

    socket.on('newbid', function (payload) {
        console.log(payload);

        http.get('http://1minutewin.com/home/bid/' + payload.user_id + '/' + payload.order_id + '/' + payload.amount, function (res) {
            var body = ''; // Will contain the final response
            res.on('data', function (data) {
                body += data;
            });
            res.on('end', function () {
                var parsed = JSON.parse(body);
                socket.emit('order', parsed);
                console.log(parsed);
            });
        })
        .on('error', function (e) {
            console.log("Got error: " + e.message);
        });
    });

})();