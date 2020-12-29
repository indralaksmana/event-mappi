import state from './moduleSectorState.js'
import mutations from './moduleSectorMutations.js'
import actions from './moduleSectorActions.js'
import getters from './moduleSectorGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

