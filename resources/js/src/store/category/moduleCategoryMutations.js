export default {
  ADD_CATEGORY (state, category) {
    state.categories.unshift(category)
  },
  SET_CATEGORIES (state, categories) {
    state.categories = categories
  },
  UPDATE_CATEGORY (state, category) {
    const categoryIndex = state.categories.findIndex((p) => p.id === category.id)
    Object.assign(state.categories[categoryIndex], category)
  },
  REMOVE_CATEGORY (state, categoryId) {
    const categoryIndex = state.categories.findIndex((p) => p.id === categoryId)
    state.categories.splice(categoryIndex, 1)
  },
  REMOVE_CATEGORIES (state, categoryIds) {
    categoryIds.map(categoryId => {
      const categoryIndex = state.categories.findIndex((p) => p.id === categoryId)
      state.categories.splice(categoryIndex, 1)
    })
  }
}
