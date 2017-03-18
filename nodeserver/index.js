'use strict';
(function () {
    var runnerModule = require('./lib/runner');
    var bidderModule = require('./lib/bidder');
    var socketModule = require('./lib/socket');

    var runner = runnerModule.start();
    var bidder = bidderModule.start();
    var socket = socketModule.start();

    runner.stdout.on('data', function (data) {
        console.log('stdout: ' + data);
    });

    runner.stderr.on('data', function (data) {
        console.log('stderr: ' + data);
    });

    runner.on('close', function (code) {
        console.log('child process exited with code ' + code);
    });

    bidder.stdout.on('data', function (data) {
        console.log('stdout: ' + data);
    });

    bidder.stderr.on('data', function (data) {
        console.log('stderr: ' + data);
    });

    bidder.on('close', function (code) {
        console.log('child process exited with code ' + code);
    });

})();