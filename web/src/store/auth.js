// auth.js

import axios from 'axios';

const state = {
  user: null,
  token: null,
  isLoggedIn: false,
};

const getters = {
  getUser: state => state.user,
  getToken: state => state.token,
  isLoggedIn: state => state.isLoggedIn,
};

const actions = {
  async login({ commit }, { username, password }) {
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
        username,
        password,
      });
      const { user, token } = response.data;
      commit('setUser', user);
      commit('setToken', token);
      commit('setLoggedIn', true);
    } catch (error) {
      throw new Error(error.response.data.message || 'Login failed');
    }
  },
  logout({ commit }) {
    commit('setUser', null);
    commit('setToken', null);
    commit('setLoggedIn', false);
  },
};

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setToken(state, token) {
    state.token = token;
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
