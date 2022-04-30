import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LesliesLoginView from '../views/LesliesLoginView.vue'

Vue.use(VueRouter)





const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/Leslieslogin',
    name: 'Leslieslogin',
    component: LesliesLoginView
  },
]

const router = new VueRouter({
  routes
})

export default router
