<template>
  <vs-sidebar click-not-close position-right parent="body" default-index="1" color="primary" class="add-new-data-sidebar items-no-padding" spacer v-model="isSidebarActiveLocal">
    <div class="mt-6 flex items-center justify-between px-6">
        <h4>{{ Object.entries(this.data).length === 0 ? "ADD NEW" : "UPDATE" }} EVENT</h4>
        <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component :is="scrollbarTag" class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">

      <div class="p-6">

        <!-- NAME -->
        <vs-input label="Name" v-model="dataName" class="mt-5 w-full" name="event-name" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('event-name')">{{ errors.first('event-name') }}</span>

        <!-- CATEGORY -->
        <vs-input label="Category" v-model="dataCategory" class="mt-5 w-full" name="event-category" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('event-category')">{{ errors.first('event-category') }}</span>

        <!-- SECTOR -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Sector</label>
          <div class="vs-con-input">
            <v-select v-model="dataSector" :options="sector_choices" class="w-full" />
          </div>
        </div>

        <!-- STATUS -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Status</label>
          <div class="vs-con-input">
            <ul class="mt-1 ml-2">
              <li :key="item.value" v-for="item in event_status_choices" class="float-right mr-10">
                <vs-radio v-model="dataStatus" :vs-value="item.value">{{ item.text }}</vs-radio>
              </li>
            </ul>
          </div>
        </div>

        <!-- START DATE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Start Date</label>
          <div class="vs-con-input">
            <flat-pickr v-model="dataStartDate" class="w-full"/>
          </div>
        </div>

        <!-- END DATE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">End Date</label>
          <div class="vs-con-input">
            <flat-pickr v-model="dataEndDate" class="w-full"/>
          </div>
        </div>

        <!-- TIME -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Time</label>
          <div class="vs-con-input">
            <flat-pickr :config="configdateTimePicker" v-model="dataTime" class="w-full"/>
          </div>
        </div>

        <!-- PLACE -->
        <vs-input label="Place" v-model="dataPlace" class="mt-5 w-full" name="event-place" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('event-place')">{{ errors.first('event-place') }}</span>

        <!-- ORGANIZER -->
        <vs-input label="Organizer" v-model="dataOrganizer" class="mt-5 w-full" name="organizer-place" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('organizer-place')">{{ errors.first('organizer-place') }}</span>

        <!-- DESCRIPTION -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Description</label>
          <div class="vs-con-input">
            <vs-textarea v-model="dataDescription" />
          </div>
        </div>

      </div>
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button class="mr-6" @click="submitData" :disabled="!isFormValid">Submit</vs-button>
      <vs-button type="border" color="danger" @click="isSidebarActiveLocal = false">Cancel</vs-button>
    </div>
  </vs-sidebar>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import vSelect from 'vue-select'
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
  props: {
    isSidebarActive: {
      type: Boolean,
      required: true
    },
    data: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    VuePerfectScrollbar,
    'v-select': vSelect,
    flatPickr
  },
  data () {
    return {

      dataId: null,
      dataName: null,
      dataCategory: null,
      dataSector: [],
      dataStatus: '1',
      dataStartDate: null,
      dataEndDate: null,
      dataTime: null,
      dataPlace: null,
      dataOrganizer: null,
      dataDescription: null,

      sector_choices: [
        {id:'Dewan Pengurus Nasional', label:'Dewan Pengurus Nasional' },
        {id:'Dewan Pengawas Keuangan', label:'Dewan Pengawas Keuangan' },
        {id:'Puspenit', label:'Puspenit' },
        {id:'Direktur Eksekutif', label:'Direktur Eksekutif' },
        {id:'Bidang Hubungan Luar Negeri', label:'Bidang Hubungan Luar Negeri' },
        {id:'Bidang Keanggotaan', label:'Bidang Keanggotaan' },
        {id:'Bendahara', label:'Bendahara' },
        {id:'Sekretaris', label:'Sekretaris' },
        {id:'KPSPI', label:'KPSPI' },
        {id:'KUSP', label:'KUSP' },
        {id:'KP', label:'KP' },
        {id:'Kompartemen', label:'Kompartemen' },
        {id:'Biro Hukum dan Advokasi', label:'Biro Hukum dan Advokasi' },
        {id:'Riset dan Pengembangan', label:'Riset dan Pengembangan' },
        {id:'Rapat Anggota IKJPP', label:'Rapat Anggota IKJPP' },
        {id:'IKJPP', label:'IKJPP' },
        {id:'Musyawarah Daerah', label:'Musyawarah Daerah' },
        {id:'DPD', label:'DPD' },
      ],

      event_status_choices: [
        {text:'Unactive', value: 0},
        {text:'Active', value: 1}
      ],
      settings: { // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: .60
      },

      configdateTimePicker: {
        enableTime: true,
        enableSeconds: true,
        noCalendar: true
      }
    }
  },
  watch: {
    isSidebarActive (val) {
      if (!val) return
      if (Object.entries(this.data).length === 0) {
        this.initValues()
        this.$validator.reset()
      } else {
        const { _id, name, category, status, sector, startDate, endDate, time, place, organizer, description } = JSON.parse(JSON.stringify(this.data))
        this.dataId = _id
        this.dataCategory = category
        this.dataName = name
        this.dataSector = sector
        this.dataStatus = status
        this.dataStartDate = startDate
        this.dataEndDate = endDate
        this.dataTime = time
        this.dataPlace = place
        this.dataOrganizer = organizer
        this.dataDescription = description
      }
    }
  },
  computed: {
    isSidebarActiveLocal: {
      get () {
        return this.isSidebarActive
      },
      set (val) {
        if (!val) {
          this.$emit('closeSidebar')
          this.$validator.reset()
          this.initValues()
        }
      }
    },
    isFormValid () {
      return !this.errors.any() && this.dataName && this.dataCategory
    },
    scrollbarTag () { return this.$store.getters.scrollbarTag }
  },
  methods: {
    initValues () {
      if (this.data._id) return
      this.dataId = null
      this.dataName = null
      this.dataCategory = null
      this.dataSector = []
      this.dataStatus = '1'
      this.dataStartDate = null
      this.dataEndDate = null
      this.dataTime = null
      this.dataPlace = null
      this.dataOrganizer = null
      this.dataDescription = null
    },
    submitData () {
      this.$validator.validateAll().then(result => {
        if (result) {
          const obj = {
            name: this.dataName,
            category: this.dataCategory,
            sector: this.dataSector,
            status: this.dataStatus,
            startDate: this.dataStartDate,
            endDate: this.dataEndDate,
            time: this.dataTime,
            place: this.dataPlace,
            organizer: this.dataOrganizer,
            description: this.dataDescription,
          }

          if (this.dataId !== null) {
            obj.id = this.dataId
            this.$store.dispatch('eventList/updateEvent', obj).catch(err => { console.error(err) })
          } else {
            delete obj._id
            this.$store.dispatch('eventList/addEvent', obj).catch(err => { console.error(err) })
          }

          this.$emit('closeSidebar')
          this.initValues()
        }
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.add-new-data-sidebar {
  ::v-deep .vs-sidebar--background {
    z-index: 52010;
  }

  ::v-deep .vs-sidebar {
    z-index: 52010;
    width: 400px;
    max-width: 90vw;

    .img-upload {
      margin-top: 2rem;

      .con-img-upload {
        padding: 0;
      }

      .con-input-upload {
        width: 100%;
        margin: 0;
      }
    }
  }
}

.scroll-area--data-list-add-new {
    // height: calc(var(--vh, 1vh) * 100 - 4.3rem);
    height: calc(var(--vh, 1vh) * 100 - 16px - 45px - 82px);

    &:not(.ps) {
      overflow-y: auto;
    }
}
</style>
