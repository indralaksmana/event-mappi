<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">

      <calendar-view
        ref="calendar"
        :displayPeriodUom="calendarView"
        :show-date="showDate"
        :events="simpleCalendarEvents"
        enableDragDrop
        :eventTop="windowWidth <= 400 ? '2rem' : '3rem'"
        eventBorderHeight="0px"
        eventContentHeight="1.65rem"
        class="theme-default"
        @click-event="openDetailEvent">

        <div slot="header" class="mb-4">

          <div class="vx-row no-gutter">

            <!-- Current Month -->
            <div class="vx-col sm:w-1/3 w-full sm:my-0 my-3 flex sm:justify-end justify-center order-last">
              <div class="flex items-center">
                <feather-icon
                  :icon="$vs.rtl ? 'ChevronRightIcon' : 'ChevronLeftIcon'"
                  @click="updateMonth(-1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />

                <span class="mx-3 text-xl font-medium whitespace-no-wrap">{{ showDate | month }}</span>

                <feather-icon
                  :icon="$vs.rtl ? 'ChevronLeftIcon' : 'ChevronRightIcon'"
                  @click="updateMonth(1)"
                  svgClasses="w-5 h-5 m-1"
                  class="cursor-pointer bg-primary text-white rounded-full" />
              </div>
            </div>

            <div class="vx-col sm:w-1/3 w-full flex justify-center">
              <template v-for="(view, index) in calendarViewTypes">
                <vs-button
                  v-if="calendarView === view.val"
                  :key="String(view.val) + 'filled'"
                  type="filled"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
                <vs-button
                  v-else
                  :key="String(view.val) + 'border'"
                  type="border"
                  class="p-3 md:px-8 md:py-3"
                  :class="{'border-l-0 rounded-l-none': index, 'rounded-r-none': calendarViewTypes.length !== index+1}"
                  @click="calendarView = view.val"
                  >{{ view.label }}</vs-button>
              </template>

            </div>
          </div>

        </div>
      </calendar-view>
    </div>

    <!-- DETAIL EVENT -->
    <vs-prompt
        class="calendar-event-dialog"
        title="Detail Event"
        button-cancel = "border"
        cancel-text = "Close"
        :is-valid="validForm"
        :active.sync="activePromptEditEvent"
        v-if="eventDetail !== undefined">

        <!-- NAME -->
        <div class="vs-component vs-con-input-label vs-input mt-0 w-full vs-input-primary">
          <label for="" class="vs-input--label">Name</label>
          <div class="vs-con-input">
            {{ eventDetail.name }}
          </div>
        </div>

        <!-- CATEGORY -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Category</label>
          <div class="vs-con-input">
            {{ eventDetail.category }}
          </div>
        </div>

        <!-- SECTOR -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Sector</label>
          <div class="vs-con-input">
            {{ eventDetail.sector }}
          </div>
        </div>

        <!-- STATUS -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Status</label>
          <div class="vs-con-input">
            <vs-chip :color="getEventStatusColor(eventDetail.status)" class="event-status">{{ parseInt(eventDetail.status, 0) === 1 ? 'Active' : 'Unactive' }}</vs-chip>
          </div>
        </div>

        <!-- START DATE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Start Date</label>
          <div class="vs-con-input">
            {{ $options.filters.date(eventDetail.startDate) }}
          </div>
        </div>

        <!-- END DATE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">End Date</label>
          <div class="vs-con-input">
            {{ $options.filters.date(eventDetail.endDate) }}
          </div>
        </div>

        <!-- TIME START -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Time Start</label>
          <div class="vs-con-input">
            {{ eventDetail.timeStart }}
          </div>
        </div>

        <!-- TIME END -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Time End</label>
          <div class="vs-con-input">
            {{ eventDetail.timeEnd }}
          </div>
        </div>

        <!-- PLACE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Place</label>
          <div class="vs-con-input">
            {{ eventDetail.place }}
          </div>
        </div>

        <!-- ORGANIZER -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Organizer</label>
          <div class="vs-con-input">
            {{ eventDetail.organizer }}
          </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Description</label>
          <div class="vs-con-input">
            {{ eventDetail.description }}
          </div>
        </div>

        <!-- TYPE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Type</label>
          <div class="vs-con-input">
            <vs-chip :color="getEventTypeColor(eventDetail.type)" class="event-type">{{ getTitleCase(eventDetail.type) }}</vs-chip>
          </div>
        </div>

        <!-- FOR USERS -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary" v-if="eventDetail.type !== 'public'">
          <label for="" class="vs-input--label">For Users</label>
          <div class="vs-con-input flex-row justify-content-left">
              <vs-chip color="danger" v-for="item in eventDetail.forUsers" :key="item.id">{{ item.label }}</vs-chip>
          </div>
        </div>

    </vs-prompt>
  </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from 'vue-simple-calendar'
