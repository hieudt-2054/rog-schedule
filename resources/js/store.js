import Vue from 'vue'
import Vuex from 'vuex'
import * as Cookies from 'js-cookie'
import auth from '@/modules/auth/store'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
    },
    plugins: [createPersistedState({
        paths: [
            'auth.token',
            'auth.user',
        ],
        getState: (key) => Cookies.getJSON(key),
        setState: (key, state) => Cookies.set(key, state, {
            expires: 3,
            secure: false,
        }),
    })],
})
