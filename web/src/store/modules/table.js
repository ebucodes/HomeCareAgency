// store/modules/table.js
export default {
  state: {
    items: [],
  },
  mutations: {
    setTableItems(state, items) {
      state.items = items;
    },
  },
};
