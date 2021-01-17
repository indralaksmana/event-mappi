import state from './moduleCategoryState.js'
import mutations from './moduleCategoryMutations.js'
import actions from './moduleCategoryActions.js'
import getters from './moduleCategoryGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

