<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.name">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ getTitleCase(activeUserInfo.name) }}</p>
      <small>Available</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">
        <img v-if="activeUserInfo.photo" key="onlineImg" :src="activeUserInfo.photo" alt="user-img" width="40" height="40" class="rounded-full shadow-md cursor-pointer block" />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Logout</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>
 
<script>
export default {
  data () {
    return {

    }
  },
  computed: {
    activeUserInfo () { 
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    logout () {

      localStorage.removeItem('accessToken')
      localStorage.removeItem('userInfo')
      localStorage.clear()

      this.$router.push('/auth/login').catch(() => {})
    },
    getTitleCase (str) {
      return str.toLowerCase().split(' ').map(function (word) {
        return (word.charAt(0).toUpperCase() + word.slice(1))
      }).join(' ')
    }
  }
}
</script>
