/* global define */

define([
    'jquery',
    'lodash',
    'modernizr',
    'modules/Header'
], function ($, _, Modernizr, Header) {

    'use strict';

    var app = {};

    /**
     * inits app
     * @return {Object}
     */
    app.init = function () {

        var transEndEventNames = {
            'WebkitTransition': 'webkitTransitionEnd', // Saf 6, Android Browser
            'MozTransition': 'transitionend', // only for FF < 15
            'transition': 'transitionend' // IE10, Opera, Chrome, FF 15+, Saf 7+
        };

        app.$body = $('body');
        app.$window = $(window);

        // set up header
        app.header = new Header($('#header'));

        // cross browser transition name
        app.transEndEventName = transEndEventNames[Modernizr.prefixed('transition')];

    };

    return app;

});
