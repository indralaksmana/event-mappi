export default {
  ADD_USER (state, user) {
    state.users.unshift(user)
  },
  SET_USERS (state, users) {
    state.users = users
  },
  UPDATE_USER (state, user) {
    const userIndex = state.users.findIndex((p) => p.id === user.id)
    Object.assign(state.users[userIndex], user)
  },
  REMOVE_USER (state, userId) {
    const userIndex = state.users.findIndex((p) => p.id === userId)
    state.users.splice(userIndex, 1)
  },
  REMOVE_USERS (state, userIds) {
    userIds.map(userId => {
      const userIndex = state.users.findIndex((p) => p.id === userId)
      state.users.splice(userIndex, 1)
    })
  }
}
