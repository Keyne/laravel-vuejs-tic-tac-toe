import axios from 'axios';

const URL_MATCHES = '/api/match',
    URL_MATCH = '/api/match/',
    URL_MOVE = '/api/match/',
    URL_CREATE = '/api/match',
    URL_DELETE = '/api/match/';

export default {
    matches: () => {
        return axios.get(URL_MATCHES)
    },
    match: ({id}) => {
        return axios.get(URL_MATCH + id)
    },
    move: ({id, position}) => {
        return axios.put(URL_MOVE + id, {
            position: position
        })
    },
    create: () => {
        return axios.post(URL_CREATE)
    },
    destroy: ({id}) => {
        return axios.delete(URL_DELETE + id)
    },
}