'use strict';
(function () {
    const spawn = require('child_process').spawn;

    const runner = spawn('php ./index.php', ['socket/rnnr', 'start'], {
        cwd: '../'
    });

    runner.stdout.on('data', function (data) {
        console.log('stdout: ' + data);
    });

    runner.stderr.on('data', function (data) {
        console.log('stderr: ' + data);
    });

    runner.on('close', function (code) {
        console.log('child process exited with code ' + code);
    });
})();