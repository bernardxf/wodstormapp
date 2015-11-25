module.exports = function(grunt) {

    // Autoload modules do package.json
    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        // Pastas Padronizadas

        meta: {
            development: {
                raiz: 'development/',
                fonts: 'development/www/assets/fonts/',
                images: 'development/www/assets/images/',
                scripts: 'development/www/assets/scripts/'
            },
            test: {
                raiz: 'test/',
                fonts: '<%= meta.test.raiz %>/www/assets/fonts/',
                images: '<%= meta.test.raiz %>/www/assets/images/',
                scripts: '<%= meta.test.raiz %>/www/assets/scripts/'
            },
            build: {
                raiz: 'build/',
                fonts: '<%= meta.build.raiz %>/www/assets/fonts/',
                images: '<%= meta.build.raiz %>/www/assets/images/'
            },
            resources: {
                raiz: 'resources/',
                images: 'resources/images/'
            }
        },

        // Limpando Pastas

        clean: {
            images: {
                src: ["<%= meta.development.images %>"]
            },
            test: {
                src: ["<%= meta.test.raiz %>"]
            },
            build: {
                src: ["<%= meta.build.raiz %>"]
            }
        },

        // Criação das Imagens Minificadas para inicialização do Desenvolvimento

        imagemin: {
            options: {
                optimizationLevel: 7,
                progressive: true
            },
            development: {
                files: [{
                    expand: true,
                    cwd: '<%= meta.resources.images %>',
                    src: ['**/*.{png,jpg,jpeg}'],
                    dest: '<%= meta.development.images %>'
                }]
            }
        },

        /**
         * Copiar alguns arquivos necessários
         */
        copy: {
            // Copiando arquivos da Build de Teste
            test: {
                files: [{
                    expand: true,
                    cwd: '<%= meta.development.fonts %>',
                    src: ['**'],
                    dest: '<%= meta.test.fonts %>'
                }, {
                    expand: true,
                    cwd: '<%= meta.development.images %>',
                    src: ['**'],
                    dest: '<%= meta.test.images %>'
                }, {
                    expand: true,
                    cwd: '<%= meta.development.scripts %>',
                    src: ['**'],
                    dest: '<%= meta.test.scripts %>'
                }, {
                    expand: true,
                    cwd: '<%= meta.development.raiz %>server',
                    src: ['**'],
                    dest: '<%= meta.test.raiz %>server'
                }, {
                    expand: true,
                    cwd: '<%= meta.development.raiz %>',
                    src: ['index.php', '.htaccess'],
                    dest: '<%= meta.test.raiz %>'
                }]
            },

            // Copiando arquivos da Build de Produção
            build: {
                files: [{
                    expand: true,
                    cwd: '<%= meta.development.fonts %>',
                    src: ['**'],
                    dest: '<%= meta.build.fonts %>'
                }, {
                    expand: true,
                    cwd: '<%= meta.development.images %>',
                    src: ['**'],
                    dest: '<%= meta.build.images %>'
                }]
            }
        },

        // Compila jade para html

        jade: {
          build: {
            // options: {
            //   pretty: true,
            //   data: function(dest, src) { return require('./development/www/assets/scripts/textos.json'); },
              
            // },
            files: [{
              expand: true,
              cwd: '<%= meta.development.raiz %>',
              src: ['**/*.jade'],
              dest: '<%= meta.build.raiz %>',
              ext: '.html'
            }]
          },
          test: {
            // options: {
            //   pretty: true,
            //   data: function(dest, src) { return require('./development/www/assets/scripts/textos.json'); },
              
            // },
            files: [{
              expand: true,
              cwd: '<%= meta.development.raiz %>/www/jade/',
              src: ['**/*.jade'],
              dest: '<%= meta.test.raiz %>/www',
              ext: '.html'
            }]
          }
        },

        // Minifica o Javascript

        uglify: {
          options: {
            banner: '// <%= grunt.template.today("dd-mm-yyyy") %> \n'
          },
          test: {
            src: ['<%= meta.development.raiz %>www/assets/scripts/*.js'],
            dest: '<%= meta.test.raiz %>www/assets/scripts/main.js'
          },
          build: {
              src: ['<%= meta.development.raiz %>www/assets/scripts/*.js'],
              dest: '<%= meta.build.raiz %>www/assets/scripts/main.js'
          }
        },

        // Stylus CSS
        stylus: {
          test: {
            options: {
                compress: false,
                paths: ['stylus']
            },
            files: {
                '<%= meta.test.raiz %>www/assets/styles/main.css': ['<%= meta.development.raiz %>www/assets/styl/main.styl']
            }
          },
          build: {
            options: {
                paths: ['stylus']
            },
            files: {
                '<%= meta.build.raiz %>www/assets/styles/main.css': ['<%= meta.development.raiz %>www/assets/styl/main.styl']
            }
          }
        },

        watch: {
            css: {
                files: '<%= meta.development.raiz %>www/**/*.styl',
                tasks: ['stylus:test']
            },
            js: {
                files: '<%= meta.development.raiz %>www/**/*.js',
                tasks: ['uglify:test']
            },
            html: {
                files: '<%= meta.development.raiz %>www/**/*.jade',
                tasks: ['jade:test']
            }
        }
    });

    /**
     * Comandos
     */


      // Inicialização do imagemin para desenvolvimento
      grunt.registerTask('minificarImagem', ['clean:images', 'imagemin']);

      // Teste
      grunt.registerTask('test', [
        'clean:test',
        'copy:test',
        'stylus:test',
        'uglify:test',
        'jade:test',
        'watch'
      ]);

    // Build
};