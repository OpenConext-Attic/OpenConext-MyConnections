module.exports = function(grunt) {

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    require('load-grunt-tasks')(grunt); // npm install --save-dev load-grunt-tasks

    grunt.initConfig({

        // sass
        sass: {
            dev: {
                options: {
                    sourceMap: true,
                    style: 'nested'
                },
                files: [
                    {
                        expand: true,
                        cwd: 'scss/',
                        src: ['**/*.scss', '!style.scss'],
                        dest: 'css/',
                        ext: '.css'
                    },
                    {src: 'scss/style.scss', dest: 'css/style.css'}
                ]
            },
            min: {
                options: {
                    sourceMap: false,
                    outputStyle: 'compressed'
                },
                files: [
                    {
                        expand: true,
                        cwd: 'scss/',
                        src: ['**/*.scss', '!style.scss'],
                        dest: 'css/',
                        ext: '.min.css'
                    },
                    {src: 'scss/style.scss', dest: 'css/style.min.css'}
                ]
            }
        },

        //watcher project
        watch: {
            css: {
                files: ['scss/**/*.scss'],
                tasks: ['sass:dev'],
                options: {
                    spawn: false,
                }
            }
        },

        jshint: {
            files: ['Gruntfile.js', 'js/**/*.js'],
            options: {
                globals: {
                    jQuery: true
                }
            }
        }
    });

    grunt.registerTask('default', ['sass:dev', 'sass:min']);
};
