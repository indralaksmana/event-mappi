export default {
  ADD_EVENT (state, event) {
    state.events.unshift(event)
  },
  SET_EVENTS (state, events) {
    state.events = events
  },
  // SET_LABELS(state, labels) {
  //   state.eventLabels = labels
  // },
  UPDATE_EVENT (state, event) {
    const eventIndex = state.events.findIndex((p) => p.id === event.id)
    Object.assign(state.events[eventIndex], event)
  },
  REMOVE_EVENT (state, eventId) {
    const EventIndex = state.events.findIndex((p) => p.id === eventId)
    state.events.splice(EventIndex, 1)
  }
}
