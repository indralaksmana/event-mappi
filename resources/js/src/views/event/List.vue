<template>
  <div id="data-list-list-view" class="data-list-container">

    <vx-card class="mb-10" title="Filters">
      <div class="vx-row">
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <label class="text-sm opacity-75">Category</label>
          <v-select :options="categoryOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="categoryFilter" @input="filterEvents" class="mb-4 md:mb-0" />
        </div>
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <label class="text-sm opacity-75">Status</label>
          <v-select :options="statusOptions" :clearable="false" :dir="$vs.rtl ? 'rtl' : 'ltr'" v-model="statusFilter" @input="filterEvents" class="mb-4 md:mb-0" />
        </div>
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <vs-button type="border" color="danger" icon-pack="feather" icon="icon-refresh-cw" class="mt-6" @click="resetFilter">Reset</vs-button>
        </div>
      </div>
    </vx-card>
    
    <form-sidebar :isSidebarActive="addNewDataSidebar" @closeSidebar="toggleDataSidebar" :data="sidebarData" />

    <vs-table ref="table" multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="events">

      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">

        <div class="flex flex-wrap-reverse items-center data-list-btn-container">

          <!-- ACTION - DROPDOWN -->
          <vs-dropdown vs-trigger-click class="dd-actions cursor-pointer mr-4 mb-4">

            <div class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-32 w-full">
              <span class="mr-2">Actions</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>

            <vs-dropdown-menu>

              <vs-dropdown-item @click.stop="destroyConfirm">
                <span class="flex items-center">
                  <feather-icon icon="TrashIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Delete</span>
                </span>
              </vs-dropdown-item>

            </vs-dropdown-menu>
          </vs-dropdown>

          <!-- ADD NEW -->
          <div class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary" @click="addNewData">
              <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
              <span class="ml-2 text-base text-primary">Add New</span>
          </div>
        </div>

        <!-- ITEMS PER PAGE -->
        <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4 items-per-page-handler">
          <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
            <span class="mr-2">{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ events.length - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : events.length }} of {{ queriedItems }}</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
          <vs-dropdown-menu>

            <vs-dropdown-item @click="itemsPerPage=4">
              <span>4</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=15">
              <span>15</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=20">
              <span>20</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
        <vs-th sort-key="name">Name</vs-th>
        <vs-th sort-key="category">Category</vs-th>
        <vs-th sort-key="sector">Sector</vs-th>
        <vs-th sort-key="status">Status</vs-th>
        <vs-th sort-key="dateStart">Date Start</vs-th>
        <vs-th sort-key="dateEnd">Date End</vs-th>
        <vs-th sort-key="timeStart">Time Start</vs-th>
        <vs-th sort-key="timeEnd">Time End</vs-th>
        <vs-th sort-key="place">Place</vs-th>
        <vs-th sort-key="organizer">Organizer</vs-th>
        <vs-th sort-key="description">Description</vs-th>
        <vs-th sort-key="type">Type</vs-th>
        <vs-th>Action</vs-th>
      </template>

        <template slot-scope="{data}">
          <tbody>
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

              <vs-td>
                <p class="event-name font-medium truncate">{{ tr.name }}</p>
              </vs-td>

              <vs-td>
                <p class="event-category">{{ tr.category.label | title }}</p>
              </vs-td>

              <vs-td>
                <p class="event-sector font-medium truncate">{{ tr.sector.label }}</p>
              </vs-td>

              <vs-td>
                <vs-chip :color="getEventStatusColor(tr.status)" class="event-status">{{ parseInt(tr.status, 0) === 1 ? 'Active' : 'Unactive' }}</vs-chip>
              </vs-td>

              <vs-td>
                <p class="event-date-start">{{ tr.startDate}}</p>
              </vs-td>

              <vs-td>
                <p class="event-date-end">{{ tr.endDate }}</p>
              </vs-td>

              <vs-td>
                <p class="event-time-start">{{ tr.timeStart }}</p>
              </vs-td>

              <vs-td>
                <p class="event-time-end">{{ tr.timeEnd }}</p>
              </vs-td>

              <vs-td>
                <p class="event-place">{{ tr.place }}</p>
              </vs-td>

              <vs-td>
                <p class="event-organizer">{{ tr.organizer }}</p>
              </vs-td>

              <vs-td>
                <p class="event-description">{{ tr.description }}</p>
              </vs-td>

              <vs-td>
                <vs-chip :color="getEventTypeColor(tr.type)" class="event-type">{{ getTitleCase(tr.type) }}</vs-chip>
              </vs-td>

              <vs-td class="whitespace-no-wrap">
                <feather-icon icon="EditIcon" svgClasses="w-5 h-5 hover:text-primary stroke-current" @click.stop="editData(tr)" />
                <feather-icon icon="TrashIcon" svgClasses="w-5 h-5 hover:text-danger stroke-current" class="ml-2" @click.stop="deleteConfirm(tr._id)" />
              </vs-td>

            </vs-tr>
          </tbody>
        </template>
    </vs-table>
  </div>
</template>

<script>
import FormSidebar from './FormSidebar.vue'
import moduleEventList from '@/store/event/moduleEventList.js'
import moduleCategory from '@/store/category/moduleCategory.js'
import moduleSector from '@/store/sector/moduleSector.js'
import moduleUser from '@/store/user/moduleUser.js'
import vSelect from 'vue-select'

