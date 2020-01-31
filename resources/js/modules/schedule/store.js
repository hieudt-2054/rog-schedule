import ScheduleService from './api'

const SET_LIST_SCHEDULE = 'SET_LIST_SCHEDULE'
const LIST_SCHEDULE_ERROR = 'LIST_SCHEDULE_ERROR'
const LIST_SCHEDULE_SUCCESS = 'LIST_SCHEDULE_SUCCESS'
const AUTH_SET_LOADING = 'AUTH_SET_LOADING'

const state = {
    schedules: null,
    error: '',
    success: '',
    loading: false,
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
}

export default {
    state,
    getters,
    mutations,
    actions,
    namespaced: true,
}
