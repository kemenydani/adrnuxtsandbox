import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const _1aeefd4d = () => import('..\\pages\\user\\index.vue' /* webpackChunkName: "pages_user_index" */).then(m => m.default || m)
const _5383fb34 = () => import('..\\pages\\article\\index.vue' /* webpackChunkName: "pages_article_index" */).then(m => m.default || m)
const _f379a160 = () => import('..\\pages\\auth\\index.vue' /* webpackChunkName: "pages_auth_index" */).then(m => m.default || m)
const _3a667e80 = () => import('..\\pages\\inspire.vue' /* webpackChunkName: "pages_inspire" */).then(m => m.default || m)
const _ded8b810 = () => import('..\\pages\\index.vue' /* webpackChunkName: "pages_index" */).then(m => m.default || m)



if (process.client) {
  window.history.scrollRestoration = 'manual'
}
const scrollBehavior = function (to, from, savedPosition) {
  // if the returned position is falsy or an empty object,
  // will retain current scroll position.
  let position = false

  // if no children detected
  if (to.matched.length < 2) {
    // scroll to the top of the page
    position = { x: 0, y: 0 }
  } else if (to.matched.some((r) => r.components.default.options.scrollToTop)) {
    // if one of the children has scrollToTop option set to true
    position = { x: 0, y: 0 }
  }

  // savedPosition is only available for popstate navigations (back button)
  if (savedPosition) {
    position = savedPosition
  }

  return new Promise(resolve => {
    // wait for the out transition to complete (if necessary)
    window.$nuxt.$once('triggerScroll', () => {
      // coords will be used if no selector is provided,
      // or if the selector didn't match any element.
      if (to.hash) {
        let hash = to.hash
        // CSS.escape() is not supported with IE and Edge.
        if (typeof window.CSS !== 'undefined' && typeof window.CSS.escape !== 'undefined') {
          hash = '#' + window.CSS.escape(hash.substr(1))
        }
        try {
          if (document.querySelector(hash)) {
            // scroll to anchor by returning the selector
            position = { selector: hash }
          }
        } catch (e) {
          console.warn('Failed to save scroll position. Please add CSS.escape() polyfill (https://github.com/mathiasbynens/CSS.escape).')
        }
      }
      resolve(position)
    })
  })
}


export function createRouter () {
  return new Router({
    mode: 'hash',
    base: '/',
    linkActiveClass: 'nuxt-link-active',
    linkExactActiveClass: 'nuxt-link-exact-active',
    scrollBehavior,
    routes: [
		{
			path: "/user",
			component: _1aeefd4d,
			name: "user"
		},
		{
			path: "/article",
			component: _5383fb34,
			name: "article"
		},
		{
			path: "/auth",
			component: _f379a160,
			name: "auth"
		},
		{
			path: "/inspire",
			component: _3a667e80,
			name: "inspire"
		},
		{
			path: "/",
			component: _ded8b810,
			name: "index"
		}
    ],
    
    
    fallback: false
  })
}
