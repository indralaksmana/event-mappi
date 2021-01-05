import axios from '@/axios.js'

export default {
  addUser ({ commit }, user) {
    return new Promise((resolve, reject) => {
      axios.post('/api/user/add', {user})
        .then((response) => {
          commit('ADD_USER', Object.assign(user, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchUserItems ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/user')
        .then((response) => {
          commit('SET_USERS', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateUser ({ commit }, user) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/user/edit/${user.id}`, {user})
        .then((response) => {
          commit('UPDATE_USER', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeUser ({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/user/${userId}`)
        .then((response) => {
          commit('REMOVE_USER', userId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeAllUser ({ commit }, userIds) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/user/destroy`, {userIds})
        .then((response) => {
          commit('REMOVE_USERS', userIds)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
