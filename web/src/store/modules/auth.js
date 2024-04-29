// auth.js

// import axios from 'axios';
import axios from "@/utils/axiosHttp";
import router from "@/router";

const state = {
  user: localStorage.getItem('HCA_LOGGER'),
  token: localStorage.getItem('HCA_TOKEN'),
  role: localStorage.getItem('HCA_ROLE'),
  isLoggedIn: false,
};

const getters = {
  getUser: state => JSON.parse(atob(state.user)),
  getToken: state => state.token,
  isLoggedIn: state => state.isLoggedIn,
};

const actions = {
  async loginAsync({ commit, state }, payload) {

    
    try {
      const response = await axios.post('/auth/login', payload)
              .then((res) => {
                  return res.data;
              });
      if (response) {


        localStorage.setItem("HCA_TOKEN", response?.data?.authorization?.token);
        localStorage.setItem("HCA_LOGGER", btoa(JSON.stringify(response?.data?.user)));
        localStorage.setItem("HCA_ROLE", response?.data?.user?.role);
        
        // console.log(response?.data)

        commit('setUser', btoa(JSON.stringify(response?.data?.user)));
        commit('setToken', response?.data.authorization?.token);
        commit('setRole', response?.data.user?.role);
        commit('setLoggedIn', true);

        state.role

        // window.location.href = `${VITE_API_WEB}/dashboard`
        // window.location.href = `${import.meta.env.VITE_API_WEB}${state.role}/dashboard`

        router.push(`${state.role}/dashboard`)

      }
      return response;
      // const { user, token } = response.data;

    } catch (error) {
      // throw new Error(error.response || 'Login failed');
    }
    
  },
  
  logout({ commit }) {
    localStorage.removeItem("HCA_TOKEN");
    localStorage.removeItem("HCA_LOGGER");
    localStorage.removeItem("HCA_ROLE");
    commit('setUser', null);
    commit('setToken', null);
    commit('setLoggedIn', false);
    window.location.href = `${import.meta.env.VITE_API_WEB}`
  },
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setToken(state, token) {
    state.token = token;
  },
  setRole(state, role) {
    state.role = role;
  },
  setLoggedIn(state, status) {
    state.isLoggedIn = status;
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
