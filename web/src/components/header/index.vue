<template>
  <div class="header-wrapper row m-0">
    <Logo />

    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
      <ul class="nav-menus">
        <Profile />
      </ul>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import { Autoplay } from "swiper";
import "swiper/css";
import Profile from './profile';
import Logo from './logo.vue';

export default {
  //   name: 'Search',
  components: {
    Profile,
    Logo,
  },
  data() {
    return {
    };
  },
  computed: {
    ...mapState({
      menuItems: (state) => state.menu.searchData,
      megamenuItems: (state) => state.menu.megamenu,
      searchOpen: (state) => state.menu.searchOpen,
    }),
  },
  methods: {

  },
  setup() {
    return {
      modules: [Autoplay],
    };
  },
};
</script>
