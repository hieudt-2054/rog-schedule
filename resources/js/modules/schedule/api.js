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
}
