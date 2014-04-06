/**
 * Created by jota on 06/04/14.
 */
module.exports = function(grunt) {

    var jsPath = 'public/**/*.js';
    var libsPath = 'public/assets/js/libs/*.js';
    var testPath = 'test/**/*.js';

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                separator: ';'
            },
            main: {
                src: [jsPath],
                dest: 'public/main.js'
            },
            libs: {
                src: [libsPath],
                dest: 'public/assets/js/libs/libs.js'
            }
        },

        jshint: {
            files: ['Gruntfile.js', jsPath,testPath],
            options: {
                globals: {
                    console: true,
                    module: true,
                    document: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');

    grunt.registerTask('hint', ['jshint']);
    grunt.registerTask('concatAll', ['concat']);

};