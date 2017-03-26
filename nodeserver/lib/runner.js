'use strict';
(function () {

    const spawn = require('child_process').spawn;
    var runner;

    module.exports = {
        start: function () {
            return runner = spawn('/opt/bitnami/php/bin/php', ['/home/bitnami/htdocs/1minutewin/index.php', 'socket/rnnr', 'start'], {
                cwd: '../'
            });
        },
        stop: function () {
            runner.kill();
        }
    };

})();