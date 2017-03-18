'use strict';
(function () {

    const spawn = require('child_process').spawn;
    var bidder;

    module.exports = {
        start: function () {
            return bidder = spawn('php', ['./index.php', 'socket/bidder', 'start'], {
                cwd: '../'
            });
        },
        stop: function () {
            bidder.kill();
        }
    };

})();