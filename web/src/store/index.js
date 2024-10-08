import {
  createStore
} from 'vuex'

// import 'es6-promise/auto';
import layout from './modules/layout';
import menu from './modules/menu';
import auth from './modules/auth';
import tableModule from './modules/table';
// import chat from './modules/chat';
// import product from './modules/product';
// import email from './modules/email';
// import todo from './modules/todo';
// import firebase_todo from './modules/firebase_todo';
// import contact from './modules/contact';
// import jobs from './modules/jobs';
// import courses from './modules/courses';
// import common from './modules/common';
// import tags from './modules/tags';
// import calendar from './modules/calendar'
// import { alert } from './modules/alert';
// import { authentication } from './modules/authentication';
// import { users } from './modules/users';

export default createStore({
  state: {
    langIcon: '',
    langLangauge: '',
    isActive: false
  },
  getters: {
    langIcon: (state) => {
      return state.langIcon
    },
    langLangauge: (state) => {
      return state.langLangauge
    }
  },
  mutations: {
    changeLang(state, payload) {
      localStorage.setItem('currentLanguage', payload.id);
      localStorage.setItem('currentLanguageIcon', payload.icon);
      state.langIcon = payload.icon || 'flag-icon-us'
      state.langLangauge = payload.id || 'EN'
      // window.location.reload();
    },
    change(state) {
      state.isActive = !state.isActive
    }
  },
  actions: {
    setLang({
      commit
    }, payload) {
      commit('changeLang', payload);

    }
  },
  modules: {
    layout,
    menu,
    auth,
    table: tableModule,
  }
});