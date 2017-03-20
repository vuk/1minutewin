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
        socket.emit('order', {message: 'new order', order: currentOrder});
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
            var t1 = dateformatting(currentOrder.created_at);
            var t2 = dateformatting(currentOrder.ending_at);
            var t3 = new Date();
            t3.setHours(t3.getHours() - 7);
            currentOrder.duration = Math.floor(t2.getTime()) - Math.floor(t1.getTime());
            currentOrder.durationLeft = Math.floor(t2.getTime()) - Math.floor(t3.getTime());
            socketIn.emit('order', {message: 'existing order', order: currentOrder});
        }
    });

    socket.on('newbid', newbid);

    function newbid (payload) {
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
    }

    function dateformatting(mysql_string)
    {
        var t, result = null;

        if( typeof mysql_string === 'string' )
        {
            t = mysql_string.split(/[- :]/);

            //when t[3], t[4] and t[5] are missing they defaults to zero
            result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
        }

        return result;
    }

})();