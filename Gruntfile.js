module.exports = function(grunt) {
    'use strict';
    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

    grunt.initConfig({

        // Project settings
        config: {
            // Configurable paths
            app: 'assets/app',
            dist: 'assets/dist',
            theme: '/wp-content/themes/spackler'
        },

        // watch for changes and trigger compass, jshint, uglify and livereload
        watch: {
            compass: {
                files: ['assets/app/styles/**/*.{scss,sass}'],
                tasks: ['compass', 'autoprefixer']
            },
            livereload: {
                options: {
                    livereload: true
                },
                files: ['style.css', 'assets/app/scripts/*.js', '*.html', '*.php', 'assets/app/i/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // compass and scss

        compass: {
            options: {
                sassDir: '<%= config.app %>/styles',
                cssDir: '<%= config.app %>/css',
                generatedImagesDir: '.tmp/i/generated',
                imagesDir: '<%= config.app %>/i',
                javascriptsDir: '<%= config.app %>/scripts',
                fontsDir: '<%= config.app %>/fonts',
                importPath: '<%= config.app %>/bower_components',
                httpImagesPath: '<%= config.theme %>/assets/dist/i',
                httpGeneratedImagesPath: '/assets/i/generated',
                httpFontsPath: '/fonts',
                relativeAssets: false,
                assetCacheBuster: false
            },
            dist: {
                options: {
                    generatedImagesDir: '<%= config.dist %>/assets/images/generated',
                    cssDir: '<%= config.dist %>/css',
                    outputStyle: 'compressed'
                }
            },
            server: {
                options: {
                    debugInfo: true
                }
            }
        },

        // Add vendor prefixed styles
        autoprefixer: {
            options: {
                browsers: ['last 1 version']
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= config.dist %>/css/',
                    src: '{,*/}*.css',
                    dest: '<%= config.dist %>/css/'
                }]
            }
        },

        // javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                'force': true
            },
            all: [
                'Gruntfile.js',
                '<%= config.app %>/scripts/*.js',
                '!<%= config.app %>/scripts/require.js'
            ]
        },

        pagespeed: {
            options: {
                nokey: true,
                url: 'http://lawrencenaman.com',
                strategy: 'mobile'
            }
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            main: {
                options: {
                    sourceMap: 'assets/js/script.js.map',
                    sourceMappingURL: 'script.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'assets/js/dist/script.min.js': [
                        'assets/js/script.js' //,
                        // 'assets/js/vendor/yourplugin/yourplugin.js',
                    ]
                }
            }
        },

        // image optimization
        imagemin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= config.app %>/i/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '<%= config.dist %>/i/'
                }]
            }
        },

/*        grunticon: {
            social: {
                files: [{
                    expand: true,
                    cwd: '<%= config.app %>/i/svg/social/src',
                    src: ['*.svg', '*.png'],
                    dest: '<%= config.app %>/assets/svg/social/dist'
                }],
                options: {}
            }
        },*/

        // pretty standard require set up - use almond in production
        // removes combined files - good for Cordova apps
        requirejs: {
            compile: {
                options: {
                    removeCombined: true,
                    include: ['main'],
                    optimize: 'uglify',
                    findNestedDependencies: true, // this is need because of seperate config and main files
                    baseUrl: '<%= config.app %>/scripts/',
                    mainConfigFile: '<%= config.app %>/scripts/require-config.js',
                    name: '../bower_components/almond/almond', // base path is app/assets/scripts
                    out: '<%= config.dist %>/scripts/main.js',
                    preserveLicenseComments: false,
                    uglify: {
                       preserveComments: false
                    }
                }
            }
        },

        cssmin: {
            options : {
                keepSpecialComments : 0
            },
            dist: {
                files: {
                    '<%= config.dist %>/css/style.css': [
                        '.tmp/styles/{,*/}*.css',
                        '<%= config.app %>/styles/{,*/}*.css'
                    ]
                }
            }
        },

        // Copies remaining files to places other tasks can use
        copy: {
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= config.app %>',
                    dest: '<%= config.dist %>',
                    src: [
                        'fonts/{,*/}*.*',
                    ]
                }]
            }
        },

        // deploy via rsync
        deploy: {
            options: {
                src: './',
                args: ['--verbose'],
                exclude: [
                    '.git*',
                    'node_modules',
                    '.sass-cache',
                    'Gruntfile.js',
                    'package.json',
                    '.DS_Store',
                    'README.md',
                    'config.rb',
                    '.jshintrc'
                ],
                recursive: true,
                syncDestIgnoreExcl: true
            },
            staging: {
                options: {
                    dest: '~/path/to/theme',
                    host: 'user@host.com'
                }
            },
            production: {
                options: {
                    dest: '~/path/to/theme',
                    host: 'user@host.com'
                }
            }
        }

    });

    // rename tasks
    grunt.renameTask('rsync', 'deploy');

    grunt.registerTask('images', ['newer:imagemin:dist']);

    grunt.registerTask('svg', 'grunticon:social');

    grunt.registerTask('build', [
        //'grunticon:social'
        'jshint',
        'compass:dist',
        'autoprefixer',
        'cssmin',
        'requirejs',
        'images',
        'copy'
    ]);

    // register task
    grunt.registerTask('default', ['build']);

    grunt.registerTask('pagespeed', ['pagespeed']);

};
