/* global require */

'use strict';

require.config({
    paths: {
        jquery: '../bower_components/jquery/dist/jquery',
        lodash: '../bower_components/lodash/dist/lodash',
        modernizr: '../bower_components/modernizr/modernizr',
        snap : '../bower_components/snap.svg/dist/snap.svg',
    },
    shim: {
        'modernizr': {
            exports: 'Modernizr'
        }
    }
});
