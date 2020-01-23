import axios from 'axios'

export default class AuthService {
    /**
     * @param { object } user
     *
     * @returns {AxiosPromise<any>}
     */
    static login (credentials) {
        return axios.post('/api/login', {
            email: credentials.email,
            password: credentials.password,
        })
    }

    /**
     * @param { object } user
     *
     * @returns {AxiosPromise<any>}
     */
    static register (payload) {
        return axios.post('/api/register', payload)
    }

    /**
     * @returns {AxiosPromise<any>}
     */
    static logout () {
        return axios.post('/api/logout')
            .then(response => response)
            .catch(error => error.response)
    }
}
