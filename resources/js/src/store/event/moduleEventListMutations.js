export default {
  ADD_EVENT (state, event) {
    state.events.unshift(event)
  },
  SET_EVENTS (state, events) {
    state.events = events
  },
  UPDATE_EVENT (state, event) {
    const eventIndex = state.events.findIndex((p) => p.id === event.id)
    Object.assign(state.events[eventIndex], event)
  },
  REMOVE_EVENT (state, eventId) {
    const EventIndex = state.events.findIndex((p) => p.id === eventId)
    state.events.splice(EventIndex, 1)
  },
  REMOVE_EVENTS (state, eventIds) {
    eventIds.map(eventId => {
      const EventIndex = state.events.findIndex((p) => p.id === eventId)
      state.events.splice(EventIndex, 1)
    })
  }
}
