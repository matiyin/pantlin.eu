// Gruntfile.js

// our wrapper function (required by grunt and its plugins)
// all configuration goes inside this function
module.exports = function(grunt) {

  // ===========================================================================
  // CONFIGURE GRUNT ===========================================================
  // ===========================================================================
  grunt.initConfig({

    // get the configuration info from package.json ----------------------------
    // this way we can use things like name and version (pkg.name)
    pkg: grunt.file.readJSON('package.json'),

    // configure jshint to validate js files -----------------------------------
    jshint: {
      all: ['../js/general.js'],
      options: {
        globals: {
          jQuery: true
        }
      }
    },

    // configure uglify to minify js files -------------------------------------
    uglify: {
      options: {
        banner: '/*\n <%= pkg.name %> App | Copyright <%= grunt.template.today("yyyy") %> Studio Parkers | www.studioparkers.nl\nBuild Date: <%= grunt.template.today("dd-mm-yyyy") %> \n*/\n'
      },
      build: {
        files: {
          '../js/general.min.js': '../js/general.js'
        }
      }
    },

    compass: {
      dist: {
        options: {
          sassDir: '../scss/dist',
          cssDir: '../css/dist',
          environment: 'production',
          outputStyle: 'compressed'
        }
      },
      dev: {
        options: {
          sassDir: '../scss/dev',
          cssDir: '../css/dev',
          environment: 'development',
          outputStyle: 'expanded'
        }
      }      
    },

    realFavicon: {
      favicons: {
        src: 'favicon_master.png',
        dest: '../img/favicon',
        options: {
          iconsPath: '/',
          html: [ '../favicon.html' ],
          design: {
            ios: {
              pictureAspect: 'backgroundAndMargin',
              backgroundColor: '#ffffff',
              margin: '14%',
              assets: {
                ios6AndPriorIcons: false,
                ios7AndLaterIcons: false,
                precomposedIcons: false,
                declareOnlyDefaultIcon: true
              }
            },
            desktopBrowser: {},
            windows: {
              pictureAspect: 'noChange',
              backgroundColor: '#da532c',
              onConflict: 'override',
              assets: {
                windows80Ie10Tile: false,
                windows10Ie11EdgeTiles: {
                  small: false,
                  medium: true,
                  big: false,
                  rectangle: false
                }
              }
            },
            androidChrome: {
              pictureAspect: 'noChange',
              themeColor: '#ffffff',
              manifest: {
                display: 'standalone',
                orientation: 'notSet',
                onConflict: 'override',
                declared: true
              },
              assets: {
                legacyIcon: false,
                lowResolutionIcons: false
              }
            },
            safariPinnedTab: {
              pictureAspect: 'silhouette',
              themeColor: '#5bbad5'
            }
          },
          settings: {
            scalingAlgorithm: 'Mitchell',
            errorOnImageTooSmall: false
          }
        }
      }
    },

    watch: {
      css: {
        files: ['../scss/dev/*.scss'],
        tasks: ['compass:dev'],
        options: {
        },
      },
      js: {
        files: ['../js/general.js','../js/ajax.js'],
        tasks: ['jshint'],
        options: {
        },
      },
      // templates: {
      //   files: ['views/precompiled/*.hbs'],
      //   tasks: ['handlebars'],
      //   options: {
      //   },
      // },
    },


    // configure template
    // handlebars: {
    //   compile: {
    //     options: {

    //       // configure a namespace for your templates
    //       namespace: 'getTemplate',

    //       // convert file path into a function name
    //       processName: function(filePath) {
    //         var pieces = filePath.split('/');
    //         return pieces[pieces.length - 1].split('.')[0];
    //       }

    //     },

    //     // output file: input files
    //     files: {
    //       '../js/templates.js': 'dev/views/precompiled/*.hbs'
    //     }
    //   }
    // },

  });
  
  grunt.registerTask('build', [
    //'useminPrepare',
    //'bower_concat',
    //'cssmin:generated',
    'compass:dist',
    'uglify',
    //'filerev',
    //'usemin',
    //'copy'
  ]);

  grunt.registerTask('default', ['build']);

  // ===========================================================================
  // LOAD GRUNT PLUGINS ========================================================
  // ===========================================================================
  // we can only load these if they are in our package.json
  // make sure you have run npm install so our app can find these
  grunt.loadNpmTasks('grunt-contrib-jshint'); //js error linter
  grunt.loadNpmTasks('grunt-contrib-uglify'); //js minify
  grunt.loadNpmTasks('grunt-contrib-watch'); //file watcher and livereload
  //grunt.loadNpmTasks('grunt-contrib-handlebars'); //templating
  grunt.loadNpmTasks('grunt-contrib-compass'); //sass compiler
  //grunt.loadNpmTasks('grunt-wiredep'); //bower injector
  //grunt.loadNpmTasks('grunt-contrib-concat'); //js concatenate
  //grunt.loadNpmTasks('grunt-bower-concat');
  grunt.loadNpmTasks('grunt-real-favicon');
};
