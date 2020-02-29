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

    /**
     * @returns {AxiosPromise<any>}
     */
    static generate2FA () {
        return axios.post('/api/generate2FA')
    }

    /**
     * @returns {AxiosPromise<any>}
     */
    static get2FA () {
        return axios.get('/api/get2FA')
            .then(response => response)
            .catch(error => error.response)
    }

    /**
     * @returns {AxiosPromise<any>}
     */
    static enable2FA (payload) {
        return axios.post('/api/enable2FA', payload)
    }
}