export default {
  components: {
    FormSidebar,
    vSelect
  },
  data () {
    return {
      selected: [],
      // events: [],
      itemsPerPage: 10,
      isMounted: false,

      // Data Sidebar
      addNewDataSidebar: false,
      sidebarData: {},
      activeConfirm: false,
      categoryFilter: { label: 'All', id: 'all' },
      categoryOptions: [],
      statusFilter: { label: 'All', id: 'all' },
      statusOptions: [
        { label:'Unactive', id: 0 },
        { label:'Active', id: 1 }
      ]
    }
  },
  computed: {
    currentPage () {
      if (this.isMounted) {
        return this.$refs.table.currentx
      }
      return 0
    },
    events () {
      return this.$store.state.eventList.events
    },
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.events.length
    },
    categories () {
      return this.$store.state.category.categories
    }
  },
  methods: {
    addNewData () {
      this.sidebarData = {}
      this.toggleDataSidebar(true)
    },
    deleteData (_id) {
      this.$store.dispatch('eventList/removeEvent', _id).catch(err => { console.error(err) })
    },
    editData (data) {
      this.sidebarData = data
      this.toggleDataSidebar(true)
    },
    getEventStatusColor (status) {
      if (parseInt(status) === 1) return 'success'
      if (parseInt(status) === 0)  return 'danger'
    },
    getEventTypeColor (type) {
      if (type === 'public') return 'primary'
      if (type === 'specific')  return 'warning'
    },
    getTitleCase (str) {
      return str.toLowerCase().split(' ').map(function (word) {
        return (word.charAt(0).toUpperCase() + word.slice(1))
      }).join(' ')
    },
    toggleDataSidebar (val = false) {
      this.addNewDataSidebar = val
    },
    deleteConfirm (id) {
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: 'Confirm',
        text: 'Are your sure to delete this event?',
        accept: this.acceptDelete,
        parameters: id 
      })
    },
    acceptDelete (id) {
      this.deleteData(id)
      this.$vs.notify({
        color: 'success',
        title: 'Deleted event',
        text: 'The selected event was successfully deleted'
      })
    },
    destroyConfirm () {
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: 'Confirm',
        text: 'Are your sure to delete these event?',
        accept: this.acceptDestroy
      })
    },
    acceptDestroy () {
      this.deleteAll()
      this.$vs.notify({
        color: 'success',
        title: 'Deleted event',
        text: 'All event was successfully deleted'
      })
    },
    deleteAll () {
      const ids = []
      this.selected.map(selected => {
        ids.push(selected._id)
      })
      this.$store.dispatch('eventList/removeAllEvent', ids).catch(err => { console.error(err) })
    },
    resetFilter () {
      this.categoryFilter = { label: 'All', id: 'all' }
      this.statusFilter = { label: 'All', id: 'all' }
      this.$store.dispatch('eventList/fetchEventListItems', '')
    },
    filterEvents () {
      this.$store.dispatch('eventList/fetchEventListItems', `?category=${this.categoryFilter.id}&status=${this.statusFilter.id}`)
    }
  },
  created () {
    if (!moduleEventList.isRegistered) {
      this.$store.registerModule('eventList', moduleEventList)
      moduleEventList.isRegistered = true
    }
    if (!moduleSector.isRegistered) {
      this.$store.registerModule('sector', moduleSector)
      moduleSector.isRegistered = true
    }
    if (!moduleUser.isRegistered) {
      this.$store.registerModule('user', moduleUser)
      moduleUser.isRegistered = true
    }
    if (!moduleCategory.isRegistered) {
      this.$store.registerModule('category', moduleCategory)
      moduleCategory.isRegistered = true
    }
    this.$store.dispatch('eventList/fetchEventListItems', '')
    this.$store.dispatch('sector/fetchSectorItems')
    this.$store.dispatch('user/fetchUserItems')
    this.$store.dispatch('category/fetchCategoryItems').then(() => {
      this.categories.map(category => {
        this.categoryOptions.push({
          id: category._id,
          label: category.name
        })
      })
    })
  },
  mounted () {
    this.isMounted = true
  }
}
</script>

<style lang="scss">
#data-list-list-view {
  .vs-con-table {

    /*
      Below media-queries is fix for responsiveness of action buttons
      Note: If you change action buttons or layout of this page, Please remove below style
    */
    @media (max-width: 689px) {
      .vs-table--search {
        margin-left: 0;
        max-width: unset;
        width: 100%;

        .vs-table--search-input {
          width: 100%;
        }
      }
    }

    @media (max-width: 461px) {
      .items-per-page-handler {
        display: none;
      }
    }

    @media (max-width: 341px) {
      .data-list-btn-container {
        width: 100%;

        .dd-actions,
        .btn-add-new {
          width: 100%;
          margin-right: 0 !important;
        }
      }
    }

    .product-name {
      max-width: 23rem;
    }

    .vs-table--header {
      display: flex;
      flex-wrap: wrap;
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      > span {
        display: flex;
        flex-grow: 1;
      }

      .vs-table--search{
        padding-top: 0;

        .vs-table--search-input {
          padding: 0.9rem 2.5rem;
          font-size: 1rem;

          &+i {
            left: 1rem;
          }

          &:focus+i {
            left: 1rem;
          }
        }
      }
    }

    .vs-table {
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      padding: 0 1rem;

      tr{
          box-shadow: 0 4px 20px 0 rgba(0,0,0,.05);
          td{
            padding: 20px;
            &:first-child{
              border-top-left-radius: .5rem;
              border-bottom-left-radius: .5rem;
            }
            &:last-child{
              border-top-right-radius: .5rem;
              border-bottom-right-radius: .5rem;
            }
          }
          td.td-check{
            padding: 20px !important;
          }
      }
    }

    .vs-table--thead{
      th {
        padding-top: 0;
        padding-bottom: 0;

        .vs-table-text{
          text-transform: uppercase;
          font-weight: 600;
        }
      }
      th.td-check{
        padding: 0 15px !important;
      }
      tr{
        background: none;
        box-shadow: none;
      }
    }

    .vs-table--pagination {
      justify-content: center;
    }
  }
}
</style>
