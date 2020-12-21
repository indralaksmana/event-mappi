import state from './moduleEventListState.js'
import mutations from './moduleEventListMutations.js'
import actions from './moduleEventListActions.js'
import getters from './moduleEventListGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

