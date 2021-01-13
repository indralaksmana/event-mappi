<template>
  <vs-sidebar click-not-close position-right parent="body" default-index="1" color="primary" class="add-new-data-sidebar items-no-padding" spacer v-model="isSidebarActiveLocal">
    <div class="mt-6 flex items-center justify-between px-6">
        <h4>{{ Object.entries(this.data).length === 0 ? "ADD NEW" : "UPDATE" }} USER</h4>
        <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component :is="scrollbarTag" class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">

      <div class="p-6">

        <!-- Product Image -->
        <template v-if="dataImg">

          <!-- Image Container -->
          <div class="img-container w-64 mx-auto flex items-center justify-center">
            <img :src="dataPreview === null ? dataImg : dataPreview" alt="img" class="responsive">
          </div>

          <!-- Image upload Buttons -->
          <div class="modify-img flex justify-between mt-5">
            <input type="file" class="hidden" ref="updateImgInput" @change="updateCurrImg" accept="image/*">
            <vs-button class="mr-4" type="flat" @click="$refs.updateImgInput.click()">Update Image</vs-button>
            <vs-button type="flat" color="#999" @click="dataImg = null">Remove Image</vs-button>
          </div>
          
        </template>

        <!-- NAME -->
        <vs-input label="Name" v-model="dataName" class="mt-5 w-full" name="user-name" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('user-name')">{{ errors.first('user-name') }}</span>

        <!-- EMAIl -->
        <vs-input label="Email" v-model="dataEmail" class="mt-5 w-full" name="user-email" v-validate="'required|email'" />
        <span class="text-danger text-sm" v-show="errors.has('user-email')">{{ errors.first('user-email') }}</span>

        <!-- PASSWORD -->
        <vs-input type="password" label="Password" v-model="dataPassword" class="mt-5 w-full" name="user-password" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('user-password')">{{ errors.first('user-password') }}</span>

        <!-- SECTOR -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Sector</label>
          <div class="vs-con-input">
            <v-select v-model="dataSector" :options="sector_choices" class="w-full" />
          </div>
        </div>

        <!-- DEPARTMENT -->
        <vs-input label="Department" v-model="dataDepartment" class="mt-5 w-full" name="user-department" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('user-department')">{{ errors.first('user-department') }}</span>

        <!-- ROLE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Role</label>
          <div class="vs-con-input">
            <v-select v-model="dataRole" :options="role_choices" class="w-full" />
          </div>
        </div>

        <!-- NOTE -->
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Note</label>
          <div class="vs-con-input">
            <vs-textarea v-model="dataNotes" />
          </div>
        </div>

        <!-- Upload -->
        <div class="upload-img mt-5" v-if="!dataImg">
          <input type="file" class="hidden" ref="uploadImgInput" @change="updateCurrImg" accept="image/*">
          <vs-button @click="$refs.uploadImgInput.click()">Upload Image</vs-button>
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
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'

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
      dataEmail: null,
      dataPassword: null,
      dataSector: [],
      dataNotes: null,
      dataImg: null,
      dataPreview: null,
      dataDepartment: null,
      dataRole: [],

      sector_choices: [],

      user_status_choices: [
        {text:'Unactive', value: 0},
        {text:'Active', value: 1}
      ],

      role_choices: [
        {id: 'admin', label: 'Admin'},
        {id: 'super_admin', label: 'Super Admin'}
      ],

      settings: { // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: .60
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
        const { _id, name, email, password, sector, notes, department, role, photo } = JSON.parse(JSON.stringify(this.data))
        this.dataId = _id
        this.dataEmail = email
        this.dataPassword = password
        this.dataName = name
        this.dataSector = sector
        this.dataNotes = notes
        this.dataDepartment = department
        this.dataRole = role
        this.dataImg = photo
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
      return !this.errors.any() && this.dataName && this.dataEmail
    },
    scrollbarTag () { return this.$store.getters.scrollbarTag },
    sectors () {
      return this.$store.state.sector.sectors
    }
  },
  methods: {
    initValues () {
      if (this.data._id) return
      this.dataId = null
      this.dataImg = null
      this.dataPreview = null
      this.dataName = null
      this.dataEmail = null
      this.dataPassword = null
      this.dataNotes = null
      this.dataDepartment = null
      this.dataRole = []
      this.sectors.map(sector => {
        this.sector_choices.push({
          id: sector._id,
          label: sector.name
        })  
      })
    },
    submitData () {
      this.$validator.validateAll().then(result => {
        if (result) {
          const obj = {
            name: this.dataName,
            email: this.dataEmail,
            password: this.dataPassword,
            sector: this.dataSector,
            notes: this.dataNotes,
            department: this.dataDepartment,
            role: this.dataRole
          }

          const formData = new FormData()
          formData.append('photo', this.dataImg)
          formData.append('data', JSON.stringify(obj))

          if (this.dataId !== null) {
            this.$store.dispatch('user/updateUser', { user: formData, id: this.dataId }).catch(err => { console.error(err) })
          } else {
            this.$store.dispatch('user/addUser', formData).catch(err => { console.error(err) })
          }

          this.$emit('closeSidebar')
          this.initValues()
          this.$store.dispatch('user/fetchUserItems')
        }
      })
    },
    updateCurrImg (input) {
      if (input.target.files && input.target.files[0]) {
        const reader = new FileReader()
        reader.onload = e => {
          this.dataPreview = e.target.result
          this.dataImg = input.target.files[0]
        }
        reader.readAsDataURL(input.target.files[0])
      }
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

.img-container {
  width: 10rem !important;
}
</style>
