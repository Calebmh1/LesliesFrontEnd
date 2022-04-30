import Vue from 'vue'
import VueRouter from 'vue-router'
import LesliesLoginView from '../views/LesliesLoginView.vue'
import LesliesPunchView from '../views/LesliesPunchView.vue'

Vue.use(VueRouter)





const routes = [
  {
    path: '/',
    name: 'home',
    component: LesliesLoginView
  },
  {
    path: '/lesliesPunch',
    name: 'lesliesPunch',
    component: LesliesPunchView
  }
]

const router = new VueRouter({
  routes
})

export default router
