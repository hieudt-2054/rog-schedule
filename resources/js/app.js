import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '@/components/App'
import routes from '@/router/routes'
import Vuetify from 'vuetify'
import store from './store'
import VuePageTransition from 'vue-page-transition'
import VueSocialauth from 'vue-social-auth'
import VueAxios from 'vue-axios'
import axios from 'axios'
import VuetifyToast from 'vuetify-toast-snackbar'

Vue.use(VuePageTransition)
Vue.use(VueRouter)
Vue.use(Vuetify)
Vue.use(VueAxios, axios)
Vue.use(VueSocialauth, {
    providers: {
        google: {
            clientId: '231305375976-dbi9dm5tl921lag839uigau57gmnn1rh.apps.googleusercontent.com',
            redirectUri: 'http://localhost:2021/auth/google/callback', // Your client app URL
        },
    },
})
Vue.use(VuetifyToast)

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
