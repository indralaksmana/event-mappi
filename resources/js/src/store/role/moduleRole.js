import state from './moduleRoleState.js'
import mutations from './moduleRoleMutations.js'
import actions from './moduleRoleActions.js'
import getters from './moduleRoleGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

