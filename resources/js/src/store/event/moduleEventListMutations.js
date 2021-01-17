export default {
  ADD_EVENT (state, event) {
    state.events.unshift(event)
  },
  SET_EVENTS (state, events) {
    state.events = events
  },
  SET_NOTIFICATON_EVENTS (state, events) {
    state.eventNotifications = events
  },
  UPDATE_EVENT (state, event) {
    const eventIndex = state.events.findIndex((p) => p.id === event.id)
    Object.assign(state.events[eventIndex], event)
  },
  REMOVE_EVENT (state, eventId) {
    const eventIndex = state.events.findIndex((p) => p.id === eventId)
    state.events.splice(eventIndex, 1)
  },
  REMOVE_EVENTS (state, eventIds) {
    eventIds.map(eventId => {
      const eventIndex = state.events.findIndex((p) => p.id === eventId)
      state.events.splice(eventIndex, 1)
    })
  }
}
