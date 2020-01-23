import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '@/components/App'
import routes from '@/router/routes'
import Vuetify from 'vuetify'
import store from './store'
import VuePageTransition from 'vue-page-transition'

Vue.use(VuePageTransition)
Vue.use(VueRouter)
Vue.use(Vuetify)

const router = new VueRouter({
    mode: 'history',
    routes,
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        const isLoggedIn = store.getters['auth/isLoggedIn']

        if (!isLoggedIn) {
            return next({ path: '/login' })
        }
    }

    return next()
})

// eslint-disable-next-line no-new
new Vue({
    el: '#app',
    store,
    render: h => h(App),
    router,
    vuetify: new Vuetify(),
})
