import AuthService from './api'
import ConfigAxios from '@/config/axios'

const AUTH_SET_USER = 'AUTH_SET_USER'
const AUTH_SET_ERROR = 'AUTH_SET_ERROR'
const AUTH_SET_TOKEN = 'AUTH_SET_TOKEN'
const AUTH_SET_LOADING = 'AUTH_SET_LOADING'

const state = {
    user: null,
    token: null,
    error: '',
    loading: false,
}

const getters = {
    isLoggedIn (state) {
        return !!state.token
    },
}

const mutations = {
    [AUTH_SET_LOADING] (state, isLoading) {
        state.loading = isLoading
    },

    [AUTH_SET_TOKEN] (state, token) {
        state.token = token
    },

    [AUTH_SET_USER] (state, user) {
        state.user = user
    },

    [AUTH_SET_ERROR] (state, error) {
        state.error = error
    },
}

const actions = {
    async login ({ commit }, payloads) {
        commit(AUTH_SET_LOADING, true)
        try {
            const loginResponse = await AuthService.login(payloads.params)
            const token = loginResponse.data
            ConfigAxios.setAuthorizationHeader('Bearer', token.access_token)
            commit(AUTH_SET_TOKEN, token)
        } catch (e) {
            const errors = e.response.data.errors
            if (errors) {
                commit(AUTH_SET_ERROR, errors)
            } else {
                commit(AUTH_SET_ERROR, e.response.data)
            }
        }
        commit(AUTH_SET_LOADING, false)
    },

    async setToken ({ commit }, data) {
        try {
            ConfigAxios.setAuthorizationHeader(data.data.token_type, data.data.access_token)
            commit(AUTH_SET_TOKEN, data.data)
        } catch (e) {
            commit(AUTH_SET_ERROR, e.response.data.message)
        }
    },

    async register ({ commit }, payloads) {
        commit(AUTH_SET_LOADING, true)
        try {
            const registerResponse = await AuthService.register(payloads.params)
            const token = registerResponse.data
            ConfigAxios.setAuthorizationHeader('Bearer', token.access_token)
            commit(AUTH_SET_TOKEN, token)
        } catch (e) {
            const errors = e.response.data.errors
            if (errors) {
                commit(AUTH_SET_ERROR, errors)
            } else {
                commit(AUTH_SET_ERROR, e.response.data)
            }
        }
        commit(AUTH_SET_LOADING, false)
    },

    async logout ({ commit }) {
        commit(AUTH_SET_LOADING, true)
        try {
            await AuthService.logout()
            commit(AUTH_SET_TOKEN, null)
            commit(AUTH_SET_USER, null)
        } catch (e) {
            commit(AUTH_SET_ERROR, e.response.data.message)
        }
        commit(AUTH_SET_LOADING, false)
    },
}

export default {
    state,
    getters,
    mutations,
    actions,
    namespaced: true,
}
