import axios from '@/axios.js'

export default {
  addCategory ({ commit }, category) {
    return new Promise((resolve, reject) => {
      axios.post('/api/category/add', {category})
        .then((response) => {
          commit('ADD_CATEGORY', Object.assign(category, {id: response.data.id}))
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchCategoryItems ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/category')
        .then((response) => {
          commit('SET_CATEGORIES', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateCategory ({ commit }, category) {
    return new Promise((resolve, reject) => {
      axios.put(`/api/category/edit/${category.id}`, {category})
        .then((response) => {
          commit('UPDATE_CATEGORY', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeCategory ({ commit }, categoryId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/category/${categoryId}`)
        .then((response) => {
          commit('REMOVE_CATEGORY', categoryId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeAllCategory ({ commit }, categoryIds) {
    return new Promise((resolve, reject) => {
      axios.post('/api/category/destroy', {categoryIds})
        .then((response) => {
          commit('REMOVE_CATEGORIES', categoryIds)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
