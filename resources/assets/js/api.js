import axios from 'axios'

let sprintf = require('sprintf-js').sprintf

const URL_MATCHES = '/api/match',
  URL_MATCH = '/api/match/',
  URL_MATCH_LEAVE = '/api/match/all/leave',
  URL_MATCH_PLAYER_REGISTER = '/api/match/%s/player',
  URL_MATCH_PLAYER_CURRENT = '/api/match/%s/player/session',
  URL_MOVE = '/api/match/',
  URL_CREATE = '/api/match',
  URL_DELETE = '/api/match/'

export default {
  matches: () => {
    return axios.get(URL_MATCHES)
  },
  match: ({id}) => {
    return axios.get(URL_MATCH + id)
  },
  leave: () => {
    return axios.put(URL_MATCH_LEAVE)
  },
  currentPlayer: ({id}) => {
    return axios.get(sprintf(URL_MATCH_PLAYER_CURRENT, id))
  },
  registerPlayer: ({player, match_id}) => {
    return axios.put(sprintf(URL_MATCH_PLAYER_REGISTER, match_id), {
      player: player
    })
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