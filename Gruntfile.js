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
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('build', ['sass']);
  grunt.registerTask('default', ['build','watch']);
}
/*
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
          'css/app.css': 'scss/app.scss'
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
        files: 'scss/**//*.scss',
        tasks: ['sass'],
        options: {
          livereload: true,
  }
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('build', ['sass']);
  grunt.registerTask('default', ['build','watch']);
}

}*/

