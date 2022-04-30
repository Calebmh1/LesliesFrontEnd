import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {

    callID: "",

    empId: '',

    auth: false,
    session: "",
    empInfo: [
      {
        empName: "",
        empLastName: "",
      }
    ],
    user: {
      fname: "",
      lname: "",
      email: "",
      id: null,
    },
    students: [],
  },
  getters: {},
  mutations: {
    setAuth: function (state, payload) {
      state.auth = payload;
      state.session = payload.session;
    },
    empLogin: function (state, payload) {
      state.empId = payload.empId;
      state.empName = payload.empName;
      state.empLastName = payload.empLastName;
    }
  },
  actions: {},
  modules: {}
})
