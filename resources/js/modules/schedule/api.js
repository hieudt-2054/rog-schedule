import axios from 'axios'

export default class ScheduleService {
    /**
     * @returns {AxiosPromise<any>}
     */
    static getAll () {
        return axios.get('/api/schedule')
            .then(response => response)
            .catch(error => error.response)
    }

    /**
     * @param { object } schedule
     *
     * @returns {AxiosPromise<any>}
     */
    static store (payload) {
        return axios.post('/api/schedule', payload)
    }

    static destroy (payload) {
        return axios.delete(`/api/schedule/${payload}`)
    }
}
