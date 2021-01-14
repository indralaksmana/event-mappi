/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from '@/axios.js'

export default {
  fetchEvents ({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/event/calendar')
        .then((response) => {
          commit('SET_EVENTS', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchEventDetail ({ commit }, id) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/event/detail/${id}`)
        .then((response) => {
          commit('SET_EVENT', response.data.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
