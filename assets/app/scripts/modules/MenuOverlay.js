/* global define */

define([
    'jquery',
    'lodash',
    'modules/SvgIcon',
    'hammer'
], function ($, _, SvgIcon) {

    TouchEmulator();

    var svgPath = '/wp-content/themes/spackler/assets/i/svgs/';

    var svgIconConfig = {

        hamburgerCross: {
            url: svgPath + 'hamburger.svg',
            animation: [{
                el: 'path:nth-child(1)',
                animProperties: {
                    from: {
                        val: '{"path" : "m 5.0916789,20.818994 53.8166421,0"}'
                    },
                    to: {
                        val: '{"path" : "M 12.972944,50.936147 51.027056,12.882035"}'
                    }
                }
            }, {
                el: 'path:nth-child(2)',
                animProperties: {
                    from: {
                        val: '{"transform" : "s1 1", "opacity" : 1}',
                        before: '{"transform" : "s0 0"}'
                    },
                    to: {
                        val: '{"opacity" : 0}'
                    }
                }
            }, {
                el: 'path:nth-child(3)',
                animProperties: {
                    from: {
                        val: '{"path" : "m 5.0916788,42.95698 53.8166422,0"}'
                    },
                    to: {
                        val: '{"path" : "M 12.972944,12.882035 51.027056,50.936147"}'
                    }
                }
            }]
        }
    };

    /**
     * Creates a new menu overlay object
     * @class
     * @param Object $nav - the jQuery element to be stuck
     */
    var MenuOverlay = function($header, $nav) {

        if ( !(this instanceof MenuOverlay) ) {
            return new MenuOverlay( $nav );
        }

        if (!$header || !$nav) {
            return;
        }

        this.$el = $header;
        this.$navToggle = this.$el.find('.js-nav-toggle');
        this.$nav = $nav;
        this.$body = $('body');

        this.$window = $(window);

        this.hamburgerIcon = new SvgIcon($header.find('.si-icon-hamburger-cross')[0], svgIconConfig, {
            //easing: mina.backin
        });


        // attach events
        this.$el.on('click', _.bind(this._onClick, this));

        return this;
    };

    MenuOverlay.prototype._onClick = function(e) {
        var $self = $(e.target);

        if ($self.hasClass('js-site-logo')) {
            return true;
        }

        e.preventDefault();

        this.$body.toggleClass('no-scroll');

        this.$el.toggleClass('active');

        this.hamburgerIcon.toggle(true);

        this.$nav.toggleClass('show');
        this.$navToggle.toggleClass('active');
    };

    MenuOverlay.prototype._close = function(first_argument) {
        this.$body.removeClass('no-scroll');

        this.$el.removeClass('active');

        this.hamburgerIcon.toggle(true);

        this.$nav.removeClass('show');
        this.$navToggle.removeClass('active');
    };

    return MenuOverlay;

});
