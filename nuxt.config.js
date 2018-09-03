const pkg = require('./package')

const nodeExternals = require('webpack-node-externals')

module.exports = {
  mode: 'spa',

  env: {
    updateConversationsInterval : 10000,
	  updateNotificationsInterval : 20000,
    head : {
      title : 'Admin',
	    metaInfo: {
		    base: { href: '/' }
	    }
    }
  },

	srcDir : 'resources/spa/admin/',
	generate : {
  	dir : 'static/spa/admin/'
	},
	
  /*
  ** Headers of the page
  */
  head: {
	  titleTemplate: 'Admin | %s',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: pkg.description }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' }
    ]
  },

  /*
  ** Customize the progress-bar color
  */
  loading: { color: '#78aaff', height: '5px' },
	loadingIndicator: {
    name: 'circle',
    color: '#78aaff',
  },
  
	router: {
		mode: 'hash',
    /*
    extendRoutes(routes, resolve){
		  routes.push({
        path: '*',
        component: resolve(__dirname, 'pages/index.vue')
      })
    }
    */
	},
  
  transition: {
    name: 'fade',
    mode: 'out-in'
  },
  
  /*
  ** Global CSS
  */
  css: [
    'vuetify/src/stylus/main.styl',
    '@/assets/index.scss'
  ],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
	  '@/plugins/global-components.js',
    '@/plugins/vuetify',
  ],

  /*
  ** Nuxt.js modules
  */
  modules: [
	  '@nuxtjs/proxy',
	  '@nuxtjs/toast',
  ],
	
	auth: {
		// Options
	},
	
	proxy: {
		'/api': { target: 'http://adrnuxtsandbox', ws: false }
	},
  
  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
      // Run ESLint on save
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
      if (ctx.isServer) {
        config.externals = [
          nodeExternals({
            whitelist: [/^vuetify/]
          })
        ]
      }
    }
  }
}
