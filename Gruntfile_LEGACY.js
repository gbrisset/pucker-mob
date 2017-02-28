// THIS is the legacy version supposed to run to prep files for production
// for some reason some issues were met while running and the whole thing set aside
// GB - 2017-02-28

module.exports = function(grunt) {
  grunt.initConfig({
    
    pkg: grunt.file.readJSON('package.json'),

// Temporarily disabled because npm install node-sass runs into errors - GB 2017-02-28
    // sass: {
    //   options: {
    //     includePaths: ['bower_components/foundation/scss']
    //   },
    //   dist: {
    //     options: {
    //       outputStyle: 'compressed'
    //     },
    //     files: {
    //       'httpdocs/assets/css/app.css': 'httpdocs/assets/scss/app.scss',
    //       'httpdocs/assets/css/appadmin.css': 'httpdocs/assets/scss/appadmin.scss'
    //     }        
    //   }
    // },

    browserify: {
      dev: {
        options: {
          debug: true,
          transform: ['reactify']
        },
        files: {
          'httpdocs/assets/js/app_test.js': 'httpdocs/assets/jsx/**/*.jsx'
        }
      },
      build: {
        options: {
          debug: false,
          transform: ['reactify']
        },
        files: {
          'httpdocs/assets/js/app_test.js': 'httpdocs/assets/jsx/**/*.jsx'
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
    
    watch: {
      grunt: { files: ['Gruntfile.js'] },
      
// Temporarily disabled because npm install node-sass runs into errors - GB 2017-02-28
      // sass: {
      //   files: 'httpdocs/assets/scss/**//*.scss',
      //   tasks: ['sass'],
      //   options: { livereload: true,
      //   }
      // },

      //browserify: {
        //files: ['httpdocs/assets/js/**/*.js', 'httpdocs/assets/jsx/**/**/*.jsx'],
        //tasks: ['browserify:dev'],
        // options: {
        //  livereload: true,
        //}
      //},
    }

  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-browserify');

  grunt.registerTask('build', ['sass']);
  grunt.registerTask('jscompress', ['uglify']);
  grunt.registerTask('csscompress', ['cssmin']);
  grunt.registerTask('default', ['watch', 'cssmin', 'uglify']);
}