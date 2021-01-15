<template>
  <div id="data-list-list-view" class="data-list-container">

    <form-sidebar :isSidebarActive="addNewDataSidebar" @closeSidebar="toggleDataSidebar" :data="sidebarData" />

    <vs-table ref="table" multiple v-model="selected" pagination :max-items="itemsPerPage" search :data="users">

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
            <span class="mr-2">{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ users.length - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : users.length }} of {{ queriedItems }}</span>
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
        <vs-th sort-key="email">Email</vs-th>
        <vs-th sort-key="sector">Sector</vs-th>
        <vs-th sort-key="department">Department</vs-th>
        <vs-th sort-key="role">Role</vs-th>
        <vs-th sort-key="notes">Notes</vs-th>
        <vs-th>Action</vs-th>
      </template>

        <template slot-scope="{data}">
          <tbody>
            <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">

              <vs-td>
                <p class="user-name font-medium truncate">{{ tr.name }}</p>
              </vs-td>

              <vs-td>
                <p class="user-email">{{ tr.email }}</p>
              </vs-td>

              <vs-td>
                <p class="user-sector font-medium truncate">{{ tr.sector.label }}</p>
              </vs-td>

              <vs-td>
                <p class="user-department font-medium truncate">{{ tr.department }}</p>
              </vs-td>

              <vs-td>
                <p class="user-role">{{ tr.role.label}}</p>
              </vs-td>

              <vs-td>
                <p class="user-notes">{{ tr.notes }}</p>
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
import moduleSector from '@/store/sector/moduleSector.js'
import moduleUser from '@/store/user/moduleUser.js'
import moduleRole from '@/store/role/moduleRole.js'

export default {
  components: {
    FormSidebar
  },
  data () {
    return {
      selected: [],
      // users: [],
      itemsPerPage: 10,
      isMounted: false,

      // Data Sidebar
      addNewDataSidebar: false,
      sidebarData: {},
      activeConfirm: false
    }
  },
  computed: {
    currentPage () {
      if (this.isMounted) {
        return this.$refs.table.currentx
      }
      return 0
    },
    users () {
      return this.$store.state.user.users
    },
    queriedItems () {
      return this.$refs.table ? this.$refs.table.queriedResults.length : this.users.length
    }
  },
  methods: {
    addNewData () {
      this.sidebarData = {}
      this.toggleDataSidebar(true)
    },
    deleteData (_id) {
      this.$store.dispatch('user/removeUser', _id).catch(err => { console.error(err) })
    },
    editData (data) {
      this.sidebarData = data
      this.toggleDataSidebar(true)
    },
    getuserStatusColor (status) {
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
        text: 'Are your sure to delete this user?',
        accept: this.acceptDelete,
        parameters: id 
      })
    },
    acceptDelete (id) {
      this.deleteData(id)
      this.$vs.notify({
        color: 'success',
        title: 'Deleted user',
        text: 'The selected user was successfully deleted'
      })
    },
    destroyConfirm () {
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: 'Confirm',
        text: 'Are your sure to delete these user?',
        accept: this.acceptDestroy
      })
    },
    acceptDestroy () {
      this.deleteAll()
      this.$vs.notify({
        color: 'success',
        title: 'Deleted user',
        text: 'All user was successfully deleted'
      })
    },
    deleteAll () {
      const ids = []
      this.selected.map(selected => {
        ids.push(selected._id)
      })
      this.$store.dispatch('user/removeAllUser', ids).catch(err => { console.error(err) })
    }
  },
  created () {
    if (!moduleSector.isRegistered) {
      this.$store.registerModule('sector', moduleSector)
      moduleSector.isRegistered = true
    }
    if (!moduleUser.isRegistered) {
      this.$store.registerModule('user', moduleUser)
      moduleUser.isRegistered = true
    }
    if (!moduleRole.isRegistered) {
      this.$store.registerModule('role', moduleRole)
      moduleRole.isRegistered = true
    }
    this.$store.dispatch('sector/fetchSectorItems')
    this.$store.dispatch('user/fetchUserItems')
    this.$store.dispatch('role/fetchRoleItems')
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