import moduleCalendar from '@/store/calendar/moduleCalendar.js'
require('vue-simple-calendar/static/css/default.css')

import Datepicker from 'vuejs-datepicker'
import { en, he } from 'vuejs-datepicker/src/locale'

export default {
  components: {
    CalendarView,
    CalendarViewHeader,
    Datepicker
  },
  data () {
    return {
      showDate: new Date(),
      disabledFrom: false,
      id: 0,
      title: '',
      startDate: '',
      endDate: '',
      labelLocal: 'none',

      langHe: he,
      langEn: en,

      url: '',
      calendarView: 'month',

      activePromptAddEvent: false,
      activePromptEditEvent: false,

      calendarViewTypes: [
        {
          label: 'Month',
          val: 'month'
        },
        {
          label: 'Week',
          val: 'week'
        },
        {
          label: 'Year',
          val: 'year'
        }
      ]
    }
  },
  computed: {
    simpleCalendarEvents () {
      return this.$store.state.calendar.events
    },
    validForm () {
      return this.title !== '' && this.startDate !== '' && this.endDate !== '' && Date.parse(this.endDate) - Date.parse(this.startDate) >= 0 && !this.errors.has('event-url')
    },
    disabledDatesTo () {
      return { to: new Date(this.startDate) }
    },
    disabledDatesFrom () {
      return { from: new Date(this.endDate) }
    },
    labelColor () {
      return (label) => {
        if      (label === 'business') return 'success'
        else if (label === 'work')     return 'warning'
        else if (label === 'personal') return 'danger'
        else if (label === 'none')     return 'primary'
      }
    },
    windowWidth () {
      return this.$store.state.windowWidth
    },
    eventDetail () {
      return this.$store.state.calendar.event
    }
  },
  methods: {
    updateMonth (val) {
      this.showDate = this.$refs.calendar.getIncrementedPeriod(val)
    },
    clearFields () {
      this.title = this.endDate = this.url = ''
      this.id = 0
      this.labelLocal = 'none'
    },
    promptAddNewEvent (date) {
      this.disabledFrom = false
      this.addNewEventDialog(date)
    },
    addNewEventDialog (date) {
      this.clearFields()
      this.startDate = date
      this.endDate = date
      this.activePromptAddEvent = true
    },
    openAddNewEvent (date) {
      this.disabledFrom = true
      this.addNewEventDialog(date)
    },
    openDetailEvent (event) {
      this.$store.dispatch('calendar/fetchEventDetail', event.id)
      this.activePromptEditEvent = true
    },
    getEventStatusColor (status) {
      if (parseInt(status) === 1) return 'success'
      if (parseInt(status) === 0)  return 'danger'
    },
    getEventTypeColor (type) {
      if (type === 'public') return 'primary'
      if (type === 'specific')  return 'warning'
    },
    getTitleCase (str = '') {
      return str.toLowerCase().split(' ').map(function (word) {
        return (word.charAt(0).toUpperCase() + word.slice(1))
      }).join(' ')
    }
  },
  created () {
    this.$store.registerModule('calendar', moduleCalendar)
    this.$store.dispatch('calendar/fetchEvents')
  },
  beforeDestroy () {
    this.$store.unregisterModule('calendar')
  }
}
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";

.con-vs-dialog {

.vs-dialog {

    footer {
      
      .vs-dialog-accept-button {
        display: none;
      }

    }

  }

}

.vs-con-input {
  padding-left: 5px;
  font-weight: bold;
}

.vs-dialog-text {
  overflow-x: auto;
}

.flex-row {
  flex-direction: row;
}
.justify-content-left {
  justify-content: left !important;
}
</style>
