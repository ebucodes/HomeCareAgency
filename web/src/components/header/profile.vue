<template>
  <li class="profile-nav onhover-dropdown pe-0 py-0">
    <div class="media profile-media">
      <img class="b-r-10" src="@/assets/images/dashboard/profile.png" alt="" />
      <div class="media-body">
        <span>{{ this.$store.getters?.getUser?.firstName + ' ' + this.$store.getters?.getUser?.lastName }}</span>
        <!-- <span>{{ this.$store.getters.getUser?.firstName }}</span> -->
        <p class="mb-0 font-roboto text-uppercase">
          {{ this.$store.state.auth.role }} <i class="middle fa fa-angle-down"></i>
        </p>
      </div>
    </div>
    <ul class="profile-dropdown onhover-show-div">
      <!-- <li>
        <vue-feather type="user"></vue-feather><span>Account </span>
      </li>
      <li>
        <vue-feather type="mail"></vue-feather><span>Inbox</span>
      </li>
      <li>
        <vue-feather type="file-text"></vue-feather><span>Taskboard</span>
      </li> -->
      <li>
      </li>
      <li @click="logout">
        <vue-feather type="log-in"></vue-feather><span>Log out</span>
      </li>
    </ul>
  </li>
</template>

<script>
// import firebase from 'firebase';
// import UserAuth from '@/store/module/auth';

export default {
  name: 'Profile',
  methods: {
    logout() {
      // firebase
      //   .auth()
      //   .signOut()
      //   .then(() => {
      //     UserAuth.Logout();
      // this.$router.replace('/auth/login');
      // localStorage.removeItem('User')

      localStorage.removeItem("HCA_TOKEN");
      localStorage.removeItem("HCA_LOGGER");
      localStorage.removeItem("HCA_ROLE");
      this.$router.replace('/');
    }
    // },
  },
};
</script>
