import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '@/components/App'
import routes from '@/router/routes'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes,
})

// eslint-disable-next-line no-new
new Vue({
    el: '#app',
    render: h => h(App),
    router,
})
