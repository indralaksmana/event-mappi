import axios from '@/axios.js'

export default {
  addSector ({ commit }, sector) {
    return new Promise((resolve, reject) => {
      axios.post('/api/sector/add', {sector})
        .then((response) => {
          commit('ADD_SECTOR', Object.assign(sector, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchSectorItems ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/sector')
        .then((response) => {
          commit('SET_SECTORS', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateSector ({ commit }, sector) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/sector/edit/${sector.id}`, {sector})
        .then((response) => {
          commit('UPDATE_SECTOR', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeSector ({ commit }, sectorId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/sector/${sectorId}`)
        .then((response) => {
          commit('REMOVE_SECTOR', sectorId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeAllSector ({ commit }, sectorIds) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/sector/destroy`, {sectorIds})
        .then((response) => {
          commit('REMOVE_SECTORS', sectorIds)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
