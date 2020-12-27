import axios from '@/axios.js'

export default {
  addEvent ({ commit }, event) {
    return new Promise((resolve, reject) => {
      axios.post('/api/event/add', {event})
        .then((response) => {
          commit('ADD_EVENT', Object.assign(event, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchEventListItems ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/event')
        .then((response) => {
          commit('SET_EVENTS', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateEvent ({ commit }, event) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/event/edit/${event.id}`, {event})
        .then((response) => {
          commit('UPDATE_EVENT', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeEvent ({ commit }, eventId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/event/${eventId}`)
        .then((response) => {
          commit('REMOVE_EVENT', eventId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
