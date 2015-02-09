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
        app.header = new Header($('.js-header'));

        function windowPopup(url, width, height) {
            // Calculate the position of the popup so
            // it’s centered on the screen.
            var left = (screen.width / 2) - (width / 2),
               top = (screen.height / 2) - (height / 2);

            window.open(
                url,
                '',
                'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=' + width + ',height=' + height + ',top=' + top + ',left=' + left
            );
        }

        $('.js-social-share').on('click', function(e) {
            e.preventDefault();

            windowPopup($(this).attr('href'), 500, 300);
        });

        // cross browser transition name
        app.transEndEventName = transEndEventNames[Modernizr.prefixed('transition')];

    };

    return app;

});
