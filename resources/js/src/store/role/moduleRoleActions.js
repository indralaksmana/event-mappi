import axios from '@/axios.js'

export default {
  addRole ({ commit }, role) {
    return new Promise((resolve, reject) => {
      axios.post('/api/role/add', {role})
        .then((response) => {
          commit('ADD_ROLE', Object.assign(role, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchRoleItems ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/role')
        .then((response) => {
          commit('SET_ROLES', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateRole ({ commit }, role) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/role/edit/${role.id}`, {role})
        .then((response) => {
          commit('UPDATE_ROLE', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRole ({ commit }, roleId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/role/${roleId}`)
        .then((response) => {
          commit('REMOVE_ROLE', roleId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeAllRole ({ commit }, roleIds) {
    return new Promise((resolve, reject) => {
      axios.post('/api/role/destroy', {roleIds})
        .then((response) => {
          commit('REMOVE_ROLES', roleIds)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
