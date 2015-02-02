module.exports = function(grunt) {
    'use strict';
    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take. Can help when optimizing build times
    require('time-grunt')(grunt);

    grunt.loadNpmTasks('grunt-rev');

    grunt.initConfig({

        // Project settings
        config: {
            // Configurable paths
            app: 'assets/app',
            dist: 'assets/dist',
            theme: ''
        },

        //
        watch: {
            sass: {
                files: ['assets/app/styles/**/*.{scss,sass}'],
                tasks: ['sass', 'autoprefixer']
            },
            livereload: {
                options: {
                    livereload: true
                },
                files: ['style.css', 'assets/app/scripts/*.js', '*.html', '*.php', 'assets/app/i/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        sass: {
            options: {
                sourceMap: true,
                imagePath : '<%= config.app %>/i'
            },
            dist: {
                files: {
                    '<%= config.app %>/css/style.css': '<%= config.app %>/styles/style.scss'
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
                    cwd: '<%= config.app %>/css/',
                    src: '{,*/}*.css',
                    dest: '<%= config.app %>/css/'
                }]
            }
        },

        // creates a minified css file in dist dir
        cssmin: {

            dist1: {
                files: {
                    '<%= config.app %>/css/style.min.css': [
                        '<%= config.app %>/styles/style.css'
                    ]
                }
            },
            production: {
                expand: true,
                cwd: '<%= config.app %>/css',
                src: ['*.css'],
                dest: '<%= config.dist %>/css'
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
                        'scripts/vendor/modernizr.js'
                    ]
                }]
            }
        },

        // Empties folders to start fresh
        clean: {
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '.tmp',
                        '<%= config.dist %>/*',
                        '!<%= config.dist %>/.git*'
                    ]
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

        // uglify modernizr
        uglify: {
            main: {
                options: {

                },
                files: {
                    '<%= config.dist %>/scripts/vendor/modernizr.js': [
                        '<%= config.app %>/scripts/vendor/modernizr.js'
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

        grunticon: {
            social: {
                files: [{
                    expand: true,
                    cwd: '<%= config.app %>/i/svg/social/src',
                    src: ['*.svg', '*.png'],
                    dest: '<%= config.app %>/assets/svg/social/dist'
                }],
                options: {}
            }
        },

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



        wpRev: {
            options: {
                encoding: 'utf8',
                algorithm: 'md5',
                length: 8,
                file: 'header.php'
            },
            assets: {
                files: [{
                    src: [
                        'scripts/{,*/}*.js',
                        'assets/app/css/{,*/}*.css',
                        'img/**/*.{jpg,jpeg,gif,png}',
                        'fonts/**/*.{eot,svg,ttf,woff}'
                    ]
                }]
            }
        }

    });

    // rename tasks
    grunt.renameTask('rsync', 'deploy');

    grunt.registerTask('images', ['newer:imagemin:dist']);

    grunt.registerTask('svg', 'grunticon:social');

    grunt.registerTask('build', [
        //'grunticon:social'
        'clean',
        'jshint',
        'sass',
        'autoprefixer',
        'cssmin:production',
        'requirejs',
        'images',
        'copy',
        'uglify'
    ]);

    // register task
    grunt.registerTask('default', ['build']);

    grunt.registerTask('dev', ['watch']);

    grunt.registerTask('pagespeed', ['pagespeed']);

};
