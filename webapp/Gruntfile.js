module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            dev: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'assets/css/custom.css': 'assets/dev/style/style.scss'
                }
            },
            prod: {
                options: {
                    style: 'compressed'
                },
                files: {
                    'assets/css/custom.css': 'assets/dev/style/style.scss'
                }
            }
        },
        concat: {
            js_libs: {
                options: {
                    style: 'compressed'
                },
                files: {
                    'assets/js/components.js': [
                        'bower_components/handlebars/handlebars.min.js'
                    ]
                }
            },
            css_libs: {
                options: {
                    style: 'compressed'
                },
                files: {
                    'assets/css/components.css': [

                    ]
                }
            }
        },
        notify: {
            libs: {
                options: {
                    title: 'Libs',
                    message: 'Javascript Libraries concatenated!',
                }
            },
            scripts: {
                options: {
                    title: 'Scripts',
                    message: 'Javascript checked & concatenated!',
                }
            },
            styles: {
                options: {
                    title: 'Styles',
                    message: 'Scss compiled & autoprefixed!',
                }
            },
            jades: {
                options: {
                    title: 'Jades',
                    message: 'Jade compiled!',
                }
            },
            images: {
                options: {
                    title: 'Images',
                    message: 'Images minified!',
                }
            },
            svg: {
                options: {
                    title: 'Svg',
                    message: 'Svg minified!',
                }
            },
            copy: {
                options: {
                    title: 'Copy',
                    message: 'Root objects copied!',
                }
            }
        },
        watch: {
            options: {
                livereload: true,
                spawn: true
            },
            styles: {
                files: ['assets/dev/style/*.scss'],
                tasks: ['sass:dev', 'notify:styles']
            },
        }
    });

    grunt.loadNpmTasks('grunt-notify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-jade');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-coffee');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-coffeelint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-svgmin');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');

    grunt.registerTask('dev', ['concat', 'sass:dev', 'watch']);
    grunt.registerTask('prod', ['concat', 'sass:prod']);
};
