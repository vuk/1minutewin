'use strict';
(function () {
    const exec = require('child_process').exec;

    const runner = exec('php -f ../index.php socket/rnnr start', function(err, stdout, stderr){
        if(err || stderr){
            console.error(err || stderr);
            return;
        }
        console.log(stdout);
    });
})();