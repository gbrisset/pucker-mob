module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        includePaths: ['bower_components/foundation/scss']
      },
      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'httpdocs/assets/css/app.css': 'httpdocs/assets/scss/app.scss',
          'httpdocs/assets/css/appadmin.css': 'httpdocs/assets/scss/appadmin.scss'
        }        
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },
      html: {
        files: ['*.html'],
        options: {
          livereload: true,
        }
      },
     
      sass: {
        files: 'httpdocs/assets/scss/**//*.scss',
        tasks: ['sass'],
        options: {
          livereload: true,
        }
      }
    },

    uglify: {
      options: {
        mangle: false,
        livereload: true,
      },
     
      jscompress: {
        files: {
          'httpdocs/assets/js/app.min.js': ['httpdocs/assets/js/plugins.js', 'httpdocs/assets/js/app.js', 'httpdocs/assets/js/js_scroll.js']
        }
      }
    },
   
    cssmin: {
      options: {
        shorthandCompacting: false,
        roundingPrecision: -1
      },
   
      target: {
        files: {
          'httpdocs/assets/css/app.min.css': ['httpdocs/assets/css/app.css']
        }
      }
    },

    browserify:     {
      options:      {
        transform:  [ require('grunt-react').browserify ]
      },
      app:          {
        src:        'path/to/source/main.js',
        dest:       'path/to/target/output.js'
      }
    },

      react: {
        files: {
          expand: true,
          cwd: 'httpdocs/assets/jsx/',
          src: ['**/*.jsx'],
          dest: 'phttpdocs/assets/js/',
          ext: '.js'
        }
      }
    
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-react');
  grunt.loadNpmTasks('grunt-browserify');

  grunt.registerTask('build', ['sass']);
  grunt.registerTask('jscompress', ['uglify']);
  grunt.registerTask('csscompress', ['cssmin']);
  grunt.registerTask('default', ['build','watch']);
}