module.exports = function(grunt) {

  // project configuration
  grunt.initConfig({

    // metadata
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.name %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;\n',

    // task configuration here

    watch: {
      CSS: {
        files: 'www/css/src/*.sass',
        tasks: ['sass']
      },
      JS: {
        files: 'www/js/src/*.js',
        tasks: ['uglify']
      }
    },

    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        sourceMap: true
      },
      build: {
        expand: true,
        flatten: true,
        src: ['www/js/src/*.js'],
        dest: 'www/js/dist/',
        ext: '.min.js'
      }
    },

    sass: {
      build: {
        options: {
          //style: 'expanded'
          style: 'compressed'
        },
        files: [{
          expand: true,
          flatten: true,
          src: ['www/css/src/*.sass'],
          dest: 'www/css/dist/',
          ext: '.min.css'
        }]
      }
    },

    copy: {
      dependencies: {
        files: [
          {
            expand: true,
            flatten: true,
            src: [
              'bower_components/jquery/dist/jquery.min.js',
              'bower_components/jquery/dist/jquery.min.map',
              'bower_components/materialize/dist/js/materialize.min.js',
              'bower_components/nette.ajax.js/nette.ajax.js',
              'bower_components/nette.ajax.js/extensions/fidRemove.ajax.js',
              'bower_components/nette.ajax.js/extensions/spinner.ajax.js',
              'vendor/vojtech-dobes/nette-ajax-history/client-side/history.ajax.js'
            ],
            dest: 'www/js/ext'
          },
          {
            expand: true,
            flatten: true,
            src: [
              'bower_components/materialize/dist/css/*.css'
            ],
            dest: 'www/css/ext'
          },
          {
            expand: true,
            flatten: true,
            src: [
              'bower_components/materialize/dist/fonts/roboto/*'
            ],
            dest: 'www/css/fonts/roboto'
          }
        ],
      },
    }

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-sass');

  // default task
  grunt.registerTask('default', ['uglify', 'sass', 'copy']);

};
