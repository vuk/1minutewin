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
        var t1 = new Date(currentOrder.updated_at);
        var t2 = new Date(currentOrder.ending_at);
        var t3 = new Date();
        t3.setHours(t3.getHours() - 7);
        currentOrder.duration = Math.floor(t2.getTime()) - Math.floor(t1.getTime());
        currentOrder.durationLeft = Math.floor(t2.getTime()) - Math.floor(t3.getTime());
        socket.emit('order', {message: 'new order', order: currentOrder});
        if (currentOrder.order === 'clear') {
            currentOrder = null;
        }
    });

    runner.stderr.on('data', function (data) {
        console.error('[ERROR] Runner failed: ' + data);
        runner = runnerModule.start();
    });

    runner.on('close', function (code) {
        console.info('[INFO] Runner process stopped with code: ' + code);
        runner = runnerModule.start();
    });

    bidder.stdout.on('data', function (data) {
        console.info('[INFO] New automatic bid ' + data);
    });

    bidder.stderr.on('data', function (data) {
        console.error('[ERROR] Bidder process failed: ' + data);
        bidder = bidderModule.start();
    });

    bidder.on('close', function (code) {
        console.log('[INFO] ' + code);
        bidder = bidderModule.start();
    });

    socket.on('connection', function (socketIn) {
        if (currentOrder) {
            var t1 = new Date(currentOrder.updated_at);
            var t2 = new Date(currentOrder.ending_at);
            var t3 = new Date();
            t3.setHours(t3.getHours() - 7);
            currentOrder.duration = Math.floor(t2.getTime()) - Math.floor(t1.getTime());
            currentOrder.durationLeft = Math.floor(t2.getTime()) - Math.floor(t3.getTime());
            socketIn.emit('order', {message: 'existing order', order: currentOrder});
            socketIn.on('newbid', newbid);
            socketIn.on('heartbeat', heartbeat);
        }
    });

    function newbid(payload) {
        console.log(payload);
        if (parseInt(payload.user_id > 0) && parseInt(payload.order_id) > 0) {
            console.log('if condition met');
            http.get('http://54.89.141.77/1minutewin/index.php/home/bid/' + payload.user_id + '/' + payload.order_id + '/' + payload.amount, function (res) {
                var body = ''; // Will contain the final response
                res.on('data', function (data) {
                    body += data;
                });
                res.on('end', function () {
                    console.log('body ready ', body);
                    var parsed = JSON.parse(body);
                    if (parsed.message === 'Bid accepted') {
                        var t1 = new Date(parsed.order.updated_at);
                        var t2 = new Date(parsed.order.ending_at);
                        var t3 = new Date();
                        t3.setHours(t3.getHours() - 7);
                        parsed.order.duration = Math.floor(t2.getTime()) - Math.floor(t1.getTime());
                        parsed.order.durationLeft = Math.floor(t2.getTime()) - Math.floor(t3.getTime());
                        socket.emit('order', parsed);
                        currentOrder = parsed.order;
                    }
                });
            })
                .on('error', function (e) {
                    console.log("Got error: " + e.message);
                });
        }
    }

    function heartbeat(payload) {
        console.log(payload);
        if (currentOrder) {
            var t1 = new Date(currentOrder.updated_at);
            var t2 = new Date(currentOrder.ending_at);
            var t3 = new Date();
            t3.setHours(t3.getHours() - 7);
            currentOrder.duration = Math.floor(t2.getTime()) - Math.floor(t1.getTime());
            currentOrder.durationLeft = Math.floor(t2.getTime()) - Math.floor(t3.getTime());
            socket.emit('order', {message: 'new order', order: currentOrder});
        }
    }

})();