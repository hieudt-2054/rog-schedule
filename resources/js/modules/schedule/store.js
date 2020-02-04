import ScheduleService from './api'

const SET_LIST_SCHEDULE = 'SET_LIST_SCHEDULE'
const LIST_SCHEDULE_ERROR = 'LIST_SCHEDULE_ERROR'
const LIST_SCHEDULE_SUCCESS = 'LIST_SCHEDULE_SUCCESS'
const AUTH_SET_LOADING = 'AUTH_SET_LOADING'
const STORE_SCHEDULE_SUCCESS = 'STORE_SCHEDULE_SUCCESS'
const STORE_SCHEDULE_ERROR = ' STORE_SCHEDULE_ERROR'

const state = {
    schedules: null,
    error: '',
    success: '',
    loading: false,
    storeError: false,
    storeSuccess: false,
}

const getters = {
}

const mutations = {
    [AUTH_SET_LOADING] (state, isLoading) {
        state.loading = isLoading
    },

    [SET_LIST_SCHEDULE] (state, schedules) {
        state.schedules = schedules
    },

    [LIST_SCHEDULE_ERROR] (state, error) {
        state.error = error
    },

    [LIST_SCHEDULE_SUCCESS] (state, success) {
        state.success = success
    },

    [STORE_SCHEDULE_ERROR] (state, error) {
        state.storeError = error
    },

    [STORE_SCHEDULE_SUCCESS] (state, success) {
        state.storeSuccess = success
    },
}

const actions = {
    async actionGetScheduleByUser ({ commit }) {
        commit(AUTH_SET_LOADING, true)
        try {
            const data = await ScheduleService.getAll()
            commit(SET_LIST_SCHEDULE, data.data)
        } catch (e) {
            const errors = e.response.data
            if (errors) {
                commit(LIST_SCHEDULE_ERROR, errors)
            } else {
                commit(LIST_SCHEDULE_ERROR, e.response.data)
            }
        }
        commit(AUTH_SET_LOADING, false)
    },

    async storeSchedule ({ commit }, payloads) {
        commit(AUTH_SET_LOADING, true)
        try {
            await ScheduleService.store(payloads.params)
            commit(STORE_SCHEDULE_SUCCESS, true)
        } catch (e) {
            const errors = e.response.data
            if (errors) {
                commit(LIST_SCHEDULE_ERROR, errors)
            } else {
                commit(LIST_SCHEDULE_ERROR, e.response.data)
            }
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
