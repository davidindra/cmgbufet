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

    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: 'www/js/main.js',
        dest: 'www/js/main.min.js'
      }
    },

    watch: {
      JS: {
        files: 'www/js/*.js',
        tasks: ['uglify']
      }
    },

    copy: {
      main: {
        files: [
          {
            expand: true,
            flatten: true,
            src: [
              'bower_components/jquery/dist/jquery.js',
              'bower_components/jquery/dist/jquery.min.js',
              'bower_components/jquery/dist/jquery.min.map',
              'bower_components/materialize/dist/js/*.js',
            ],
            dest: 'www/js'
          },
          {
            expand: true,
            flatten: true,
            src: [
              'bower_components/materialize/dist/css/*.css'
            ],
            dest: 'www/css'
          },
        ],
      },
    }

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-copy');

  // default task
  grunt.registerTask('default', ['uglify', 'copy']);

};
