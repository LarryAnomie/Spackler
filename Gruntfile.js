
module.exports = function(grunt) {
    "use strict";
    // load all grunt tasks matching the `grunt-*` pattern
    require("load-grunt-tasks")(grunt);

    grunt.initConfig({

        // watch for changes and trigger compass, jshint, uglify and livereload
        watch: {
            compass: {
                files: ["assets/sass/**/*.{scss,sass}"],
                tasks: ["compass"]
            },
            js: {
                files: "assets/js/script.js",
                tasks: ["jshint", "uglify"]
            },
            livereload: {
                options: { livereload: false },
                files: ["style.css", "assets/js/*.js", "*.html", "*.php", "assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}"]
            }
        },

        // compass and scss
        compass: {
            dist: {
                options: {
                    config: "config.rb",
                    force: true
                }
            }
        },

        // javascript linting with jshint
        jshint: {
            options: {
                jshintrc: ".jshintrc",
                "force": true
            },
            all: [
                "Gruntfile.js",
                "assets/js/script.js"
            ]
        },

        // uglify to concat, minify, and make source maps
        uglify : {
            main : {
                options : {
                    sourceMap: "assets/js/script.js.map",
                    sourceMappingURL: "script.js.map",
                    sourceMapPrefix: 2
                },
                files : {
                    "assets/js/script.min.js": [
                        "assets/js/script.js" //,
                        // "assets/js/vendor/yourplugin/yourplugin.js",
                    ]
                }
            }
        },

        // image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: "assets/i/",
                    src: "**/*",
                    dest: "assets/i/compressed"
                }]
            }
        },

        // deploy via rsync
        deploy: {
            options: {
                src: "./",
                args: ["--verbose"],
                exclude: [".git*", "node_modules", ".sass-cache", "Gruntfile.js", "package.json", ".DS_Store", "README.md", "config.rb", ".jshintrc"],
                recursive: true,
                syncDestIgnoreExcl: true
            },
            staging: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@host.com"
                }
            },
            production: {
                options: {
                    dest: "~/path/to/theme",
                    host: "user@host.com"
                }
            }
        }

    });

    // rename tasks
    grunt.renameTask("rsync", "deploy");

    // register task
    grunt.registerTask("default", ["watch"]);

};
