import axios from 'axios'

export default class ConfigAxios {
    /**
     * Set global axios authorization header
     *
     * @param tokenType
     * @param accessToken
     */
    static setAuthorizationHeader (tokenType = null, accessToken = null) {
        let authorization = ''

        if (tokenType && accessToken) {
            authorization = `${tokenType} ${accessToken}`
        }

        axios.defaults.headers.common.Authorization = authorization
    }
}
