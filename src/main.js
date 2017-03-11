import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
const router = new VueRouter({
  mode: 'history',
  routes: [{
    path: '/',
    component: require('./components/Main.vue'),
    name: 'root'
  }, {
    path: '/match',
    component: require('./components/Match.vue'),
    name: 'match'
  }, {
    path: '/loginUser',
    component: require('./components/LoginUser.vue'),
     name: 'loginUser'
   },{
    path: '/profileUser',
    component: require('./components/ProfileUser.vue'),
    name: 'profileUser'
  },
  {
    path: '*',
    redirect: '/'
  }]
})
/*
import App from './App.vue'
*/
new Vue({
  el: '#app',
  router,
  render: h => h(require('./App.vue'))
})
