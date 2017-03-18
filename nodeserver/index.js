'use strict';
(function () {
    var runnerModule = require('./lib/runner');
    var bidderModule = require('./lib/bidder');

    var runner = runnerModule.start();
    var bidder = bidderModule.start();

})();