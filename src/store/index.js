import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {

    callID: "",

      empID: null,
      lastEmpID: null,
      empName: "",
      empLastName: "",
      cooldown: false,
      confirmation: "",

  },
  getters: {},
  mutations: {},
  actions: {},
  modules: {},
})
