import AuthService from './api'
import ConfigAxios from '@/config/axios'

const AUTH_SET_USER = 'AUTH_SET_USER'
const AUTH_SET_ERROR = 'AUTH_SET_ERROR'
const AUTH_SET_TOKEN = 'AUTH_SET_TOKEN'
const AUTH_SET_LOADING = 'AUTH_SET_LOADING'
const AUTH_SET_GOOGLE_2FA_STATE = 'AUTH_SET_GOOGLE_2FA_STATE'
const AUTH_SET_GOOGLE_2FA_DATA = 'AUTH_SET_GOOGLE_2FA_DATA'
const AUTH_SET_GOOGLE_2FA_FAIL = 'AUTH_SET_GOOGLE_2FA_ENABLE_FAIL'
const AUTH_SET_GOOGLE_2FA_SUCCESS = 'AUTH_SET_GOOGLE_2FA_ENABLE_SUCCESS'

const state = {
    user: null,
    token: null,
    error: '',
    loading: false,
    google2fa_success: false,
    google2fa_data: null,
    google2fa_enable_fail: false,
    google2fa_enable_success: false,
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

    [AUTH_SET_GOOGLE_2FA_STATE] (state, success) {
        state.google2fa_success = success
    },

    [AUTH_SET_GOOGLE_2FA_DATA] (state, data) {
        state.google2fa_data = data
    },

    [AUTH_SET_GOOGLE_2FA_FAIL] (state, status) {
        state.google2fa_enable_fail = status
    },

    [AUTH_SET_GOOGLE_2FA_SUCCESS] (state, status) {
        state.google2fa_enable_success = status
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
            const errors = e.response.data
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
            const errors = e.response.data
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
            commit(AUTH_SET_GOOGLE_2FA_STATE, false)
            commit(AUTH_SET_GOOGLE_2FA_DATA, null)
        } catch (e) {
            commit(AUTH_SET_ERROR, e.response.data.message)
        }
        commit(AUTH_SET_LOADING, false)
    },

    async generate2FA ({ commit }) {
        commit(AUTH_SET_LOADING, true)
        try {
            await AuthService.generate2FA()
            commit(AUTH_SET_GOOGLE_2FA_STATE, true)
        } catch (e) {
            const errors = e.response.data
            if (errors) {
                commit(AUTH_SET_ERROR, errors)
            } else {
                commit(AUTH_SET_ERROR, e.response.data)
            }
        }
        commit(AUTH_SET_LOADING, false)
    },

    async get2FA ({ commit }) {
        commit(AUTH_SET_LOADING, true)
        try {
            const response = await AuthService.get2FA()
            commit(AUTH_SET_GOOGLE_2FA_DATA, response.data)
        } catch (e) {
            const errors = e.response.data
            if (errors) {
                commit(AUTH_SET_ERROR, errors)
            } else {
                commit(AUTH_SET_ERROR, e.response.data)
            }
        }
        commit(AUTH_SET_LOADING, false)
    },

    async enable2FA ({ commit }, payloads) {
        AuthService.enable2FA(payloads)
            .then(res => {
                commit(AUTH_SET_GOOGLE_2FA_SUCCESS, true)
                commit(AUTH_SET_GOOGLE_2FA_FAIL, false)
            })
            .catch(e => {
                commit(AUTH_SET_GOOGLE_2FA_SUCCESS, false)
                commit(AUTH_SET_GOOGLE_2FA_FAIL, true)
            })
    },

    async refresh2faState ({ commit }) {
        commit(AUTH_SET_GOOGLE_2FA_SUCCESS, false)
        commit(AUTH_SET_GOOGLE_2FA_FAIL, false)
    },
}

export default {
    state,
    getters,
    mutations,
    actions,
    namespaced: true,
}
