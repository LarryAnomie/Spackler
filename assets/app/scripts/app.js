/* global define, Modernizr */

define([
    'jquery',
    'lodash',
    'modernizr',
    'modules/header'
], function ($, _, Modernizr, Header) {

    'use strict';

    /**
     * inits app
     * @return {Object}
     */
    var init = function () {

        var transEndEventNames = {
                'WebkitTransition': 'webkitTransitionEnd', // Saf 6, Android Browser
                'MozTransition': 'transitionend', // only for FF < 15
                'transition': 'transitionend' // IE10, Opera, Chrome, FF 15+, Saf 7+
            },
            app = {};

        app.$body = $('body');
        app.$window = $(window);

        // set up header
        var header = new Header($('#header'));

        // cross browser transition name
        app.transEndEventName = transEndEventNames[Modernizr.prefixed('transition')];

    };

    return {
        init: init
    };

});
