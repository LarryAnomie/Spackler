/* global define, Modernizr */

define([
    'jquery',
    'lodash',
    'modernizr',
    'snap',
    '../config/svg-icon-config',
    '../modules/svgicons'
], function ($, _, Modernizr, Snap, svgIconConfig, svgIcon) {

    'use strict';

    var Header = function($header) {

        if ( !(this instanceof Header) ) {
            return new Header( $header );
        }

        this.$el = $header;
        this.window = window;
        this.$window = $(window);

        this.$nav = $('#nav-overlay');
        this.$navToggle = this.$el.find('.nav-opener');

        this.ticking = false;
        this.latestKnownScrollY = 0;
        this.previousY = 0;
        this.HEADER_HEIGHT = 82;

        this.hamburgerIcon = new svgIcon(this.$el.find('.si-icon-hamburger-cross')[0], svgIconConfig, {
                //easing: mina.backin
        });

        this._init();

    };

    Header.prototype._init = function () {
        this.$window.on( 'scroll', _.bind( this._onScroll, this ) );

        this.$el.on( 'click', _.bind( this._onClick, this ) );

        // kick off
        requestAnimationFrame(_.bind( this._update, this ));


    };

    Header.prototype._requestTick = function() {
        if (!this.ticking) {
            requestAnimationFrame(_.bind( this._update, this ));
        }
        this.ticking = true;
    };

    Header.prototype._update = function() {
        // reset the tick so we can
        // capture the next onScroll
        this.ticking = false;

        if (!this.$el.hasClass('show')) {

            if (this.latestKnownScrollY > this.HEADER_HEIGHT) {

                if (this.latestKnownScrollY < this.previousY) {
                    this.$el.removeClass('header-hidden').addClass('visible');
                } else {
                    this.$el.removeClass('visible').addClass('header-hidden');
                }
            }

        }

        this.previousY = this.latestKnownScrollY;
    };

    Header.prototype._onScroll = function() {
        this.previousY = this.latestKnownScrollY;
        this.latestKnownScrollY = window.scrollY;
        this._requestTick();
    };

    Header.prototype._onClick = function(e) {

        var $self = $(e.target);

        if ($self.hasClass('home-link')) {
            return true;
        }

        e.preventDefault();

        this.$el.toggleClass('active');

        this.hamburgerIcon.toggle(true);

        this.$nav.toggleClass('show');
        this.$navToggle.toggleClass('active');
    };


    return Header;

});
