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
        css: {
          
          files: 'httpdocs/assets/scss/**/*.scss',
          tasks: ['sass'],
          
          options:{

          }
          
        }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('dev', ['watch:css']);
  grunt.registerTask('default', ['sass']);
}


