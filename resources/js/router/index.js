import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Orders from '../views/Orders.vue'
import Login from '../components/Login'
import Forgot from '../components/Forgot'
import Settings from "../views/Settings";
import Factories from "../views/Factories";
import Franchises from "../components/Franchises";

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/forgot',
    name: 'Forgot',
    component: Forgot
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  },
  {
    path: '/orders',
    name: 'Orders',
    component: Orders
  },
  {
    path: '/settings',
    name: 'Settings',
    component: Settings
  },
  {
    path: '/factories',
    name: 'Factories',
    component: Factories
    },
  {
    path: '/franchises',
    name: 'Franchises',
    component: Franchises
  }

]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
