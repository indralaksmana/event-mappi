export default {
  ADD_ROLE (state, role) {
    state.roles.unshift(role)
  },
  SET_ROLES (state, roles) {
    state.roles = roles
  },
  UPDATE_ROLE (state, role) {
    const roleIndex = state.roles.findIndex((p) => p.id === role.id)
    Object.assign(state.roles[roleIndex], role)
  },
  REMOVE_ROLE (state, roleId) {
    const roleIndex = state.roles.findIndex((p) => p.id === roleId)
    state.roles.splice(roleIndex, 1)
  },
  REMOVE_ROLES (state, roleIds) {
    roleIds.map(roleId => {
      const roleIndex = state.roles.findIndex((p) => p.id === roleId)
      state.roles.splice(roleIndex, 1)
    })
  }
}
