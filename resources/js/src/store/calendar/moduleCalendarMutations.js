/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_EVENTS (state, events) {
    state.events = events
  },
  SET_EVENT (state, event) {
    const modEvent = {
      id: event._id,
      category: event.category,
      name: event.name,
      sector: event.sector.label,
      status: event.status,
      startDate: event.startDate,
      endDate: event.endDate,
      timeStart: event.timeStart,
      timeEnd: event.timeEnd,
      place: event.place,
      organizer: event.organizer,
      description: event.description,
      type: event.type,
      forUsers: event.forUsers
    }
    state.event = modEvent
  }
}
