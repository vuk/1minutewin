'use strict';
(function () {

    const spawn = require('child_process').spawn;
    var bidder;

    module.exports = {
        start: function () {
            return bidder = spawn('/opt/bitnami/php/bin/php', ['/home/bitnami/htdocs/1minutewin/index.php', 'socket/bidder', 'start'], {
                cwd: '../'
            });
        },
        stop: function () {
            bidder.kill();
        }
    };

})();