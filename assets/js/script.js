/*global LN:true, UTIL:true, yepnope:true, $:true, jQuery:true, document:true, window:true*/
/*jslint sloppy: true, maxerr: 50, indent: 4 */

/*
 * left unminified for the curious amongst you
 * @param: blood, sweat, tears
 * @return: awesomeness
 */

var LN = {
        webRoot : "/",
        jsRoot : "wp-content/themes/larry/js/",
        cssRoot : "wp-content/themes/larry/css/",
        cacheBust : "?0009",
        scripts : {
            respond : "libs/respond.js",
            jqueryCdn : "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js",
            jqueryLocal : "libs/jquery.js",
            isotope : "plugins/isotope-site/jquery.isotope.min.js",
            flexSlider : "plugins/flexSlider/jquery.flexslider-min.js",
            bxSlider : "plugins/jquery.bxslider/jquery.bxslider.min.js"
        },
        isTouch : Modernizr.touch,
        isotopeInit : function () {
            var $folio = $("#folio"),
                $folioNav = $(".portfnav");

            $folio.isotope();

            $folioNav.find("a").on("click", function (e) {
                var $self = $(this),
                    text = $self.text(),
                    filter;

                e.preventDefault();

                $folioNav.find("li").removeClass("active");
                $self.parent("li").addClass("active");

                if (text === "Print / Identity") {
                    //console.log("Print");
                    filter = ".print";

                } else if (text === "Web") {
                    //console.log("web");
                    filter = ".web";

                } else {
                    filter = "*";
                }

                $folio.isotope({filter : filter});
            });
        },
        /*stuff common to everypage on site*/
        common : {
            init : function () {

                var $nav = $("#nav"),
                    $navToggle = $(".menu-toggle"),
                    resizeTimeout,
                    mode,
                    $window = $(window),
                    windowWidth = $window.width(),
                    breakPoints = {
                        mobile : 480,
                        tablet : 768,
                        desktop: 992
                    },
                    isSmallScreen = windowWidth >= breakPoints.tablet ? false : true;

                /*
                 * Throttle window resize event and check window width after resize
                 *
                 */
                $window.on("resize", function() {

                    if (resizeTimeout) {
                        clearTimeout(resizeTimeout);
                    }

                    resizeTimeout = setTimeout(function () {
                        var width = $window.width();

                        if (isSmallScreen && width >= breakPoints.tablet) {

                            $nav.removeClass("active");
                            $navToggle.removeClass("active");
                            isSmallScreen = false;
                        } else if (!isSmallScreen && width < breakPoints.tablet) {

                            isSmallScreen = true;
                        }

                    }, 100);

                });

                // Navigation toggle behaviour for small screens
                $navToggle.on("click", function(e) {
                    e.preventDefault();
                    $nav.toggleClass("active");
                    $navToggle.toggleClass("active");
                });

                //are we in production or development?
                if (window.location.host === "localhost") {
                    LN.webRoot = "/wordpress/";
                }

                //Foundation .block-grid fixes for IE 8
                $(".block-grid.two-up>li:nth-child(2n+1)").css({clear: "both"});
                $(".block-grid.three-up>li:nth-child(3n+1)").css({clear: "both"});
                $(".block-grid.four-up>li:nth-child(4n+1)").css({clear: "both"});
                $(".block-grid.five-up>li:nth-child(5n+1)").css({clear: "both"});
            },

            finalize : function () {

                var $footerWidgets = $("#footer-content").find(".widget");

                UTIL.equalHeight($footerWidgets);
            }

        },
        /**
        * page specific objects - defined by classes attached to body
        * class.init is called first, followed by class.id
        *
        */

        "s-category-portfolio" : {
            init : function () {
                var $slider = $(".bx-slider"),
                    sliderInit = function () {
                        $slider.bxSlider();
                    };
                yepnope({
                    load: LN.webRoot + LN.jsRoot + LN.scripts.bxSlider + LN.cacheBust,
                    callback: sliderInit
                });
            }
        },

        /**
         *
         *This needs a towel DRY
        */
        wp : {
            blog : function () {

            },
            about : function () {

            },
            contact : function () {

            },
            portfolio : function () {

                $(".project").hover(function (e) {
                    var $self = $(this),
                        $overlay = $self.find(".overlay");

                    $overlay.addClass("fade");

                }, function (e) {
                    var $self = $(this),
                        $overlay = $self.find(".overlay");

                    $overlay.removeClass("fade");
                });

                yepnope({
                    load: LN.webRoot + LN.jsRoot + LN.scripts.isotope + LN.cacheBust,
                    callback: LN.isotopeInit
                });
            }
        },
        home : {
            init: function () {

                var $slider = $(".bx-slider"),
                    sliderInit = function () {
                        $slider.bxSlider();
                    };
                yepnope({
                    load: LN.webRoot + LN.jsRoot + LN.scripts.bxSlider + LN.cacheBust,
                    callback: sliderInit
                });
            }
        }
    },
    /**
     *
     * global object containing useful utility functions
     *
     */
    UTIL = {
        /**
         *
         * fire functions defined in LN
         * @param {string - the class of the page}
         * @param {string - id of page, optional}
         * @param {string - arguments for fn being called}
         *
         */
        fire : function (func, funcname, args) {

            var namespace = LN;

            //if funcaname is undefined, funcname = init, else  funcname = funcname
            funcname = (funcname === undefined) ? "init" : funcname;

            if (func !== "" && namespace[func] && typeof namespace[func][funcname] === "function") {
                //console.log("UTIL.fire is calling: LN." + func + "." + funcname);
                namespace[func][funcname](args);
            }
        },
        /**
         *
         * fire functions from body classes and id
         *
         */
        loadEvents : function () {

            var bodyId = document.body.id,
                classnames = document.body.className.split(/\s+/);

            // hit up common first.
            UTIL.fire("common");

            // do all the classes too.
            $.each(classnames, function (i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, bodyId);
            });

            UTIL.fire("common", "finalize");
        },
        /**
         *
         * set all elements to the same height as the tallest
         * @param {object} jQuery object of elements to equalise heights of
         * @retun {object} The equalised group
         *
         */
        equalHeight : function (group) {

            var tallest = 0;

            group.each(function () {
                var thisHeight = $(this).height();

                if (thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });

            group.height(tallest);

            return group;
        }
    }; //end global vars

//kick it all off here
UTIL.loadEvents();
